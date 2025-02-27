<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\AdditionalRooms;
use App\Models\Currency;
use App\Models\Customers;
use App\Models\Hotel;
use App\Models\Market;
use App\Models\MealPlan;
use App\Models\PaxSlab;
use App\Models\Quotation;
use App\Models\QuotationAccommodation;
use App\Models\QuotationPaxSlab;
use App\Models\QuotationTravelPlan;
use App\Models\RoomCategory;
use App\Models\TravelRoute;
use App\Models\VehicleType;
use App\Models\MarkUpValue;
use App\Models\Driver;
use App\Models\Guide;
use Illuminate\Http\Request;
use App\Models\QuotationAccommodationRoomDetails;
use App\Models\QuotationSiteSeeing;
use App\Models\QuotationExtra;
use App\Models\QuotationJeepCharge;
use App\Models\TempBookRef;

class QuotationController extends Controller
{
    private function getNavigation($currentStep, $quotationId = null, $isEditing = false)
    {
        $steps = [
            'step1' => [
                'back' => route('quotations.index'),
                'next' => $quotationId ? route('quotations.step2', ['id' => $quotationId]) : '#',
                'title' => 'Basic Information',
                'number' => 1,
                'submit_text' => $isEditing ? 'Update & Next' : 'Start Quote',
            ],
            'step2' => [
                'back' => $isEditing ? route('quotations.edit_step_one', $quotationId) : route('quotations.step_one'),
                'next' => $quotationId ? route('quotations.step3', ['id' => $quotationId]) : '#',
                'title' => 'Pax Slab Details',
                'number' => 2,
                'submit_text' => $isEditing ? 'Update & Next' : 'Save & Next',
            ],
            'step3' => [
                'back' => $quotationId ? ($isEditing ? route('quotations.edit_step_two', $quotationId) : route('quotations.step2', ['id' => $quotationId])) : '#',
                'next' => $quotationId ? route('quotations.step4', ['id' => $quotationId]) : '#',
                'title' => 'Accommodation Details',
                'number' => 3,
                'submit_text' => $isEditing ? 'Update & Next' : 'Save & Next',
            ],
            'step4' => [
                'back' => $quotationId ? ($isEditing ? route('quotations.edit_step_three', $quotationId) : route('quotations.step3', ['id' => $quotationId])) : '#',
                'next' => $quotationId ? route('quotations.step5', ['id' => $quotationId]) : '#',
                'title' => 'Travel Plans',
                'number' => 4,
                'submit_text' => $isEditing ? 'Update & Next' : 'Save & Next',
            ],
            'step5' => [
                'back' => $quotationId ? ($isEditing ? route('quotations.edit_step_four', $quotationId) : route('quotations.step4', ['id' => $quotationId])) : '#',
                'next' => route('quotations.index'),
                'title' => 'Site Seeing',
                'number' => 5,
                'submit_text' => $isEditing ? 'Update & Complete' : 'Save & Complete',
            ],
        ];

        return $steps[$currentStep] ?? [];
    }

    /**
     * Display a Quotation Details.
     */
    public function index()
    {
        $quotations = Quotation::with(['market', 'customer', 'driver'])
            ->latest()
            ->paginate(10);
        return view('pages.quotations.index', compact('quotations'));
    }

    /**
     * Display a Quotation Details.
     */
    public function show($id)
    {
        $quotation = Quotation::with(['market', 'customer', 'driver', 'paxSlabs.paxSlab', 'paxSlabs.vehicleType', 'accommodations.hotel', 'accommodations.mealPlan', 'accommodations.roomType', 'accommodations.roomDetails', 'travelPlans.route', 'travelPlans.vehicleType', 'siteSeeings', 'extras'])->findOrFail($id);

        return view('pages.quotations.show', compact('quotation'));
    }

