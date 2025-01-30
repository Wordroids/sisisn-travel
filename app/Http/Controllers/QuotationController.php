<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Currency;
use App\Models\Customers;
use App\Models\Market;
use App\Models\PaxSlab;
use App\Models\Quotation;
use App\Models\QuotationPaxSlab;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function step_one()
    {
        $markets = Market::all();
        $customers = Customers::all();
        $currencies = Currency::all();
        $paxSlabs = PaxSlab::all(); // Fetch Pax Slabs from 

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
    
        // Fetch the selected Pax Slab from DB
        $selectedPaxSlab = PaxSlab::find($quotation->pax_slab_id);
    
        // Define vehicle types and their default rates
        $vehicleTypes = [
            'Car' => 32,
            'Van' => 40,
            'Mini Coach' => 50,
            'New Coach' => 110,
            '45 Seat Coach' => 120,
        ];
    
        return view('pages.quotations.step-02', compact('quotation', 'selectedPaxSlab', 'vehicleTypes'));
    }
    
    public function store_step_two(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);
    
        $request->validate([
            'pax_slab' => 'required|array',
            'pax_slab.*.exact_pax' => 'required|integer|min:1',
            'pax_slab.*.vehicle_type' => 'required|string',
            'pax_slab.*.vehicle_payout_rate' => 'required|numeric',
        ]);
    
        foreach ($request->pax_slab as $index => $slab) {
            QuotationPaxSlab::create([
                'quotation_id' => $quotation->id,
                'exact_pax' => $slab['exact_pax'],
                'vehicle_type' => $slab['vehicle_type'],
                'vehicle_payout_rate' => $slab['vehicle_payout_rate'],
            ]);
        }
    
        return redirect()->route('quotations.step3', $quotation->id)->with('success', 'Pax Slab details saved.');
    }
    
}
