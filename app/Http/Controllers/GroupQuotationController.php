<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Customers;
use App\Models\Driver;
use App\Models\GroupAdditionalRoom;
use App\Models\GroupQuotation;
use App\Models\GroupQuotationAccommodation;
use App\Models\GroupQuotationExtra;
use App\Models\GroupQuotationJeepCharge;
use App\Models\GroupQuotationPaxSlab;
use App\Models\GroupQuotationSiteSeeing;
use App\Models\GroupQuotationTravelPlan;
use App\Models\GroupRoomDetail;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\Market;
use App\Models\MarkUpValue;
use App\Models\MealPlan;
use App\Models\PaxSlab;
use App\Models\Quotation;
use App\Models\QuotationTemplate;
use App\Models\RoomCategory;
use App\Models\TempBookRef;
use App\Models\TravelRoute;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupQuotationController extends Controller
{
    /**
     * Display a listing of the group quotations.
     */
    public function selectTemplate()
    {
        $templates = QuotationTemplate::where('is_active', true)->get();
        return view('pages.group_quotations.select_template', compact('templates'));
    }

    public function index()
    {
        $groupQuotations = GroupQuotation::with(['market', 'customer', 'driver'])
            ->latest()
            ->paginate(10);
        return view('pages.group_quotations.index', compact('groupQuotations'));
    }

    /**
     * Show the form for creating a new group quotation.
     */
    public function processTemplateSelection(Request $request)
    {
        // Validate template_id
        $validated = $request->validate([
            'template_id' => 'required|exists:quotation_templates,id',
        ]);

        // Get the selected template
        $template = QuotationTemplate::findOrFail($validated['template_id']);

        // Generate Quote Reference
        $quoteReference = 'GQ/SP/' . (GroupQuotation::max('id') + 1001);

        // Get booking reference
        $tempBookRef = TempBookRef::where('quote_reference', 'LIKE', 'GQ/SP/%')->whereNotNull('booking_reference')->latest()->first();

        if ($tempBookRef) {
            $bookingReference = $tempBookRef->booking_reference;
        } else {
            // Get the highest booking reference number
            $latestBookingRef = GroupQuotation::where('booking_reference', 'LIKE', 'GS/SP/%')
                ->get()
                ->map(function ($q) {
                    preg_match('/GS\/SP\/(\d+)/', $q->booking_reference, $matches);
                    return isset($matches[1]) ? (int) $matches[1] : 0;
                })
                ->max();

            // Generate new reference number
            $nextNumber = $latestBookingRef ? $latestBookingRef + 1 : 1001;
            $bookingReference = 'GS/SP/' . $nextNumber;

            // Verify uniqueness
            while (GroupQuotation::where('booking_reference', $bookingReference)->exists()) {
                $nextNumber++;
                $bookingReference = 'GS/SP/' . $nextNumber;
            }
        }

        // Create a draft group quotation with template data
        $groupQuotation = GroupQuotation::create([
            'name' => $template->template_name ?? 'New Group Quotation',
            'quote_reference' => $quoteReference,
            'booking_reference' => $bookingReference,
            'description' => $template->description,
            'status' => 'draft',
            'is_template' => false,
        ]);

        // Copy template data to the new quotation
        $this->copyTemplateDataToQuotation($groupQuotation, $template);

        // Get data for the step-01 view
        $markets = Market::all();
        $customers = Customers::all();
        $currencies = Currency::all();
        $paxSlabs = PaxSlab::ordered()->get();
        $markups = MarkUpValue::all();
        $drivers = Driver::all();
        $guides = Guide::all();

        // Redirect to step 1 with the pre-filled quotation
        return redirect()->route('group_quotations.step_01', $groupQuotation->id)->with('success', 'Template applied. Please complete the quotation details.');
    }

    public function step_01($id)
    {
        $groupQuotation = GroupQuotation::findOrFail($id);
        $markets = Market::all();
        $customers = Customers::all();
        $currencies = Currency::all();
        $paxSlabs = PaxSlab::ordered()->get();
        $markups = MarkUpValue::all();
        $drivers = Driver::all();
        $guides = Guide::all();

        // Define navigation for steps
        $navigation = [
            'submit_text' => 'Next Step',
        ];

        return view('pages.group_quotations.step-01', compact('groupQuotation', 'markets', 'customers', 'currencies', 'paxSlabs', 'markups', 'drivers', 'guides', 'navigation'));
    }

    public function store_step_01(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'market_id' => 'required|exists:markets,id',
            'customer_id' => 'nullable|exists:customers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'no_of_days' => 'required|integer|min:1',
            'no_of_nights' => 'required|integer|min:0',
            'currency_id' => 'required|exists:currencies,id',
            'conversion_rate' => 'required|numeric',
            'markup_per_pax' => 'required|numeric',
            'pax_slab_id' => 'required|exists:pax_slabs,id',
            'driver_id' => 'required|exists:drivers,id',
            'guide_id' => 'nullable|exists:guides,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $groupQuotation = GroupQuotation::findOrFail($id);

        $groupQuotation->update([
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

        // If there was a temporary booking reference, delete it since it's now assigned
        if ($request->has('booking_reference')) {
            TempBookRef::where('booking_reference', $request->booking_reference)->delete();
        }

        return redirect()->route('group_quotations.step_02', $groupQuotation->id)->with('success', 'Basic information saved! Proceed to Pax Slab details.');
    }

    /**
     * Store the second step of the group quotation creation process
     */
    public function step_02($id)
    {
        $groupQuotation = GroupQuotation::with('paxSlabs')->findOrFail($id);

        // Get the selected pax slab from step 1
        $selectedPaxSlab = PaxSlab::findOrFail($groupQuotation->pax_slab_id);

        // Fetch all previous slabs (including selected one) based on order
        $paxSlabs = PaxSlab::where('order', '<=', $selectedPaxSlab->order)->orderBy('order')->get();

        $vehicleTypes = VehicleType::all();

        // Check if we need to initialize default pax slabs
        if ($groupQuotation->paxSlabs->isEmpty()) {
            // Get default vehicle type (first one from the list)
            $defaultVehicleType = $vehicleTypes->first();

            if (!$defaultVehicleType) {
                // Handle the case where there are no vehicle types
                return redirect()->back()->with('error', 'No vehicle types found. Please add vehicle types first.');
            }

            // Pre-populate with default slabs if there are none yet - only for pax slabs up to selected one
            foreach ($paxSlabs as $paxSlab) {
                GroupQuotationPaxSlab::create([
                    'group_quotation_id' => $groupQuotation->id,
                    'pax_slab_id' => $paxSlab->id,
                    'exact_pax' => 0,
                    'vehicle_type_id' => $defaultVehicleType->id, // Set a default vehicle type ID
                    'vehicle_payout_rate' => $defaultVehicleType->default_rate ?? 0,
                ]);
            }

            // Reload the relationship
            $groupQuotation->load('paxSlabs');
        }

        return view('pages.group_quotations.step-02', compact('groupQuotation', 'paxSlabs', 'vehicleTypes'));
    }

    public function store_step_02(Request $request, $id)
    {
        $groupQuotation = GroupQuotation::findOrFail($id);

        // Validate the incoming request
        $request->validate([
            'pax_slab' => 'required|array',
            'pax_slab.*.exact_pax' => 'required|integer|min:1',
            'pax_slab.*.vehicle_type_id' => 'required|exists:vehicle_types,id',
            'pax_slab.*.vehicle_payout_rate' => 'required|numeric|min:0',
        ]);

        // Delete existing pax slabs first
        $groupQuotation->paxSlabs()->delete();

        // Loop through the Pax Slabs and store each row
        foreach ($request->pax_slab as $paxSlabId => $slab) {
            GroupQuotationPaxSlab::create([
                'group_quotation_id' => $groupQuotation->id,
                'pax_slab_id' => $paxSlabId,
                'exact_pax' => $slab['exact_pax'],
                'vehicle_type_id' => $slab['vehicle_type_id'],
                'vehicle_payout_rate' => $slab['vehicle_payout_rate'],
            ]);
        }

        return redirect()->route('group_quotations.step_03', $groupQuotation->id)->with('success', 'Pax Slab details saved! Proceed to Accommodation details.');
    }

    /**
     * Store the third step of the group quotation creation process
     */
    public function step_03($id)
    {
        $quotation = GroupQuotation::with(['accommodations.hotel', 'accommodations.roomDetails', 'accommodations.additionalRooms'])->findOrFail($id);

        // Get data for select fields
        $hotels = Hotel::all();
        $mealPlans = MealPlan::all();
        $roomCategories = RoomCategory::all();

        return view('pages.group_quotations.step-03', compact('quotation', 'hotels', 'mealPlans', 'roomCategories'));
    }

    public function store_step_03(Request $request, $id)
    {
        //dd($request->all());
        $groupQuotation = GroupQuotation::findOrFail($id);

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
            'accommodations.*.additional_rooms' => 'nullable|array',
            'accommodations.*.additional_rooms.driver.per_night_cost' => 'nullable|numeric|min:0',
            'accommodations.*.additional_rooms.driver.nights' => 'nullable|integer|min:0',
            'accommodations.*.additional_rooms.driver.total_cost' => 'nullable|numeric|min:0',
            'accommodations.*.additional_rooms.driver.provided_by_hotel' => 'nullable|boolean',
            'accommodations.*.additional_rooms.guide.per_night_cost' => 'nullable|numeric|min:0',
            'accommodations.*.additional_rooms.guide.nights' => 'nullable|integer|min:0',
            'accommodations.*.additional_rooms.guide.total_cost' => 'nullable|numeric|min:0',
            'accommodations.*.additional_rooms.guide.provided_by_hotel' => 'nullable|boolean',
        ]);

        // Delete existing accommodations
        $groupQuotation->accommodations()->each(function ($accommodation) {
            $accommodation->roomDetails()->delete();
            $accommodation->additionalRooms()->delete();
            $accommodation->delete();
        });

        foreach ($request->accommodations as $accommodation) {
            // Calculate total nights from all room types
            $totalNights = collect($accommodation['room_types'])->sum('nights');

            // Create the accommodation record
            $groupAccommodation = GroupQuotationAccommodation::create([
                'group_quotation_id' => $groupQuotation->id,
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
                    GroupRoomDetail::create([
                        'group_quotation_accommodation_id' => $groupAccommodation->id,
                        'room_type' => ucfirst($type),
                        'per_night_cost' => $details['per_night_cost'],
                        'nights' => $details['nights'],
                        'total_cost' => $details['total_cost'],
                    ]);
                }
            }

            // Store room details for additional rooms (driver, guide)
            if (isset($accommodation['additional_rooms'])) {
                foreach ($accommodation['additional_rooms'] as $type => $details) {
                    // Create records for all additional rooms, not just those provided by hotel
                    if (isset($details['nights']) && $details['nights'] > 0) {
                        GroupAdditionalRoom::create([
                            'group_quotation_accommodation_id' => $groupAccommodation->id,
                            'room_type' => ucfirst($type), // Make sure to capitalize for consistency
                            'per_night_cost' => $details['per_night_cost'] ?? 0,
                            'nights' => $details['nights'],
                            'total_cost' => $details['total_cost'] ?? 0,
                            'provided_by_hotel' => isset($details['provided_by_hotel']) ? $details['provided_by_hotel'] : false,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('group_quotations.step_04', $groupQuotation->id)->with('success', 'Accommodation details saved! Proceed to Travel Plans.');
    }

    /**
     * Store the fourth step of the group quotation creation process
     */
    public function store_step_04(Request $request, $id)
    {
        $groupQuotation = GroupQuotation::findOrFail($id);

        $validationRules = [
            'travel' => 'required|array',
            'travel.*.start_date' => 'required|date',
            'travel.*.end_date' => 'required|date|after_or_equal:travel.*.start_date',
            'travel.*.route_id' => 'required|exists:travel_routes,id',
            'travel.*.vehicle_type_id' => 'required|exists:vehicle_types,id',
            'travel.*.mileage' => 'required|numeric',
        ];

        // Only apply jeep charges validation if they're enabled
        if ($request->has('enable_jeep_charges')) {
            $validationRules['jeep_charges'] = 'required|array';
            $validationRules['jeep_charges.*.pax_range'] = 'required';
            $validationRules['jeep_charges.*.unit_price'] = 'required|numeric|min:0';
            $validationRules['jeep_charges.*.quantity'] = 'required|integer|min:0';
            $validationRules['jeep_charges.*.total_price'] = 'required|numeric|min:0';
            $validationRules['jeep_charges.*.per_person'] = 'required|numeric|min:0';
        }

        // Only apply validation if route wise - jeep charges are enabled
        if ($request->has('enable_route_jeep_charges')) {
            $validationRules['route_jeep_charges'] = 'required|array';
            $validationRules['route_jeep_charges.*.charges'] = 'required|array';
            $validationRules['route_jeep_charges.*.charges.*.pax_range'] = 'required';
            $validationRules['route_jeep_charges.*.charges.*.unit_price'] = 'required|numeric|min:0';
            $validationRules['route_jeep_charges.*.charges.*.quantity'] = 'required|integer|min:0';
            $validationRules['route_jeep_charges.*.charges.*.total_price'] = 'required|numeric|min:0';
            $validationRules['route_jeep_charges.*.charges.*.per_person'] = 'required|numeric|min:0';
        }

        $request->validate($validationRules);

        // Delete existing travel plans and jeep charges
        $groupQuotation->jeepCharges()->delete();
        $groupQuotation->travelPlans()->delete();

        // Create travel plans and keep track of them for route-specific jeep charges
        $travelPlans = [];
        foreach ($request->travel as $travelIndex => $travel) {
            $travelPlan = GroupQuotationTravelPlan::create([
                'group_quotation_id' => $groupQuotation->id,
                'start_date' => $travel['start_date'],
                'end_date' => $travel['end_date'],
                'route_id' => $travel['route_id'],
                'vehicle_type_id' => $travel['vehicle_type_id'],
                'mileage' => $travel['mileage'],
            ]);

            $travelPlans[$travelIndex] = $travelPlan;
        }

        // Store jeep charges if enabled
        if ($request->has('enable_jeep_charges') && $request->has('jeep_charges')) {
            foreach ($request->jeep_charges as $charge) {
                // Skip empty or incomplete entries
                if (empty($charge['unit_price']) || empty($charge['quantity'])) {
                    continue;
                }

                GroupQuotationJeepCharge::create([
                    'group_quotation_id' => $groupQuotation->id,
                    'travel_plan_id' => null, // Global charges have no specific travel plan
                    'pax_range' => $charge['pax_range'],
                    'unit_price' => $charge['unit_price'],
                    'quantity' => $charge['quantity'],
                    'total_price' => $charge['total_price'],
                    'per_person' => $charge['per_person'],
                ]);
            }
        }

        // Store route-specific jeep charges if enabled
        if ($request->has('enable_route_jeep_charges') && $request->has('route_jeep_charges')) {
            foreach ($request->route_jeep_charges as $travelIndex => $routeCharge) {
                // Find the travel plan this charge belongs to
                if (!isset($travelPlans[$travelIndex])) {
                    continue; // Skip if travel plan not found
                }

                $travelPlan = $travelPlans[$travelIndex];

                // Store each charge for this route
                foreach ($routeCharge['charges'] as $charge) {
                    // Skip empty or incomplete entries
                    if (empty($charge['unit_price']) || empty($charge['quantity'])) {
                        continue;
                    }

                    GroupQuotationJeepCharge::create([
                        'group_quotation_id' => $groupQuotation->id,
                        'travel_plan_id' => $travelPlan->id, // Associate with specific travel plan
                        'pax_range' => $charge['pax_range'],
                        'unit_price' => $charge['unit_price'],
                        'quantity' => $charge['quantity'],
                        'total_price' => $charge['total_price'],
                        'per_person' => $charge['per_person'],
                    ]);
                }
            }
        }

        return redirect()->route('group_quotations.step_05', $groupQuotation->id)->with('success', 'Travel plan details saved! Proceed to Site Seeing.');
    }

    /**
     * Store the fifth step of the group quotation creation process
     */
    public function store_step_05(Request $request, $id)
    {
        $groupQuotation = GroupQuotation::findOrFail($id);

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
            'extras.*.description' => 'required|string|max:255',
            'extras.*.unit_price' => 'required|numeric|min:0',
            'extras.*.quantity_per_pax' => 'required|integer|min:1',
            'extras.*.total_price' => 'required|numeric|min:0',
        ]);

        // Delete existing records
        $groupQuotation->siteSeeings()->delete();
        $groupQuotation->extras()->delete();

        // Store sites
        foreach ($request->sites as $site) {
            GroupQuotationSiteSeeing::create([
                'group_quotation_id' => $groupQuotation->id,
                'name' => $site['name'],
                'type' => 'site',
                'unit_price' => $site['unit_price'],
                'quantity' => $site['quantity'],
                'price_per_adult' => $site['price_per_adult'],
            ]);
        }

        // Store site extras
        foreach ($request->site_extras as $extra) {
            GroupQuotationSiteSeeing::create([
                'group_quotation_id' => $groupQuotation->id,
                'name' => $extra['name'],
                'type' => 'extra',
                'unit_price' => $extra['unit_price'],
                'quantity' => $extra['quantity'],
                'price_per_adult' => $extra['price_per_adult'],
            ]);
        }

        // Store extras
        foreach ($request->extras as $extra) {
            GroupQuotationExtra::create([
                'group_quotation_id' => $groupQuotation->id,
                'description' => $extra['description'],
                'unit_price' => $extra['unit_price'],
                'quantity_per_pax' => $extra['quantity_per_pax'],
                'total_price' => $extra['total_price'],
            ]);
        }

        // Update quotation status to pending
        $groupQuotation->status = 'pending';
        $groupQuotation->save();

        return redirect()->route('group_quotations.index')->with('success', 'Group quotation created successfully!');
    }

    /**
     * Display the specified group quotation.
     */
    public function show($id)
    {
        $groupQuotation = GroupQuotation::with(['market', 'customer', 'driver', 'paxSlabs.paxSlab', 'paxSlabs.vehicleType', 'accommodations.hotel', 'accommodations.mealPlan', 'accommodations.roomCategory', 'accommodations.roomDetails', 'accommodations.additionalRooms', 'travelPlans.route', 'travelPlans.vehicleType', 'siteSeeings', 'extras'])->findOrFail($id);

        return view('pages.group_quotations.show', compact('groupQuotation'));
    }

    /**
     * Remove the specified group quotation from storage.
     */
    public function destroy($id)
    {
        $groupQuotation = GroupQuotation::findOrFail($id);
        $groupQuotation->delete();

        return redirect()->route('group_quotations.index')->with('success', 'Group quotation deleted successfully');
    }

    /**
     * Update Status of the group quotation.
     */
    public function updateStatus(Request $request, $id)
    {
        $groupQuotation = GroupQuotation::findOrFail($id);

        $request->validate([
            'status' => 'required|in:draft,pending,approved,rejected',
        ]);

        // Handle booking reference based on status
        switch ($request->status) {
            case 'rejected':
                $this->handleRejectedStatus($groupQuotation);
                break;
            case 'pending':
                $this->handlePendingStatus($groupQuotation);
                break;
        }

        // Update the status
        $groupQuotation->status = $request->status;
        $groupQuotation->save();

        return response()->json([
            'message' => 'Group quotation status updated successfully!',
        ]);
    }

    /**
     * Handle rejected status logic
     */
    private function handleRejectedStatus(GroupQuotation $groupQuotation)
    {
        // Store current booking reference in temp table
        TempBookRef::create([
            'booking_reference' => $groupQuotation->booking_reference,
            'quote_reference' => $groupQuotation->quote_reference,
        ]);

        $newref = $groupQuotation->booking_reference . '- Rejected';

        // Clear booking reference
        $groupQuotation->booking_reference = $newref;
        $groupQuotation->save();
    }

    /**
     * Handle pending status logic
     */
    private function handlePendingStatus(GroupQuotation $groupQuotation)
    {
        // Restore booking reference from temp table
        $temp = TempBookRef::where('quote_reference', $groupQuotation->quote_reference)->latest()->first();

        if ($temp) {
            $groupQuotation->booking_reference = $temp->booking_reference;
            $temp->delete();
        }
    }

    private function copyTemplateDataToQuotation($groupQuotation, $template)
    {
        // First, decode the JSON strings if they haven't been decoded already
        $accommodations = is_string($template->accommodations) ? json_decode($template->accommodations, true) : $template->accommodations;
        $travelPlans = is_string($template->travel_plans) ? json_decode($template->travel_plans, true) : $template->travel_plans;
        $siteSeeings = is_string($template->site_seeings) ? json_decode($template->site_seeings, true) : $template->site_seeings;
        $siteExtras = is_string($template->site_extras) ? json_decode($template->site_extras, true) : $template->site_extras;
        $extras = is_string($template->extras) ? json_decode($template->extras, true) : $template->extras;

        // Log to debug
        \Log::info('Template data decoded:', [
            'accommodations' => $accommodations,
            'travelPlans' => $travelPlans,
            'siteSeeings' => $siteSeeings,
            'siteExtras' => $siteExtras,
            'extras' => $extras,
        ]);

        // Copy accommodations if available
        if (!empty($accommodations)) {
            foreach ($accommodations as $accommodation) {
                try {
                    $newAccommodation = new GroupQuotationAccommodation([
                        'group_quotation_id' => $groupQuotation->id,
                        'hotel_id' => $accommodation['hotel_id'] ?? null,
                        'meal_plan_id' => $accommodation['meal_plan_id'] ?? null,
                        'room_category_id' => $accommodation['room_category_id'] ?? null,
                    ]);

                    $newAccommodation->save();

                    // Copy room types if available
                    if (!empty($accommodation['room_types'])) {
                        foreach ($accommodation['room_types'] as $type => $details) {
                            if (isset($details['per_night_cost']) && $details['per_night_cost'] > 0) {
                                $roomDetail = new GroupRoomDetail([
                                    'group_quotation_accommodation_id' => $newAccommodation->id,
                                    'room_type' => ucfirst($type), // Capitalize room type
                                    'per_night_cost' => $details['per_night_cost'],
                                    'nights' => 1, // Default to 1 night, will be updated later
                                    'total_cost' => $details['per_night_cost'], // Initialize with per night cost
                                ]);
                                $roomDetail->save();
                            }
                        }
                    }

                    // Copy additional rooms (driver and guide) if available
                    if (!empty($accommodation['additional_rooms'])) {
                        foreach ($accommodation['additional_rooms'] as $type => $details) {
                            if (isset($details['per_night_cost']) && $details['per_night_cost'] > 0) {
                                $additionalRoom = new GroupAdditionalRoom([
                                    'group_quotation_accommodation_id' => $newAccommodation->id,
                                    'room_type' => ucfirst($type), // Capitalize room type (Driver or Guide)
                                    'per_night_cost' => $details['per_night_cost'],
                                    'nights' => 1, // Default to 1 night, will be updated later
                                    'total_cost' => $details['per_night_cost'], // Initialize with per night cost
                                    'provided_by_hotel' => $details['provided_by_hotel'] ?? false,
                                ]);
                                $additionalRoom->save();
                            }
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error('Error creating accommodation: ' . $e->getMessage());
                }
            }
        }

        // Copy travel plans if available
        if (!empty($travelPlans)) {
            foreach ($travelPlans as $travelPlan) {
                try {
                    $newTravelPlan = new GroupQuotationTravelPlan([
                        'group_quotation_id' => $groupQuotation->id,
                        'route_id' => $travelPlan['route_id'] ?? null,
                        'vehicle_type_id' => $travelPlan['vehicle_type_id'] ?? null,
                        'mileage' => $travelPlan['mileage'] ?? 0,
                    ]);
                    $newTravelPlan->save();
                } catch (\Exception $e) {
                    \Log::error('Error creating travel plan: ' . $e->getMessage());
                }
            }
        }

        // Copy site seeings if available
        if (!empty($siteSeeings)) {
            foreach ($siteSeeings as $siteSeeing) {
                try {
                    $newSiteSeeing = new GroupQuotationSiteSeeing([
                        'group_quotation_id' => $groupQuotation->id,
                        'name' => $siteSeeing['name'] ?? 'Site Seeing',
                        'type' => $siteSeeing['type'] ?? 'site',
                        'unit_price' => $siteSeeing['unit_price'] ?? 0,
                        'quantity' => $siteSeeing['quantity'] ?? 1,
                        'price_per_adult' => $siteSeeing['price_per_adult'] ?? 0,
                    ]);
                    $newSiteSeeing->save();
                } catch (\Exception $e) {
                    \Log::error('Error creating site seeing: ' . $e->getMessage());
                }
            }
        }

        // Copy site extras if available
        if (!empty($siteExtras)) {
            foreach ($siteExtras as $siteExtra) {
                try {
                    $newSiteExtra = new GroupQuotationSiteSeeing([
                        'group_quotation_id' => $groupQuotation->id,
                        'name' => $siteExtra['name'] ?? 'Site Extra',
                        'type' => 'extra',
                        'unit_price' => $siteExtra['unit_price'] ?? 0,
                        'quantity' => $siteExtra['quantity'] ?? 1,
                        'price_per_adult' => $siteExtra['price_per_adult'] ?? 0,
                    ]);
                    $newSiteExtra->save();
                } catch (\Exception $e) {
                    \Log::error('Error creating site extra: ' . $e->getMessage());
                }
            }
        }

        // Copy extras if available
        if (!empty($extras)) {
            foreach ($extras as $extra) {
                try {
                    $newExtra = new GroupQuotationExtra([
                        'group_quotation_id' => $groupQuotation->id,
                        'description' => $extra['description'] ?? 'Extra',
                        'unit_price' => $extra['unit_price'] ?? 0,
                        'quantity_per_pax' => $extra['quantity_per_pax'] ?? 1,
                        'total_price' => $extra['total_price'] ?? 0,
                    ]);
                    $newExtra->save();
                } catch (\Exception $e) {
                    \Log::error('Error creating extra: ' . $e->getMessage());
                }
            }
        }
    }
}