    /**
     * Show the form for creating a new quotation Step 01.
     */
    public function step_one()
    {
        $markets = Market::all();
        $customers = Customers::all();
        $currencies = Currency::all();
        $paxSlabs = PaxSlab::ordered()->get(); // Fetch ordered Pax Slabs
        $markups = MarkUpValue::all();
        $drivers = Driver::all();
        $guides = Guide::all();

        // Generate Quote & Booking Reference
        //$quoteReference = 'QT/SP/' . (Quotation::max('id') + 1001);
        //$bookingReference = 'ST/SP/' . (Quotation::max('id') + 1001);

        // Generate Quote Reference
        $quoteReference = 'QT/SP/' . (Quotation::max('id') + 1001);

        // Check for available booking reference in temp booking ref table
        $tempBookRef = TempBookRef::where('quote_reference', 'LIKE', 'QT/SP/%')->whereNotNull('booking_reference')->latest()->first();

        if ($tempBookRef) {
            // Use the booking reference from temp booking ref table
            $bookingReference = $tempBookRef->booking_reference;
        } else {
            // Get the highest booking reference number
            $latestBookingRef = Quotation::where('booking_reference', 'LIKE', 'ST/SP/%')
                ->get()
                ->map(function ($q) {
                    preg_match('/ST\/SP\/(\d+)/', $q->booking_reference, $matches);
                    return isset($matches[1]) ? (int) $matches[1] : 0;
                })
                ->max();

            // Generate new reference number
            $nextNumber = $latestBookingRef ? $latestBookingRef + 1 : 1001;
            $bookingReference = 'ST/SP/' . $nextNumber;

            // Verify uniqueness
            while (Quotation::where('booking_reference', $bookingReference)->exists()) {
                $nextNumber++;
                $bookingReference = 'ST/SP/' . $nextNumber;
            }
        }

        $navigation = $this->getNavigation('step1', null, false);

        return view('pages.quotations.step-01')->with(['markets' => $markets, 'customers' => $customers, 'currencies' => $currencies, 'quoteReference' => $quoteReference, 'bookingReference' => $bookingReference, 'paxSlabs' => $paxSlabs, 'drivers' => $drivers, 'guides' => $guides, 'navigation' => $navigation, 'markups' => $markups]);
    }

    /**
     * Store a newly created quotation Step 01 in DB.
     */
    public function store_step_one(Request $request)
    {
        $request->validate([
            'market_id' => 'required|exists:markets,id',
            'customer_id' => 'nullable|exists:customers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'no_of_days' => 'required|integer',
            'no_of_nights' => 'required|integer',
            'currency_id' => 'required|exists:currencies,id',
            'conversion_rate' => 'required|numeric',
            'markup_per_pax' => 'required|numeric',
            'pax_slab_id' => 'required|exists:pax_slabs,id',
            'driver_id' => 'required|exists:drivers,id',
            'guide_id' => 'nullable|exists:guides,id',
        ]);

        // Generate Quote & Booking Reference
        //$latestQuote = Quotation::latest()->first();
        //$quoteReference = 'QT/SP/' . ($latestQuote ? $latestQuote->id + 1001 : 1001);
        //$bookingReference = 'ST/SP/' . ($latestQuote ? $latestQuote->id + 1001 : 1001);

        $quotation = Quotation::create([
            'quote_reference' => $request->quote_reference,
            'booking_reference' => $request->booking_reference,
            'market_id' => $request->market_id,
            'customer_id' => $request->customer_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $request->no_of_days,
            'currency' => 'USD',
            'conversion_rate' => $request->conversion_rate,
            'markup_per_person' => $request->markup_per_pax,
            'pax_slab_id' => $request->pax_slab_id,
            'driver_id' => $request->driver_id,
            'guide_id' => $request->guide_id,
        ]);

        //delete used booking reference from the temp table

        if ($request->has('booking_reference')) {
            TempBookRef::where('booking_reference', $request->booking_reference)->delete();
        }

        return redirect()->route('quotations.step2', $quotation->id)->with('success', 'Step 1 saved! Proceed to Pax Slab details.');
    }

    /**
     * Quotation step 01 Edit view.
     */
    public function editStepOne($id)
    {
        $quotation = Quotation::findOrFail($id);
        $markets = Market::all();
        $customers = Customers::all();
        $currencies = Currency::all();
        $paxSlabs = PaxSlab::ordered()->get();
        $markups = MarkUpValue::all();
        $drivers = Driver::all();
        $guides = Guide::all();

        $navigation = $this->getNavigation('step1', $id, true);

        return view('pages.quotations.edit_pages.step-01-edit', compact('quotation', 'markets', 'customers', 'currencies', 'paxSlabs', 'navigation', 'markups', 'drivers', 'guides'));
    }

