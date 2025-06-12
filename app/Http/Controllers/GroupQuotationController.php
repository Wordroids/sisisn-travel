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
use App\Models\GroupQuotationMember;
use App\Models\GroupTempSaveRefno;

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

        $baseQuoteRef = $template->quote_reference; // e.g., QT/SP/1001
        $baseBookingRef = $template->booking_reference; // e.g., ST/SIC/1001

        $finalQuoteReference = null;
        $finalBookingReference = null;

        // Step 1: Attempt to find and use a booking_reference from TempBookRef
        // Derive the general search prefix for booking references (e.g., "ST/SIC/%")
        $bookingRefParts = explode('/', $baseBookingRef);
        $searchPrefixForTempBookingRef = '';
        if (count($bookingRefParts) >= 2) {
            // Ensures we have at least TYPE/MARKET like ST/SIC
            $searchPrefixForTempBookingRef = $bookingRefParts[0] . '/' . $bookingRefParts[1] . '/%';
        } else {
            // Fallback if baseBookingRef format is unexpected (e.g. just "ST")
            \Log::warning("Unexpected baseBookingRef format for template ID {$template->id}: {$baseBookingRef}");
            $searchPrefixForTempBookingRef = $baseBookingRef . '%'; // Less specific search
        }

        $reusableTempEntry = GroupTempSaveRefno::where('booking_reference', 'LIKE', $searchPrefixForTempBookingRef)
            ->orderBy('created_at', 'ASC') // Get the oldest available
            ->first();

        if ($reusableTempEntry) {
            // Ensure this booking_reference isn't currently active in GroupQuotation table
            if (!GroupQuotation::where('booking_reference', $reusableTempEntry->booking_reference)->exists()) {
                $finalBookingReference = $reusableTempEntry->booking_reference; // Use this booking_reference
                $reusableTempEntry->delete();
            } else {
                // The booking_reference from TempBookRef is already in use by an active GroupQuotation.
                // Log this and remove the temp entry to avoid future conflicts.
                \Log::warning("TempBookRef: Booking reference {$reusableTempEntry->booking_reference} from temp table is already active in GroupQuotations. Removing temp entry.");
                $reusableTempEntry->delete();
                // $finalBookingReference remains null, so a new one will be generated.
            }
        }

        // Step 2: Generate a unique quote_reference
        $currentQuoteSequence = 1;
        $latestGroupQuotationForQuoteSeries = GroupQuotation::where('quote_reference', 'LIKE', $baseQuoteRef . '/%')
            ->orderByRaw("CAST(SUBSTRING_INDEX(quote_reference, '/', -1) AS UNSIGNED) DESC")
            ->first();

        if ($latestGroupQuotationForQuoteSeries) {
            $parts = explode('/', $latestGroupQuotationForQuoteSeries->quote_reference);
            $lastSubSequence = end($parts);
            if (is_numeric($lastSubSequence)) {
                $currentQuoteSequence = intval($lastSubSequence) + 1;
            }
        }

        while (true) {
            $quoteSequencePadded = str_pad($currentQuoteSequence, 4, '0', STR_PAD_LEFT);
            $generatedQuoteRef = $baseQuoteRef . '/' . $quoteSequencePadded;
            if (!GroupQuotation::where('quote_reference', $generatedQuoteRef)->exists()) {
                $finalQuoteReference = $generatedQuoteRef;
                break;
            }
            $currentQuoteSequence++;
        }

        // Step 3: Generate a unique booking_reference if not already set from TempBookRef
        if (is_null($finalBookingReference)) {
            $currentBookingSequence = 1;
            // Construct the base booking reference with fixed 1001
            if (strpos($baseBookingRef, 'CE') !== false) {
                $baseBookingRefWithFixed = 'ST/SIC/CE/1001';
            } else {
                $baseBookingRefWithFixed = 'ST/SIC/1001';
            }

            // Find the highest sequence number for this booking reference pattern
            $latestBookingInDB = GroupQuotation::where('booking_reference', 'LIKE', $baseBookingRefWithFixed . '/%')
                ->selectRaw("*, CAST(SUBSTRING_INDEX(REPLACE(booking_reference, '- Rejected', ''), '/', -1) AS UNSIGNED) as booking_seq_num")
                ->orderBy('booking_seq_num', 'DESC')
                ->first();

            if ($latestBookingInDB) {
                $cleanBookingRef = str_replace('- Rejected', '', $latestBookingInDB->booking_reference);
                $parts = explode('/', $cleanBookingRef);
                $lastSubSeq = end($parts);
                if (is_numeric($lastSubSeq)) {
                    $currentBookingSequence = intval($lastSubSeq) + 1;
                }
            }

            while (true) {
                // Format as two digits: 01, 02, etc.
                $bookingSequencePadded = str_pad($currentBookingSequence, 2, '0', STR_PAD_LEFT);
                $generatedBookingRef = $baseBookingRefWithFixed . '/' . $bookingSequencePadded;
                
                if (!GroupQuotation::where('booking_reference', $generatedBookingRef)->exists()) {
                    $finalBookingReference = $generatedBookingRef;
                    break;
                }
                $currentBookingSequence++;
            }
        }

        // Create a draft group quotation with template data
        $groupQuotation = GroupQuotation::create([
            'name' => $template->template_name ?? 'New Group Quotation',
            'quote_reference' => $finalQuoteReference,
            'booking_reference' => $finalBookingReference,
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
            GroupTempSaveRefno::where('booking_reference', $request->booking_reference)->delete();
        }

        return redirect()->route('group_quotations.step_02', $groupQuotation->id)->with('success', 'Basic information saved! Proceed to Pax Slab details.');
    }

    /**
     * Store the second step of the group quotation creation process
     */
    public function step_02($id)
    {
        $groupQuotation = GroupQuotation::with(['paxSlabs', 'members'])->findOrFail($id); // Eager load members here

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
            $groupQuotation->load('paxSlabs'); // This reloads paxSlabs, members are already loaded
        }

        return view('pages.group_quotations.step-02', compact('groupQuotation', 'paxSlabs', 'vehicleTypes'));
    }

    public function store_step_02(Request $request, $id)
    {
        //dd($request->all()); // You can remove this or keep for debugging

        $groupQuotation = GroupQuotation::findOrFail($id);

        // Validate the incoming request, including members
        $validatedData = $request->validate([
            'pax_slab' => 'required|array',
            'pax_slab.*.exact_pax' => 'required|integer|min:1',
            'pax_slab.*.vehicle_type_id' => 'required|exists:vehicle_types,id',
            'pax_slab.*.vehicle_payout_rate' => 'required|numeric|min:0',
            'members' => 'nullable|array', // Add validation for members
            'members.*.id' => 'nullable|exists:group_quotation_members,id', // For existing members
            'members.*.name' => 'required_with:members|string|max:255', // name is required if members array is present
            'members.*.email' => 'nullable|email|max:255',
            'members.*.phone' => 'nullable|string|max:20',
            'members.*.whatsapp' => 'nullable|string|max:20',
            'members.*.country' => 'nullable|string|max:100',
            'members.*.member_group' => 'nullable|string|max:100', // Optional member group field
        ]);

        // --- Handle Pax Slabs ---
        // Delete existing pax slabs first
        $groupQuotation->paxSlabs()->delete();

        // Loop through the Pax Slabs and store each row
        // Use $validatedData['pax_slab'] as it's now validated
        foreach ($validatedData['pax_slab'] as $paxSlabId => $slab) {
            GroupQuotationPaxSlab::create([
                'group_quotation_id' => $groupQuotation->id,
                'pax_slab_id' => $paxSlabId,
                'exact_pax' => $slab['exact_pax'],
                'vehicle_type_id' => $slab['vehicle_type_id'],
                'vehicle_payout_rate' => $slab['vehicle_payout_rate'],
            ]);
        }

        // --- Handle Members ---
        $submittedMemberIds = [];
        // Now $validatedData['members'] will exist if members were submitted and passed validation
        if (isset($validatedData['members']) && is_array($validatedData['members'])) {
            foreach ($validatedData['members'] as $memberInput) {
                $memberData = [
                    'name' => $memberInput['name'],
                    'email' => $memberInput['email'] ?? null,
                    'phone' => $memberInput['phone'] ?? null,
                    'whatsapp' => $memberInput['whatsapp'] ?? null,
                    'country' => $memberInput['country'] ?? null,
                    'member_group' => $memberInput['member_group'] ?? null, // Optional member group field
                    'group_quotations_id' => $groupQuotation->id,
                ];

                if (!empty($memberInput['id'])) {
                    // Update existing member
                    $member = GroupQuotationMember::find($memberInput['id']);
                    // Ensure member belongs to this quotation before updating
                    if ($member && $member->group_quotations_id == $groupQuotation->id) {
                        $member->update($memberData);
                        $submittedMemberIds[] = $member->id;
                    }
                } else {
                    // Create new member
                    $newMember = GroupQuotationMember::create($memberData);
                    $submittedMemberIds[] = $newMember->id;
                }
            }
        }

        // Delete members that were removed from the form
        $existingMemberIds = $groupQuotation->members()->pluck('id')->all();
        $memberIdsToDelete = array_diff($existingMemberIds, $submittedMemberIds);
        if (!empty($memberIdsToDelete)) {
            GroupQuotationMember::destroy($memberIdsToDelete);
        }

        // Reload members to ensure the view has the latest data if redirecting back or for subsequent steps
        $groupQuotation->load('members');

        return redirect()->route('group_quotations.step_03', $groupQuotation->id)->with('success', 'Pax Slab and Member details saved! Proceed to Accommodation details.');
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
    public function step_04($id)
    {
        $quotation = GroupQuotation::with([
            'travelPlans.route', // Ensure 'route' relationship loads mileage if not default
            'travelPlans.vehicleType',
            'travelPlans.jeepCharges',
            'jeepCharges' => function ($query) {
                $query->whereNull('travel_plan_id');
            },
            'paxSlabs.paxSlab',
        ])->findOrFail($id);

        $travelRoutes = TravelRoute::orderBy('name')->get(); // This should fetch mileage by default
        $vehicleTypes = VehicleType::orderBy('name')->get();

        // Get the PaxSlab instances related to this quotation's GroupQuotationPaxSlab entries
        $relatedPaxSlabIds = $quotation->paxSlabs->pluck('pax_slab_id')->unique();
        $paxSlabsForRanges = PaxSlab::whereIn('id', $relatedPaxSlabIds)->orderBy('order')->get();

        // Create an array of pax range strings like "2-3 Pax", "4-5 Pax"
        $paxSlabRanges = $paxSlabsForRanges
            ->map(function ($slab) {
                return $slab->min_pax . '-' . $slab->max_pax . ' Pax';
            })
            ->unique()
            ->values()
            ->all();

        // Determine if global jeep charges or route-wise jeep charges were previously enabled/used
        // These flags help set the initial state of checkboxes in the view.
        $hasGlobalJeepCharges = $quotation->jeepCharges->whereNull('travel_plan_id')->isNotEmpty();

        $hasRouteWiseJeepCharges = $quotation->travelPlans->some(function ($plan) {
            return $plan->jeepCharges->isNotEmpty();
        });

        return view('pages.group_quotations.step-04', compact('quotation', 'travelRoutes', 'vehicleTypes', 'paxSlabRanges', 'hasGlobalJeepCharges', 'hasRouteWiseJeepCharges'));
    }

    public function store_step_04(Request $request, $id)
    {
        //dd($request->all());
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
        if ($request->input('enable_jeep_charges') == '1') {
            $validationRules['jeep_charges'] = 'required|array';
            $validationRules['jeep_charges.*.pax_range'] = 'required';
            $validationRules['jeep_charges.*.unit_price'] = 'required|numeric|min:0';
            $validationRules['jeep_charges.*.quantity'] = 'required|integer|min:0';
            $validationRules['jeep_charges.*.total_price'] = 'required|numeric|min:0';
            $validationRules['jeep_charges.*.per_person'] = 'required|numeric|min:0';
        }

        // Only apply validation if route wise - jeep charges are enabled
        if ($request->input('enable_route_jeep_charges')) {
            $validationRules['route_jeep_charges'] = 'nullable|array'; // Nullable if no charges are added for any route
            $validationRules['route_jeep_charges.*.charges'] = 'required_with:route_jeep_charges|array';
            $validationRules['route_jeep_charges.*.charges.*.pax_range'] = 'required';
            $validationRules['route_jeep_charges.*.charges.*.unit_price'] = 'required|numeric|min:0';
            $validationRules['route_jeep_charges.*.charges.*.quantity'] = 'required|integer|min:0';
            $validationRules['route_jeep_charges.*.charges.*.total_price'] = 'required|numeric|min:0';
            $validationRules['route_jeep_charges.*.charges.*.per_person'] = 'required|numeric|min:0';
        }

        $request->validate($validationRules);

        // Delete existing travel plans and their associated jeep charges, and global jeep charges
        foreach ($groupQuotation->travelPlans as $plan) {
            $plan->jeepCharges()->delete();
            $plan->delete();
        }
        $groupQuotation->jeepCharges()->whereNull('travel_plan_id')->delete();

        // Create travel plans and keep track of them for route-specific jeep charges
        $createdTravelPlans = [];
        if ($request->has('travel')) {
            foreach ($request->travel as $travelIndex => $travelData) {
                $travelPlan = GroupQuotationTravelPlan::create([
                    'group_quotation_id' => $groupQuotation->id,
                    'start_date' => $travelData['start_date'],
                    'end_date' => $travelData['end_date'],
                    'route_id' => $travelData['route_id'],
                    'vehicle_type_id' => $travelData['vehicle_type_id'],
                    'mileage' => $travelData['mileage'],
                ]);
                $createdTravelPlans[$travelIndex] = $travelPlan;
            }
        }

        // Store global jeep charges if enabled
        if ($request->input('enable_jeep_charges') == '1' && $request->has('jeep_charges')) {
            foreach ($request->jeep_charges as $charge) {
                if (empty($charge['pax_range']) || (!isset($charge['unit_price']) || $charge['unit_price'] === '' || $charge['unit_price'] === null) || (!isset($charge['quantity']) || $charge['quantity'] === '' || $charge['quantity'] === null)) {
                    continue; // Skip if essential data is missing
                }
                if (floatval($charge['unit_price']) == 0 && intval($charge['quantity']) == 0) {
                    continue; // Skip if both unit price and quantity are zero
                }

                GroupQuotationJeepCharge::create([
                    'group_quotation_id' => $groupQuotation->id,
                    'travel_plan_id' => null,
                    'pax_range' => $charge['pax_range'],
                    'unit_price' => $charge['unit_price'] ?? 0,
                    'quantity' => $charge['quantity'] ?? 0,
                    'total_price' => $charge['total_price'] ?? 0,
                    'per_person' => $charge['per_person'] ?? 0,
                ]);
            }
        }

        // Store route-specific jeep charges if enabled
        if ($request->input('enable_route_jeep_charges') == '1' && $request->has('route_jeep_charges')) {
            foreach ($request->route_jeep_charges as $travelIndex => $routeChargeData) {
                if (!isset($createdTravelPlans[$travelIndex]) || !isset($routeChargeData['charges'])) {
                    continue;
                }
                $travelPlan = $createdTravelPlans[$travelIndex];
                foreach ($routeChargeData['charges'] as $charge) {
                    if (empty($charge['pax_range']) || (!isset($charge['unit_price']) || $charge['unit_price'] === '' || $charge['unit_price'] === null) || (!isset($charge['quantity']) || $charge['quantity'] === '' || $charge['quantity'] === null)) {
                        continue; // Skip if essential data is missing
                    }
                    if (floatval($charge['unit_price']) == 0 && intval($charge['quantity']) == 0) {
                        continue; // Skip if both unit price and quantity are zero
                    }

                    GroupQuotationJeepCharge::create([
                        'group_quotation_id' => $groupQuotation->id,
                        'travel_plan_id' => $travelPlan->id,
                        'pax_range' => $charge['pax_range'],
                        'unit_price' => $charge['unit_price'] ?? 0,
                        'quantity' => $charge['quantity'] ?? 0,
                        'total_price' => $charge['total_price'] ?? 0,
                        'per_person' => $charge['per_person'] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('group_quotations.step_05', $groupQuotation->id)->with('success', 'Travel plan details saved! Proceed to Site Seeing.');
    }

    /**
     * Store the fifth step of the group quotation creation process
     */
    public function step_05($id)
    {
        $quotation = GroupQuotation::with(['siteSeeings', 'extras'])->findOrFail($id);

        return view('pages.group_quotations.step-05', compact('quotation'));
    }

    /**
     * Store the fifth step of the group quotation creation process (Site Seeing & Extras).
     */
    public function store_step_05(Request $request, $id)
    {
        $groupQuotation = GroupQuotation::findOrFail($id);

        $validatedData = $request->validate([
            'site_seeings' => 'nullable|array',
            'site_seeings.*.name' => 'required_with:site_seeings|string|max:255',
            'site_seeings.*.type' => 'nullable|string|max:100',
            'site_seeings.*.description' => 'nullable|string',
            'site_seeings.*.unit_price' => 'nullable|numeric|min:0',
            'site_seeings.*.quantity' => 'nullable|integer|min:0',
            'site_seeings.*.price_per_adult' => 'nullable|numeric|min:0',

            'extras' => 'nullable|array',
            'extras.*.date' => 'nullable|date',
            'extras.*.description' => 'required_with:extras|string|max:255',
            'extras.*.unit_price' => 'nullable|numeric|min:0',
            'extras.*.quantity_per_pax' => 'nullable|integer|min:0',
            // 'extras.*.total_price' is not submitted from the form, so not validated here.
            // It should be calculated if needed or stored as null/0 if not provided.
        ]);

        // Delete existing site seeings and extras to prevent duplicates
        $groupQuotation->siteSeeings()->delete();
        $groupQuotation->extras()->delete();

        // Store Site Seeing entries
        if ($request->has('site_seeings')) {
            foreach ($validatedData['site_seeings'] as $siteSeeingData) {
                // Skip if essential data like name is missing or if all price/qty fields are zero/empty
                if (empty($siteSeeingData['name']) && (empty($siteSeeingData['unit_price']) || $siteSeeingData['unit_price'] == 0) && (empty($siteSeeingData['quantity']) || $siteSeeingData['quantity'] == 0) && (empty($siteSeeingData['price_per_adult']) || $siteSeeingData['price_per_adult'] == 0)) {
                    continue;
                }
                GroupQuotationSiteSeeing::create([
                    'group_quotation_id' => $groupQuotation->id,
                    'name' => $siteSeeingData['name'],
                    'type' => $siteSeeingData['type'] ?? null,
                    'description' => $siteSeeingData['description'] ?? null,
                    'unit_price' => $siteSeeingData['unit_price'] ?? 0,
                    'quantity' => $siteSeeingData['quantity'] ?? 0,
                    'price_per_adult' => $siteSeeingData['price_per_adult'] ?? 0,
                ]);
            }
        }

        // Store Other Extras
        if ($request->has('extras')) {
            foreach ($validatedData['extras'] as $extraData) {
                // Skip if essential data like description is missing or if all price/qty fields are zero/empty
                if (empty($extraData['description']) && (empty($extraData['unit_price']) || $extraData['unit_price'] == 0) && (empty($extraData['quantity_per_pax']) || $extraData['quantity_per_pax'] == 0)) {
                    continue;
                }
                GroupQuotationExtra::create([
                    'group_quotation_id' => $groupQuotation->id,
                    'date' => $extraData['date'] ?? null,
                    'description' => $extraData['description'],
                    'unit_price' => $extraData['unit_price'] ?? 0,
                    'quantity_per_pax' => $extraData['quantity_per_pax'] ?? 0,
                    'total_price' => ($extraData['unit_price'] ?? 0) * ($extraData['quantity_per_pax'] ?? 0), // Calculate total price
                ]);
            }
        }

        // Optionally, update the quotation status to indicate completion or move to a summary/review stage
        $groupQuotation->status = 'pending'; // Or 'completed', 'review', etc.
        $groupQuotation->save();

        return redirect()->route('group_quotations.index')->with('success', 'Site Seeing & Extras saved! Quotation is now pending.');
    }

    /**
     * Display the specified group quotation.
     */
    public function show($id)
    {
        $groupQuotation = GroupQuotation::with([
            'market',
            'customer',
            'driver',
            'guide',
            'paxSlabs.paxSlab',
            'paxSlabs.vehicleType',
            'accommodations.hotel',
            'accommodations.mealPlan',
            'accommodations.roomCategory',
            'accommodations.roomDetails',
            'accommodations.additionalRooms',
            'travelPlans.route',
            'travelPlans.vehicleType',
            'travelPlans.jeepCharges',
            'jeepCharges',
            'siteSeeings',
            'extras',
            'members',
            // Temporarily remove this line until the table exists
            // 'quotations.customer'
        ])->findOrFail($id);

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
        $groupQuotation = GroupQuotation::findOrFail($id); // Changed from Quotation to GroupQuotation

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
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

        return response()->json(['success' => true, 'message' => 'Group quotation status updated successfully!']);
    }

    /**
     * Handle rejected status logic
     */
    private function handleRejectedStatus(GroupQuotation $groupQuotation)
    {
        // Store current booking reference in temp table if it's not already marked as rejected
        if ($groupQuotation->booking_reference && !str_ends_with($groupQuotation->booking_reference, '- Rejected')) {
            GroupTempSaveRefno::create([
                'booking_reference' => $groupQuotation->booking_reference,
                'quote_reference' => $groupQuotation->quote_reference, // Ensure this field exists or is relevant
            ]);
            $groupQuotation->booking_reference = $groupQuotation->booking_reference . '- Rejected';
            // The save will be handled by the updateStatus method
        }
    }

    /**
     * Handle pending status logic
     */
    private function handlePendingStatus(GroupQuotation $groupQuotation)
    {
        $originalBookingReference = str_replace('- Rejected', '', $groupQuotation->booking_reference);
        $tempRestored = false;

        // Attempt to restore booking reference from temp table
        if ($groupQuotation->quote_reference && $originalBookingReference) {
            $temp = GroupTempSaveRefno::where('quote_reference', $groupQuotation->quote_reference)->where('booking_reference', $originalBookingReference)->latest()->first();

            if ($temp) {
                // Ensure the booking reference from temp is not currently active elsewhere
                if (!GroupQuotation::where('booking_reference', $temp->booking_reference)->where('id', '!=', $groupQuotation->id)->exists()) {
                    $groupQuotation->booking_reference = $temp->booking_reference;
                    $temp->delete();
                    $tempRestored = true;
                } else {
                    \Log::warning("TempBookRef: Booking reference {$temp->booking_reference} for quote {$groupQuotation->quote_reference} is already active. Temp record not used and deleted.");
                    $temp->delete(); // Clean up unusable temp record
                }
            }
        }

        if (!$tempRestored) {
            // If not restored from temp, we need to ensure a valid booking reference.
            // This could be stripping "- Rejected" or generating a new sequential one.
            // For robust sequencing, let's prefer generating a new one if the current one is marked rejected or if no temp was found.

            $baseBookingRefForGeneration = null;
            $currentBookingParts = explode('/', $originalBookingReference);
            if (count($currentBookingParts) > 1) {
                // Check if we have at least Prefix/Sequence
                array_pop($currentBookingParts); // Remove the old sequence part
                $baseBookingRefForGeneration = implode('/', $currentBookingParts);
            }

            if ($baseBookingRefForGeneration) {
                $currentBookingSequence = 1;
                // Find the highest sequence number for this booking reference prefix in the group_quotations table
                $latestBookingInDB = GroupQuotation::where('booking_reference', 'LIKE', $baseBookingRefForGeneration . '/%')
                    // Exclude the current quotation itself from the check if its booking_reference is not the one being changed
                    ->where('id', '!=', $groupQuotation->id)
                    ->selectRaw("*, CAST(SUBSTRING_INDEX(REPLACE(booking_reference, '- Rejected', ''), '/', -1) AS UNSIGNED) as booking_seq_num")
                    ->orderBy('booking_seq_num', 'DESC')
                    ->first();

                if ($latestBookingInDB) {
                    $cleanLatestBookingRef = str_replace('- Rejected', '', $latestBookingInDB->booking_reference);
                    $parts = explode('/', $cleanLatestBookingRef);
                    $lastSubSeq = end($parts);
                    if (is_numeric($lastSubSeq)) {
                        $currentBookingSequence = intval($lastSubSeq) + 1;
                    }
                }

                // Loop to find the next available booking reference
                while (true) {
                    $bookingSequencePadded = str_pad($currentBookingSequence, 4, '0', STR_PAD_LEFT);
                    $generatedBookingRef = $baseBookingRefForGeneration . '/' . $bookingSequencePadded;

                    if (!GroupQuotation::where('booking_reference', $generatedBookingRef)->where('id', '!=', $groupQuotation->id)->exists()) {
                        $groupQuotation->booking_reference = $generatedBookingRef;
                        break;
                    }
                    $currentBookingSequence++;
                }
            } elseif (str_ends_with($groupQuotation->booking_reference ?? '', '- Rejected')) {
                // Fallback: If we couldn't derive a base for generation, but it was rejected, just strip "- Rejected".
                // This is less ideal as it doesn't guarantee sequential correctness if numbers were skipped.
                $groupQuotation->booking_reference = $originalBookingReference;
                \Log::info("Fallback: Stripped '- Rejected' for booking reference of GroupQuotation ID {$groupQuotation->id} as base for new generation could not be derived.");
            } else {
                // If booking reference was not rejected and no temp ref, and no base derivable,
                // it implies it might be a new quotation or one without a standard booking ref.
                // This scenario might need specific handling or logging.
                // For now, we assume it either had a temp ref, was rejected, or this function isn't called.
                \Log::warning("HandlePendingStatus: Could not determine a valid booking reference for GroupQuotation ID {$groupQuotation->id}. Current booking_reference: {$groupQuotation->booking_reference}");
            }
        }
        // The save will be handled by the updateStatus method
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

 public function hotelVouchers($id)
{
    // Load the group quotation with its accommodations
    $groupQuotation = GroupQuotation::with([
        'accommodations.hotel', 
        'accommodations.mealPlan', 
        'accommodations.roomCategory',
        'accommodations.roomDetails',
        'accommodations.additionalRooms',
        // Load related members and their quotations
        'members.quotation.accommodations.hotel',
        'members.quotation.accommodations.mealPlan',
        'members.quotation.accommodations.roomCategory',
        'members.quotation.accommodations.roomDetails'
    ])->findOrFail($id);
    
    // Collect related sub-quotations through members for easier access in the view
    $subQuotations = collect();
    foreach ($groupQuotation->members as $member) {
        if ($member->quotation && !$subQuotations->contains('id', $member->quotation->id)) {
            $subQuotations->push($member->quotation);
        }
    }
    
    return view('pages.allquotes.hotel_voucher.hotel_vouchers', compact('groupQuotation', 'subQuotations'));
}

public function editHotelVoucher($quotationId, $accommodationId)
{
    $quotation = GroupQuotation::with(['market', 'members'])->findOrFail($quotationId);
    $accommodation = GroupQuotationAccommodation::with([
        'hotel', 
        'mealPlan',
        'roomCategory', 
        'roomDetails',
        'additionalRooms'
    ])->findOrFail($accommodationId);
    
    $hotel = $accommodation->hotel;
    
    if (!$hotel) {
        return redirect()->route('group_quotations.hotel_vouchers', $quotationId)
            ->with('error', 'No hotel found for this accommodation');
    }
    
    // Calculate dates
    $checkIn = $accommodation->start_date;
    $checkOut = $accommodation->end_date;
    $nights = $accommodation->nights ?? $checkIn->diffInDays($checkOut);
    
    // Count rooms by type
    $roomCounts = [
        'single' => 0,
        'double' => 0,
        'twin' => 0,
        'triple' => 0,
        'guide' => 0
    ];
    
    // Count room configurations from room details
    if ($accommodation->roomDetails) {
        foreach ($accommodation->roomDetails as $detail) {
            if (stripos($detail->room_type, 'single') !== false) {
                $roomCounts['single'] += $detail->quantity ?? 1;
            } elseif (stripos($detail->room_type, 'double') !== false) {
                $roomCounts['double'] += $detail->quantity ?? 1;
            } elseif (stripos($detail->room_type, 'twin') !== false) {
                $roomCounts['twin'] += $detail->quantity ?? 1;
            } elseif (stripos($detail->room_type, 'triple') !== false) {
                $roomCounts['triple'] += $detail->quantity ?? 1;
            } elseif (stripos($detail->room_type, 'guide') !== false) {
                $roomCounts['guide'] += $detail->quantity ?? 1;
            }
        }
    }
    
    // Get adults/children count
    $adults = $quotation->members->where('type', 'adult')->count();
    $children = $quotation->members->where('type', 'child')->count();
    
    // Get room category
    $roomCategory = $accommodation->roomCategory ? $accommodation->roomCategory->name : 'Standard';
    
    // Get meal plan
    $mealPlan = $accommodation->mealPlan ? $accommodation->mealPlan->code : 'BB';
    
    // Special information
    $specialNotes = $accommodation->special_notes ?? '';
    $remarks = ""; // Build remarks from room pricing if available
    
    if ($accommodation->roomDetails) {
        $remarkParts = [];
        foreach ($accommodation->roomDetails as $detail) {
            if ($detail->per_night_cost) {
                $remarkParts[] = "{$mealPlan} {$detail->room_type} USD " . number_format($detail->per_night_cost, 2);
            }
        }
        if (!empty($remarkParts)) {
            $remarks = implode(', ', $remarkParts) . " (Reservation Code – {$quotation->booking_reference})";
        }
    }
    
    // Contact person - Get from authenticated user or from settings
    $contactPerson = auth()->user()->name . ' - ' . (auth()->user()->phone ?? '');
    
    return view('pages.allquotes.hotel_voucher.edit_hotel_voucher', compact(
        'quotation', 
        'accommodation',
        'hotel', 
        'checkIn', 
        'checkOut', 
        'nights', 
        'adults', 
        'children', 
        'roomCategory', 
        'mealPlan',
        'roomCounts',
        'specialNotes',
        'remarks',
        'contactPerson'
    ));
}

public function groupVouchers($mainRef)
{
    // Find all quotations with booking references that match the main reference pattern
    $quotations = GroupQuotation::where('booking_reference', 'like', $mainRef . '%')
                                ->where('status', 'approved')
                                ->get();
    
    if ($quotations->isEmpty()) {
        return redirect()->back()->with('error', 'No approved quotations found for this reference.');
    }

    return view('pages.allquotes.voucherselection', compact('mainRef', 'quotations'));
}
}
