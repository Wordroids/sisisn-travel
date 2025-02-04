<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
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
use App\Models\RoomType;
use App\Models\TravelRoute;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotations = Quotation::with(['market', 'customer'])->latest()->get();
        return view('pages.quotations.index', compact('quotations'));
    }

    public function show($id)
    {
        $quotation = Quotation::with([
            'market',
            'customer',
            'paxSlabs.paxSlab',
            'paxSlabs.vehicleType',
            'accommodations.hotel',
            'accommodations.mealPlan',
            'accommodations.roomType',
            'travelPlans.route',
            'travelPlans.vehicleType'
        ])->findOrFail($id);

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

        // Generate Quote & Booking Reference
        $quoteReference = 'QT/SP/' . (Quotation::max('id') + 1001);
        $bookingReference = 'ST/SP/' . (Quotation::max('id') + 1001);

        return view('pages.quotations.step-01')->with(['markets' => $markets, 'customers' => $customers, 'currencies' => $currencies, 'quoteReference' => $quoteReference, 'bookingReference' => $bookingReference, 'paxSlabs' => $paxSlabs]);
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
        ]);


        return redirect()->route('quotations.step2', $quotation->id)->with('success', 'Step 1 saved! Proceed to Pax Slab details.');
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

        return view('pages.quotations.step-02', compact('quotation', 'paxSlabs', 'vehicleTypes'));
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
                ]
            );
        }
        return redirect()->route('quotations.step3', $quotation->id)->with('success', 'Pax Slab details saved.');
    }


    public function step_three($id)
    {
        $quotation = Quotation::findOrFail($id);

        // Fetch system data for selection
        $hotels = Hotel::all();
        $mealPlans = MealPlan::all();
        $roomCategories = RoomCategory::all();
        $roomTypes = RoomType::all();

        return view('pages.quotations.step-03', compact('quotation', 'hotels', 'mealPlans', 'roomCategories', 'roomTypes'));
    }

    public function store_step_three(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);
    
        // Validate input
        $request->validate([
            'accommodations' => 'required|array',
            'accommodations.*.hotel_id' => 'required|exists:hotels,id',
            'accommodations.*.start_date' => 'required|date',
            'accommodations.*.end_date' => 'required|date|after_or_equal:accommodations.*.start_date',
            'accommodations.*.meal_plan_id' => 'required|exists:meal_plans,id',
            'accommodations.*.room_category_id' => 'required|exists:room_categories,id',
            'accommodations.*.room_type_id' => 'required|exists:room_types,id',
            'accommodations.*.per_night_cost' => 'required|numeric|min:0',
            'accommodations.*.nights' => 'required|integer|min:1',
            'accommodations.*.total_cost' => 'required|numeric|min:0',
        ]);
        // dd($request->all());
        
    
        foreach ($request->accommodations as $accommodation) {
            QuotationAccommodation::create([
                'quotation_id' => $quotation->id,
                'hotel_id' => $accommodation['hotel_id'],
                'start_date' => $accommodation['start_date'],
                'end_date' => $accommodation['end_date'],
                'meal_plan_id' => $accommodation['meal_plan_id'],
                'room_category_id' => $accommodation['room_category_id'],
                'room_type_id' => $accommodation['room_type_id'],
                'per_night_cost' => $accommodation['per_night_cost'],
                'nights' => $accommodation['nights'],
                'total_cost' => $accommodation['total_cost'],
            ]);
        }
    
        return redirect()->route('quotations.step4', $quotation->id)->with('success', 'Accommodation saved.');
    }
    

    public function step_four($id)
    {
        $quotation = Quotation::findOrFail($id);

        // Fetch system data for selection
        $routes = TravelRoute::all();

        // Define vehicle types and their default rates
        $vehicleTypes = VehicleType::all();

        return view('pages.quotations.step4', compact('quotation', 'routes', 'vehicleTypes'));
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

        // Redirect to Quotation List page after final step
        return redirect()->route('quotations.index')->with('success', 'Quotation process completed successfully.');
    }
}