    /**
     * Update Quotation Step 01 in DB.
     */
    public function updateStepOne(Request $request, $id)
    {
        //dd($request->all());
        $quotation = Quotation::findOrFail($id);

        $request->validate([
            'market_id' => 'required|exists:markets,id',
            'customer_id' => 'nullable|exists:customers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'no_of_days' => 'required|integer',
            'no_of_nights' => 'required|integer',
            'currency_id' => 'required|exists:currencies,id',
            'conversion_rate' => 'required|numeric',
            'markup_per_pax' => 'required|numeric',
            'pax_slab_id' => 'required|exists:pax_slabs,id',
            'driver_id' => 'required|exists:drivers,id',
            'guide_id' => 'nullable|exists:guides,id',
        ]);

        $quotation->update([
            'market_id' => $request->market_id,
            'customer_id' => $request->customer_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $request->no_of_days,
            'currency' => Currency::find($request->currency_id)->code,
            'conversion_rate' => $request->conversion_rate,
            'markup_per_person' => $request->markup_per_pax,
            'pax_slab_id' => $request->pax_slab_id,
            'driver_id' => $request->driver_id,
            'guide_id' => $request->guide_id,
        ]);

        return redirect()->route('quotations.edit_step_two', $id)->with('success', 'Quotation details updated successfully.');
    }

    /**
     * Display the step two form for the specified quotation.
     */
    public function step_two($id)
    {
        $quotation = Quotation::findOrFail($id);

        // Fetch all Pax Slabs in order
        $selectedPaxSlab = PaxSlab::findOrFail($quotation->pax_slab_id);

        // Fetch all previous slabs (including selected one) based on order
        $paxSlabs = PaxSlab::where('order', '<=', $selectedPaxSlab->order)->orderBy('order')->get();

        // Define vehicle types and their default rates

        $vehicleTypes = VehicleType::all();

        $navigation = $this->getNavigation('step2', $id, false);

        return view('pages.quotations.step-02', compact('quotation', 'paxSlabs', 'vehicleTypes', 'navigation'));
    }

    /**
     * Store a quotation Step 02 in DB.
     */
    public function store_step_two(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        // Validate the incoming request
        $request->validate([
            'pax_slab' => 'required|array',
            'pax_slab.*.exact_pax' => 'required|integer|min:1',
            'pax_slab.*.vehicle_type_id' => 'required|exists:vehicle_types,id',
            'pax_slab.*.vehicle_payout_rate' => 'required|numeric|min:0',
        ]);

        // Loop through the Pax Slabs and store each row
        foreach ($request->pax_slab as $paxSlabId => $slab) {
            QuotationPaxSlab::updateOrCreate(
                [
                    'quotation_id' => $quotation->id,
                    'pax_slab_id' => $paxSlabId,
                ],
                [
                    'exact_pax' => $slab['exact_pax'],
                    'vehicle_type_id' => $slab['vehicle_type_id'],
                    'vehicle_payout_rate' => $slab['vehicle_payout_rate'],
                ],
            );
        }
        return redirect()->route('quotations.step3', $quotation->id)->with('success', 'Pax Slab details saved.');
    }

    /**
     * Display the step two edit form for the specified quotation.
     */
    public function editStepTwo($id)
    {
        $quotation = Quotation::with('paxSlabs')->findOrFail($id);

        // Fetch all Pax Slabs in order
        $selectedPaxSlab = PaxSlab::findOrFail($quotation->pax_slab_id);

        // Fetch all previous slabs (including selected one) based on order
        $paxSlabs = PaxSlab::where('order', '<=', $selectedPaxSlab->order)->orderBy('order')->get();

        $vehicleTypes = VehicleType::all();

        $navigation = $this->getNavigation('step2', $id, true);

        return view('pages.quotations.edit_pages.step-02-edit', compact('quotation', 'paxSlabs', 'vehicleTypes', 'navigation'));
    }

    /**
     * Update a quotation Step 02 in DB.
     */
    public function updateStepTwo(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        $request->validate([
            'pax_slab' => 'required|array',
            'pax_slab.*.exact_pax' => 'required|integer|min:1',
            'pax_slab.*.vehicle_type_id' => 'required|exists:vehicle_types,id',
            'pax_slab.*.vehicle_payout_rate' => 'required|numeric|min:0',
        ]);

        foreach ($request->pax_slab as $paxSlabId => $slab) {
            QuotationPaxSlab::updateOrCreate(
                [
                    'quotation_id' => $quotation->id,
                    'pax_slab_id' => $paxSlabId,
                ],
                [
                    'exact_pax' => $slab['exact_pax'],
                    'vehicle_type_id' => $slab['vehicle_type_id'],
                    'vehicle_payout_rate' => $slab['vehicle_payout_rate'],
                ],
            );
        }

        return redirect()->route('quotations.edit_step_three', $id)->with('success', 'Pax Slab details updated successfully.');
    }

