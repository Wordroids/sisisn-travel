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

        // Create template with JSON data
        $template = QuotationTemplate::create([
            'template_name' => $request->template_name,
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

    /**
     * Create a new quotation from a template.
     */
    public function createQuotationFromTemplate(Request $request)
    {
        $templates = QuotationTemplate::where('is_active', true)->get();
        $markets = Market::all();
        $customers = Customers::all();
        $currencies = Currency::all();
        $paxSlabs = PaxSlab::ordered()->get();
        $markups = MarkUpValue::all();
        $drivers = Driver::all();
        $guides = Guide::all();

        // Generate quote reference and booking reference logic (same as in QuotationController)
        // ...

        return view('pages.quotation-templates.create-quotation', compact('templates', 'markets', 'customers', 'currencies', 'paxSlabs', 'markups', 'drivers', 'guides'));
    }

    /**
     * Store a new quotation created from a template.
     */
    public function storeQuotationFromTemplate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template_id' => 'required|exists:quotation_templates,id',
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

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the template
        $template = QuotationTemplate::findOrFail($request->template_id);

        // Create the quotation with basic info
        // Code to create quotation and associated records using template data
        // ...

        return redirect()->route('quotations.index')->with('success', 'Quotation created successfully from template');
    }
}
