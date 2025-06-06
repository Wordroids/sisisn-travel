<?php

namespace App\Http\Controllers;

use App\Models\QuotationTemplate;
use App\Models\Hotel;
use App\Models\MealPlan;
use App\Models\RoomCategory;
use App\Models\TravelRoute;
use App\Models\VehicleType;
use App\Models\PaxSlab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Market;
use App\Models\Customers;
use App\Models\Currency;
use App\Models\MarkUpValue;
use App\Models\Driver;
use App\Models\Guide;

class QuotationTemplateController extends Controller
{
    /**
     * Display a listing of the quotation templates.
     */
    public function index()
    {
        $templates = QuotationTemplate::with('createdBy')->latest()->paginate(10);

        return view('pages.quotations_templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new template.
     */
    public function create()
    {
        $hotels = Hotel::all();
        $mealPlans = MealPlan::all();
        $roomCategories = RoomCategory::all();
        $routes = TravelRoute::all();
        $vehicleTypes = VehicleType::all();
        $paxSlabs = PaxSlab::ordered()->get();

        return view('pages.quotations_templates.create', compact('hotels', 'mealPlans', 'roomCategories', 'routes', 'vehicleTypes', 'paxSlabs'));
    }

    /**
     * Store a newly created template in storage.
     */
    public function store(Request $request)
    {
        // Remove the dd() statement to allow the code to continue execution
        $validator = Validator::make($request->all(), [
            'template_name' => 'required|string|max:255',
            'description' => 'nullable|string',

            // Accommodations validation
            'accommodations' => 'required|array',
            'accommodations.*.hotel_id' => 'nullable|exists:hotels,id',
            'accommodations.*.meal_plan_id' => 'nullable|exists:meal_plans,id',
            'accommodations.*.room_category_id' => 'nullable|exists:room_categories,id',
            'accommodations.*.room_types' => 'nullable|array',
            'accommodations.*.room_types.single.per_night_cost' => 'nullable|numeric|min:0',
            'accommodations.*.room_types.double.per_night_cost' => 'nullable|numeric|min:0',
            'accommodations.*.room_types.triple.per_night_cost' => 'nullable|numeric|min:0',

            // Travel plans validation
            'travel_plans' => 'required|array',
            'travel_plans.*.route_id' => 'nullable|exists:travel_routes,id',
            'travel_plans.*.vehicle_type_id' => 'nullable|exists:vehicle_types,id',
            'travel_plans.*.mileage' => 'nullable|numeric|min:0',

            // Site seeings validation
            'site_seeings' => 'required|array',
            'site_seeings.*.name' => 'nullable|string|max:255',
            'site_seeings.*.type' => 'nullable|string|in:site',
            'site_seeings.*.unit_price' => 'nullable|numeric|min:0',
            'site_seeings.*.quantity' => 'nullable|integer|min:1',
            'site_seeings.*.price_per_adult' => 'nullable|numeric|min:0',

            // Site extras validation
            'site_extras' => 'required|array',
            'site_extras.*.name' => 'nullable|string|max:255',
            'site_extras.*.type' => 'nullable|string|in:extra',
            'site_extras.*.unit_price' => 'nullable|numeric|min:0',
            'site_extras.*.quantity' => 'nullable|integer|min:1',
            'site_extras.*.price_per_adult' => 'nullable|numeric|min:0',

            // Extras validation
            'extras' => 'required|array',
            'extras.*.description' => 'nullable|string|max:255',
            'extras.*.unit_price' => 'nullable|numeric|min:0',
            'extras.*.quantity_per_pax' => 'nullable|integer|min:1',
            'extras.*.total_price' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Generate Quote & Booking Reference for the template
        $sequenceNumber = (QuotationTemplate::max('id') ?? 0) + 1001;
        $quoteReference = 'QT/SP/';

        // Use the selected booking reference format and find the latest number
        if ($request->booking_ref_format === 'ce') {
            $prefix = 'ST/SIC/CE/';
            $latestRef = QuotationTemplate::where('booking_reference', 'like', $prefix.'%')
                ->orderByRaw('CAST(SUBSTRING(booking_reference, ' . (strlen($prefix) + 1) . ') AS UNSIGNED) DESC')
                ->first();
        } else {
            $prefix = 'ST/SIC/';
            $latestRef = QuotationTemplate::where('booking_reference', 'like', $prefix.'%')
                ->orderByRaw('CAST(SUBSTRING(booking_reference, ' . (strlen($prefix) + 1) . ') AS UNSIGNED) DESC')
                ->first();
        }

        // Extract number from latest reference or start from 1000
        if ($latestRef) {
            $latestNumber = (int)substr($latestRef->booking_reference, strlen($prefix));
            $sequenceNumber = $latestNumber + 1;
        } else {
            $sequenceNumber = 1000;
        }

        // Set the references
        $quoteReference .= $sequenceNumber;
        $bookingReference = $prefix . $sequenceNumber;

        // Create template with JSON data
        $template = QuotationTemplate::create([
            'template_name' => $request->template_name,
            'quote_reference' => $quoteReference,
            'booking_reference' => $bookingReference,
            'description' => $request->description,
            'is_active' => true,
            'created_by' => Auth::id(),
            'accommodations' => $request->accommodations,
            'travel_plans' => $request->travel_plans,
            'site_seeings' => $request->site_seeings,
            'site_extras' => $request->site_extras,
            'extras' => $request->extras,
        ]);

        return redirect()->route('quotations_templates.index')->with('success', 'Quotation template created successfully');
    }

    /**
     * Display the specified template.
     */
    public function show(QuotationTemplate $template)
    {
        // Load all the related models for displaying names instead of just IDs
        $hotels = Hotel::all();
        $mealPlans = MealPlan::all();
        $roomCategories = RoomCategory::all();
        $routes = TravelRoute::all();
        $vehicleTypes = VehicleType::all();
        
        return view('pages.quotations_templates.show', compact(
            'template', 
            'hotels', 
            'mealPlans', 
            'roomCategories', 
            'routes', 
            'vehicleTypes'
        ));
    }

    /**
     * Show the form for editing the specified template.
     */
    public function edit(QuotationTemplate $template)
    {
        $hotels = Hotel::all();
        $mealPlans = MealPlan::all();
        $roomCategories = RoomCategory::all();
        $routes = TravelRoute::all();
        $vehicleTypes = VehicleType::all();

        return view('pages.quotations_templates.edit', compact('template', 'hotels', 'mealPlans', 'roomCategories', 'routes', 'vehicleTypes'));
    }

    /**
     * Update the specified template in storage.
     */
    public function update(Request $request, QuotationTemplate $template)
    {
        $validator = Validator::make($request->all(), [
            'template_name' => 'required|string|max:255',
            'description' => 'nullable|string',

            // Accommodations validation
            'accommodations' => 'required|array',
            'accommodations.*.hotel_id' => 'nullable|exists:hotels,id',
            'accommodations.*.meal_plan_id' => 'nullable|exists:meal_plans,id',
            'accommodations.*.room_category_id' => 'nullable|exists:room_categories,id',
            'accommodations.*.room_types' => 'nullable|array',
            'accommodations.*.room_types.single.per_night_cost' => 'nullable|numeric|min:0',
            'accommodations.*.room_types.double.per_night_cost' => 'nullable|numeric|min:0',
            'accommodations.*.room_types.triple.per_night_cost' => 'nullable|numeric|min:0',

            // Travel plans validation
            'travel_plans' => 'required|array',
            'travel_plans.*.route_id' => 'nullable|exists:travel_routes,id',
            'travel_plans.*.vehicle_type_id' => 'nullable|exists:vehicle_types,id',
            'travel_plans.*.mileage' => 'nullable|numeric|min:0',

            // Site seeings validation
            'site_seeings' => 'required|array',
            'site_seeings.*.name' => 'nullable|string|max:255',
            'site_seeings.*.type' => 'nullable|string|in:site',
            'site_seeings.*.unit_price' => 'nullable|numeric|min:0',
            'site_seeings.*.quantity' => 'nullable|integer|min:1',
            'site_seeings.*.price_per_adult' => 'nullable|numeric|min:0',

            // Site extras validation
            'site_extras' => 'required|array',
            'site_extras.*.name' => 'nullable|string|max:255',
            'site_extras.*.type' => 'nullable|string|in:extra',
            'site_extras.*.unit_price' => 'nullable|numeric|min:0',
            'site_extras.*.quantity' => 'nullable|integer|min:1',
            'site_extras.*.price_per_adult' => 'nullable|numeric|min:0',

            // Extras validation
            'extras' => 'required|array',
            'extras.*.description' => 'nullable|string|max:255',
            'extras.*.unit_price' => 'nullable|numeric|min:0',
            'extras.*.quantity_per_pax' => 'nullable|integer|min:1',
            'extras.*.total_price' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $template->update([
            'template_name' => $request->template_name,
            'description' => $request->description,
            'accommodations' => $request->accommodations,
            'travel_plans' => $request->travel_plans,
            'site_seeings' => $request->site_seeings,
            'site_extras' => $request->site_extras,
            'extras' => $request->extras,
        ]);

        return redirect()->route('quotations_templates.index')->with('success', 'Quotation template updated successfully');
    }

    /**
     * Remove the specified template from storage.
     */
    public function destroy(QuotationTemplate $template)
    {
        $template->delete();

        return redirect()->route('quotations_templates.index')->with('success', 'Quotation template deleted successfully');
    }

    /**
     * Toggle the active status of a template.
     */
    public function toggleStatus(QuotationTemplate $template)
    {
        $template->is_active = !$template->is_active;
        $template->save();

        return redirect()->back()->with('success', 'Template status updated successfully');
    }

}