    /**
     * Display the step three form for the specified quotation.
     */
    public function step_three($id)
    {
        $quotation = Quotation::findOrFail($id);

        // Fetch system data for selection
        $hotels = Hotel::all();
        $mealPlans = MealPlan::all();
        $roomCategories = RoomCategory::all();

        $navigation = $this->getNavigation('step3', $id, false);

        return view('pages.quotations.step-03', compact('quotation', 'hotels', 'mealPlans', 'roomCategories', 'navigation'));
    }

    /**
     * Store a quotation Step 03 in DB.
     */
    public function store_step_three(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        // Remove the dd() call
        // dd($request->all());

        // Validate input
        $request->validate([
            'accommodations' => 'required|array',
            'accommodations.*.hotel_id' => 'required|exists:hotels,id',
            'accommodations.*.start_date' => 'required|date',
            'accommodations.*.end_date' => 'required|date|after_or_equal:accommodations.*.start_date',
            'accommodations.*.meal_plan_id' => 'required|exists:meal_plans,id',
            'accommodations.*.room_category_id' => 'required|exists:room_categories,id',
            'accommodations.*.room_types' => 'required|array',
            'accommodations.*.room_types.*.per_night_cost' => 'required|numeric|min:0',
            'accommodations.*.room_types.*.nights' => 'nullable|integer|min:0',
            'accommodations.*.room_types.*.total_cost' => 'nullable|numeric|min:0',
            'accommodations.*.additional_rooms' => 'required|array',
            'accommodations.*.additional_rooms.driver.per_night_cost' => 'required|numeric|min:0',
            'accommodations.*.additional_rooms.driver.nights' => 'required|integer|min:0',
            'accommodations.*.additional_rooms.driver.total_cost' => 'required|numeric|min:0',
            'accommodations.*.additional_rooms.driver.provided_by_hotel' => 'nullable|boolean',
            'accommodations.*.additional_rooms.guide.per_night_cost' => 'required|numeric|min:0',
            'accommodations.*.additional_rooms.guide.nights' => 'required|integer|min:0',
            'accommodations.*.additional_rooms.guide.total_cost' => 'required|numeric|min:0',
            'accommodations.*.additional_rooms.guide.provided_by_hotel' => 'nullable|boolean',
        ]);

        foreach ($request->accommodations as $accommodation) {
            // Calculate total nights from all room types
            $totalNights = collect($accommodation['room_types'])->sum('nights');

            // Create the accommodation record
            $quotationAccommodation = QuotationAccommodation::create([
                'quotation_id' => $quotation->id,
                'hotel_id' => $accommodation['hotel_id'],
                'start_date' => $accommodation['start_date'],
                'end_date' => $accommodation['end_date'],
                'nights' => $totalNights,
                'meal_plan_id' => $accommodation['meal_plan_id'],
                'room_category_id' => $accommodation['room_category_id'],
            ]);

            // Store room details for each room type (single, double, triple)
            foreach ($accommodation['room_types'] as $type => $details) {
                // Only create records if nights is greater than 0
                if (!empty($details['nights']) && $details['nights'] > 0) {
                    QuotationAccommodationRoomDetails::create([
                        'quotation_accommodation_id' => $quotationAccommodation->id,
                        'room_type' => $type,
                        'per_night_cost' => $details['per_night_cost'],
                        'nights' => $details['nights'],
                        'total_cost' => $details['total_cost'],
                    ]);
                }
            }

            // Store room details for additional rooms (driver, guide)
            foreach ($accommodation['additional_rooms'] as $type => $details) {
                // Only create records if nights is greater than 0
                if (!empty($details['nights']) && $details['nights'] > 0) {
                    AdditionalRooms::create([
                        'quotation_accommodation_id' => $quotationAccommodation->id,
                        'room_type' => $type,
                        'per_night_cost' => $details['per_night_cost'],
                        'nights' => $details['nights'],
                        'total_cost' => $details['total_cost'],
                        'provided_by_hotel' => $details['provided_by_hotel'] ?? false,
                    ]);
                }
            }
        }

        return redirect()->route('quotations.step4', $quotation->id)->with('success', 'Accommodation details saved successfully.');
    }

