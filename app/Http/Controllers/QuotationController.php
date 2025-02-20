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
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotations = Quotation::with(['market', 'customer', 'driver'])
            ->latest()
            ->paginate(10);
        return view('pages.quotations.index', compact('quotations'));
    }

    public function show($id)
    {
        $quotation = Quotation::with(['market', 'customer', 'driver', 'paxSlabs.paxSlab', 'paxSlabs.vehicleType', 'accommodations.hotel', 'accommodations.mealPlan', 'accommodations.roomType', 'accommodations.roomDetails', 'travelPlans.route', 'travelPlans.vehicleType' , 'siteSeeings','extras'])->findOrFail($id);

        return view('pages.quotations.show', compact('quotation'));
    }

    /**
     * Show the form for creating a new resource.
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
        $quoteReference = 'QT/SP/' . (Quotation::max('id') + 1001);
        $bookingReference = 'ST/SP/' . (Quotation::max('id') + 1001);

        $navigation = $this->getNavigation('step1', null, false);

        return view('pages.quotations.step-01')->with(['markets' => $markets, 'customers' => $customers, 'currencies' => $currencies, 'quoteReference' => $quoteReference, 'bookingReference' => $bookingReference, 'paxSlabs' => $paxSlabs, 'drivers' => $drivers, 'guides' => $guides, 'navigation' => $navigation, 'markups' => $markups]);
    }

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
        $latestQuote = Quotation::latest()->first();
        $quoteReference = 'QT/SP/' . ($latestQuote ? $latestQuote->id + 1001 : 1001);
        $bookingReference = 'ST/SP/' . ($latestQuote ? $latestQuote->id + 1001 : 1001);

        $quotation = Quotation::create([
            'quote_reference' => $quoteReference,
            'booking_reference' => $bookingReference,
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

        return redirect()->route('quotations.step2', $quotation->id)->with('success', 'Step 1 saved! Proceed to Pax Slab details.');
    }

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

    public function editStepThree($id)
    {
        $quotation = Quotation::with(['accommodations.roomDetails', 'accommodations.additionalRooms'])
        ->findOrFail($id);

        $hotels = Hotel::all();
        $mealPlans = MealPlan::all();
        $roomCategories = RoomCategory::all();

        $navigation = $this->getNavigation('step3', $id, true);

        return view('pages.quotations.edit_pages.step-03-edit', compact('quotation', 'hotels', 'mealPlans', 'roomCategories', 'navigation'));
    }

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

        $quotation->save();

        // Redirect to Quotation Step Four page after final step
        return redirect()->route('quotations.step5', $quotation->id)->with('success', 'Travel plan details saved successfully.');
    }

    public function editStepFour($id)
    {
        $quotation = Quotation::with('travelPlans')->findOrFail($id);
        $routes = TravelRoute::all();
        $vehicleTypes = VehicleType::all();

        $navigation = $this->getNavigation('step4', $id, true);

        return view('pages.quotations.edit_pages.step-04-edit', compact('quotation', 'routes', 'vehicleTypes', 'navigation'));
    }

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

        $quotation->save();

        return redirect()->route('quotations.edit_step_five', $id)->with('success', 'Travel plans updated successfully.');
    }

    public function step_five($id)
    {
        $quotation = Quotation::findOrFail($id);

        return view('pages.quotations.step-05', compact('quotation'));
    }

    public function store_step_five(Request $request, $id)
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

            'extras' => 'required|array',
            'extras.*.date' => 'required|date',
            'extras.*.description' => 'required|string|max:255',
            'extras.*.unit_price' => 'required|numeric|min:0',
            'extras.*.quantity_per_pax' => 'required|integer|min:1',
            'extras.*.total_price' => 'required|numeric|min:0',
        ]);

        // Delete existing site seeings if any
        $quotation->siteSeeings()->delete();

        // Delete existing extras
        $quotation->extras()->delete();

        // Store new site seeing entries
        foreach ($request->sites as $site) {
            QuotationSiteSeeing::create([
                'quotation_id' => $quotation->id,
                'name' => $site['name'],
                'unit_price' => $site['unit_price'],
                'quantity' => $site['quantity'],
                'price_per_adult' => $site['price_per_adult'],
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

        // Update quotation status to pending
        $quotation->status = 'pending';
        $quotation->save();

        return redirect()->route('quotations.index')->with('success', 'Site seeing details saved successfully.');
    }

    public function editStepFive($id)
    {
        $quotation = Quotation::with('siteSeeings')->findOrFail($id);

        $navigation = $this->getNavigation('step5', $id, true);

        return view('pages.quotations.edit_pages.step-05-edit', compact('quotation', 'navigation'));
    }

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
                'unit_price' => $site['unit_price'],
                'quantity' => $site['quantity'],
                'price_per_adult' => $site['price_per_adult'],
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

    public function updateStatus(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $quotation->update([
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Quotation status updated successfully!']);
    }
}