    /**
     * Display the step three edit form for the specified quotation.
     */
    public function editStepThree($id)
    {
        $quotation = Quotation::with(['accommodations.roomDetails', 'accommodations.additionalRooms'])->findOrFail($id);

        $hotels = Hotel::all();
        $mealPlans = MealPlan::all();
        $roomCategories = RoomCategory::all();

        $navigation = $this->getNavigation('step3', $id, true);

        return view('pages.quotations.edit_pages.step-03-edit', compact('quotation', 'hotels', 'mealPlans', 'roomCategories', 'navigation'));
    }

    /**
     * Update a quotation Step 03 in DB.
     */
    public function updateStepThree(Request $request, $id)
    {
        //dd($request->all());
        $quotation = Quotation::findOrFail($id);

        $request->validate([
            'accommodations' => 'required|array',
            'accommodations.*.hotel_id' => 'required|exists:hotels,id',
            'accommodations.*.start_date' => 'required|date',
            'accommodations.*.end_date' => 'required|date|after_or_equal:accommodations.*.start_date',
            'accommodations.*.meal_plan_id' => 'required|exists:meal_plans,id',
            'accommodations.*.room_category_id' => 'required|exists:room_categories,id',
            'accommodations.*.room_types' => 'required|array',
            'accommodations.*.room_types.*.per_night_cost' => 'required|numeric|min:0',
            'accommodations.*.room_types.*.nights' => 'nullable|integer|min:0',
            'accommodations.*.room_types.*.total_cost' => 'nullable|numeric|min:0',
            'accommodations.*.additional_rooms' => 'required|array',
            'accommodations.*.additional_rooms.driver.per_night_cost' => 'required|numeric|min:0',
            'accommodations.*.additional_rooms.driver.nights' => 'required|integer|min:0',
            'accommodations.*.additional_rooms.driver.total_cost' => 'required|numeric|min:0',
            'accommodations.*.additional_rooms.driver.provided_by_hotel' => 'nullable|boolean',
            'accommodations.*.additional_rooms.guide.per_night_cost' => 'required|numeric|min:0',
            'accommodations.*.additional_rooms.guide.nights' => 'required|integer|min:0',
            'accommodations.*.additional_rooms.guide.total_cost' => 'required|numeric|min:0',
            'accommodations.*.additional_rooms.guide.provided_by_hotel' => 'nullable|boolean',
        ]);

        // Delete existing accommodations
        $quotation->accommodations()->delete();

        // Create new accommodations
        foreach ($request->accommodations as $accommodation) {
            $totalNights = collect($accommodation['room_types'])->sum('nights');

            $quotationAccommodation = QuotationAccommodation::create([
                'quotation_id' => $quotation->id,
                'hotel_id' => $accommodation['hotel_id'],
                'start_date' => $accommodation['start_date'],
                'end_date' => $accommodation['end_date'],
                'nights' => $totalNights,
                'meal_plan_id' => $accommodation['meal_plan_id'],
                'room_category_id' => $accommodation['room_category_id'],
            ]);

            foreach ($accommodation['room_types'] as $type => $details) {
                if (!empty($details['nights']) && $details['nights'] > 0) {
                    QuotationAccommodationRoomDetails::create([
                        'quotation_accommodation_id' => $quotationAccommodation->id,
                        'room_type' => $type,
                        'per_night_cost' => $details['per_night_cost'],
                        'nights' => $details['nights'],
                        'total_cost' => $details['total_cost'],
                    ]);
                }
            }

            // Store room details for additional rooms (driver, guide)
            foreach ($accommodation['additional_rooms'] as $type => $details) {
                // Only create records if nights is greater than 0
                if (!empty($details['nights']) && $details['nights'] > 0) {
                    AdditionalRooms::create([
                        'quotation_accommodation_id' => $quotationAccommodation->id,
                        'room_type' => $type,
                        'per_night_cost' => $details['per_night_cost'],
                        'nights' => $details['nights'],
                        'total_cost' => $details['total_cost'],
                        'provided_by_hotel' => $details['provided_by_hotel'] ?? false,
                    ]);
                }
            }
        }

        return redirect()->route('quotations.edit_step_four', $id)->with('success', 'Accommodation details updated successfully.');
    }

    /**
     * Display the step four form for the specified quotation.
     */
    public function step_four($id)
    {
        $quotation = Quotation::findOrFail($id);

        // Fetch system data for selection
        $routes = TravelRoute::all();

        // Define vehicle types and their default rates
        $vehicleTypes = VehicleType::all();

        $navigation = $this->getNavigation('step4', $id, false);

        return view('pages.quotations.step4', compact('quotation', 'routes', 'vehicleTypes', 'navigation'));
    }

    /**
     * Store a quotation Step 04 in DB.
     */
    public function store_step_four(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        $request->validate([
            'travel' => 'required|array',
            'travel.*.start_date' => 'required|date',
            'travel.*.end_date' => 'required|date|after_or_equal:travel.*.start_date',
            'travel.*.route_id' => 'required|exists:travel_routes,id',
            'travel.*.vehicle_type_id' => 'required|exists:vehicle_types,id',
            'travel.*.mileage' => 'required|numeric',

            // Add validation for jeep charges
            'jeep_charges' => 'nullable|array',
            'jeep_charges.*.pax_range' => 'required_with:enable_jeep_charges',
            'jeep_charges.*.unit_price' => 'required_with:enable_jeep_charges|numeric|min:0',
            'jeep_charges.*.quantity' => 'required_with:enable_jeep_charges|integer|min:0',
            'jeep_charges.*.total_price' => 'required_with:enable_jeep_charges|numeric|min:0',
            'jeep_charges.*.per_person' => 'required_with:enable_jeep_charges|numeric|min:0',
        ]);

        foreach ($request->travel as $travel) {
            QuotationTravelPlan::create([
                'quotation_id' => $quotation->id,
                'start_date' => $travel['start_date'],
                'end_date' => $travel['end_date'],
                'route_id' => $travel['route_id'],
                'vehicle_type_id' => $travel['vehicle_type_id'],
                'mileage' => $travel['mileage'],
            ]);
        }

        // Store jeep charges if enabled
        if ($request->has('enable_jeep_charges') && $request->has('jeep_charges')) {
            // Delete existing jeep charges first
            $quotation->jeepCharges()->delete();

            // Store new jeep charges
            foreach ($request->jeep_charges as $charge) {
                QuotationJeepCharge::create([
                    'quotation_id' => $quotation->id,
                    'pax_range' => $charge['pax_range'],
                    'unit_price' => $charge['unit_price'],
                    'quantity' => $charge['quantity'],
                    'total_price' => $charge['total_price'],
                    'per_person' => $charge['per_person'],
                ]);
            }
        }

        $quotation->save();

        // Redirect to Quotation Step Four page after final step
        return redirect()->route('quotations.step5', $quotation->id)->with('success', 'Travel plan details saved successfully.');
    }

    /**
     * Edit the step four form for the specified quotation.
     */
    public function editStepFour($id)
    {
        $quotation = Quotation::with('travelPlans')->findOrFail($id);
        $routes = TravelRoute::all();
        $vehicleTypes = VehicleType::all();

        $navigation = $this->getNavigation('step4', $id, true);

        return view('pages.quotations.edit_pages.step-04-edit', compact('quotation', 'routes', 'vehicleTypes', 'navigation'));
    }

    /**
     * Update a quotation Step 04 in DB.
     */
    public function updateStepFour(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        $request->validate([
            'travel' => 'required|array',
            'travel.*.start_date' => 'required|date',
            'travel.*.end_date' => 'required|date|after_or_equal:travel.*.start_date',
            'travel.*.route_id' => 'required|exists:travel_routes,id',
            'travel.*.vehicle_type_id' => 'required|exists:vehicle_types,id',
            'travel.*.mileage' => 'required|numeric',
            'enable_jeep_charges' => 'required|in:0,1',
        ]);

        // Delete existing travel plans
        $quotation->travelPlans()->delete();

        // Create new travel plans
        foreach ($request->travel as $travel) {
            QuotationTravelPlan::create([
                'quotation_id' => $quotation->id,
                'start_date' => $travel['start_date'],
                'end_date' => $travel['end_date'],
                'route_id' => $travel['route_id'],
                'vehicle_type_id' => $travel['vehicle_type_id'],
                'mileage' => $travel['mileage'],
            ]);
        }

        // Always delete existing jeep charges first
        $quotation->jeepCharges()->delete();

        // Only create new jeep charges if enabled and data exists
        if ($request->enable_jeep_charges === '1' && $request->has('jeep_charges')) {
            foreach ($request->jeep_charges as $charge) {
                if (!empty($charge['unit_price']) && !empty($charge['quantity'])) {
                    QuotationJeepCharge::create([
                        'quotation_id' => $quotation->id,
                        'pax_range' => $charge['pax_range'],
                        'unit_price' => $charge['unit_price'],
                        'quantity' => $charge['quantity'],
                        'total_price' => $charge['total_price'],
                        'per_person' => $charge['per_person'],
                    ]);
                }
            }
        }

        return redirect()->route('quotations.edit_step_five', $id)->with('success', 'Travel plans updated successfully.');
    }

    /**
     * Display the step five form for the specified quotation.
     */
    public function step_five($id)
    {
        $quotation = Quotation::findOrFail($id);

        return view('pages.quotations.step-05', compact('quotation'));
    }

    /**
     * Store the step five data for the specified quotation.
     */
    public function store_step_five(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        // Validate the request data
        $request->validate([
            'sites' => 'required|array',
            'sites.*.name' => 'required|string|max:255',
            'sites.*.unit_price' => 'required|numeric|min:0',
            'sites.*.quantity' => 'required|integer|min:1',
            'sites.*.price_per_adult' => 'required|numeric|min:0',

            'site_extras' => 'required|array',
            'site_extras.*.name' => 'required|string|max:255',
            'site_extras.*.unit_price' => 'required|numeric|min:0',
            'site_extras.*.quantity' => 'required|integer|min:1',
            'site_extras.*.price_per_adult' => 'required|numeric|min:0',

            'extras' => 'required|array',
            'extras.*.date' => 'required|date',
            'extras.*.description' => 'required|string|max:255',
            'extras.*.unit_price' => 'required|numeric|min:0',
            'extras.*.quantity_per_pax' => 'required|integer|min:1',
            'extras.*.total_price' => 'required|numeric|min:0',
        ]);

        // Delete existing records
        $quotation->siteSeeings()->delete();

        // Store sites
        foreach ($request->sites as $site) {
            QuotationSiteSeeing::create([
                'quotation_id' => $quotation->id,
                'name' => $site['name'],
                'type' => 'site',
                'unit_price' => $site['unit_price'],
                'quantity' => $site['quantity'],
                'price_per_adult' => $site['price_per_adult'],
            ]);
        }

        // Store site extras
        foreach ($request->site_extras as $extra) {
            QuotationSiteSeeing::create([
                'quotation_id' => $quotation->id,
                'name' => $extra['name'],
                'type' => 'extra',
                'unit_price' => $extra['unit_price'],
                'quantity' => $extra['quantity'],
                'price_per_adult' => $extra['price_per_adult'],
            ]);
        }

        // Store new extras entries
        foreach ($request->extras as $extra) {
            QuotationExtra::create([
                'quotation_id' => $quotation->id,
                'date' => $extra['date'],
                'description' => $extra['description'],
                'unit_price' => $extra['unit_price'],
                'quantity_per_pax' => $extra['quantity_per_pax'],
                'total_price' => $extra['total_price'],
            ]);
        }

        // Update quotation status
        $quotation->status = 'pending';
        $quotation->save();

        return redirect()->route('quotations.index')->with('success', 'Site seeing details saved successfully.');
    }

    /**
     * Edit the step five form for the specified quotation.
     */
    public function editStepFive($id)
    {
        $quotation = Quotation::with('siteSeeings')->findOrFail($id);

        $navigation = $this->getNavigation('step5', $id, true);

        return view('pages.quotations.edit_pages.step-05-edit', compact('quotation', 'navigation'));
    }

    /**
     * Update the step five data for the specified quotation.
     */
    public function updateStepFive(Request $request, $id)
    {
        //dd($request->all());
        $quotation = Quotation::findOrFail($id);

        // Validate the request data
        $request->validate([
            'sites' => 'required|array',
            'sites.*.name' => 'required|string|max:255',
            'sites.*.unit_price' => 'required|numeric|min:0',
            'sites.*.quantity' => 'required|integer|min:1',
            'sites.*.price_per_adult' => 'required|numeric|min:0',

            'site_extras' => 'required|array',
            'site_extras.*.name' => 'required|string|max:255',
            'site_extras.*.unit_price' => 'required|numeric|min:0',
            'site_extras.*.quantity' => 'required|integer|min:1',
            'site_extras.*.price_per_adult' => 'required|numeric|min:0',

            'extras' => 'required|array',
            'extras.*.date' => 'required|date',
            'extras.*.description' => 'required|string|max:255',
            'extras.*.unit_price' => 'required|numeric|min:0',
            'extras.*.quantity_per_pax' => 'required|integer|min:1',
            'extras.*.total_price' => 'required|numeric|min:0',
        ]);

        // Delete existing site seeings
        $quotation->siteSeeings()->delete();

        // Delete existing extras
        $quotation->extras()->delete();

        // Store updated site seeing entries
        foreach ($request->sites as $site) {
            QuotationSiteSeeing::create([
                'quotation_id' => $quotation->id,
                'name' => $site['name'],
                'type' => 'site',
                'unit_price' => $site['unit_price'],
                'quantity' => $site['quantity'],
                'price_per_adult' => $site['price_per_adult'],
            ]);
        }

        // Store updated site extras entries
        foreach ($request->site_extras as $extra) {
            QuotationSiteSeeing::create([
                'quotation_id' => $quotation->id,
                'name' => $extra['name'],
                'type' => 'extra',
                'unit_price' => $extra['unit_price'],
                'quantity' => $extra['quantity'],
                'price_per_adult' => $extra['price_per_adult'],
            ]);
        }

        // Store updated extras entries
        foreach ($request->extras as $extra) {
            QuotationExtra::create([
                'quotation_id' => $quotation->id,
                'date' => $extra['date'],
                'description' => $extra['description'],
                'unit_price' => $extra['unit_price'],
                'quantity_per_pax' => $extra['quantity_per_pax'],
                'total_price' => $extra['total_price'],
            ]);
        }

        $quotation->status = 'pending';
        $quotation->save();

        return redirect()->route('quotations.index')->with('success', 'Site seeing details updated successfully.');
    }

    /**
     * Update Status quote.
     */
    public function updateStatus(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Handle booking reference based on status
        switch ($request->status) {
            case 'rejected':
                $this->handleRejectedStatus($quotation);
                break;

            case 'pending':
                $this->handlePendingStatus($quotation);
                break;
        }

        // Update the status
        $quotation->status = $request->status;
        $quotation->save();

        return response()->json([
            'success' => true,
            'message' => 'Quotation status updated successfully!',
        ]);
    }

    /**
     * Handle rejected status logic
     */
    private function handleRejectedStatus(Quotation $quotation)
    {
        // Store current booking reference in temp table
        TempBookRef::create([
            'quote_reference' => $quotation->quote_reference,
            'booking_reference' => $quotation->booking_reference,
        ]);

        $newref = $quotation->booking_reference . '- Rejected';

        // Clear booking reference
        $quotation->booking_reference = $newref;
        $quotation->save();
    }

    /**
     * Handle pending status logic
     */
    private function handlePendingStatus(Quotation $quotation)
    {
        // Restore booking reference from temp table
        $temp = TempBookRef::where('quote_reference', $quotation->quote_reference)->latest()->first();

        if ($temp) {
            $quotation->booking_reference = $temp->booking_reference;
            $quotation->save();

            // Delete the temp record
            $temp->delete();
        } else {
            // Get the highest booking reference number
            $latestBookingRef = Quotation::where('booking_reference', 'LIKE', 'ST/SP/%')
                ->where('id', '!=', $quotation->id) // Exclude current quotation
                ->get()
                ->map(function ($q) {
                    // Extract the number from the booking reference
                    preg_match('/ST\/SP\/(\d+)/', $q->booking_reference, $matches);
                    return isset($matches[1]) ? (int) $matches[1] : 0;
                })
                ->max();

            // Generate new reference number
            $nextNumber = $latestBookingRef ? $latestBookingRef + 1 : 1001;
            $bookingReference = 'ST/SP/' . $nextNumber;

            // Verify uniqueness
            while (Quotation::where('booking_reference', $bookingReference)->exists()) {
                $nextNumber++;
                $bookingReference = 'ST/SP/' . $nextNumber;
            }

            $quotation->booking_reference = $bookingReference;
            $quotation->save();
        }
    }
}
