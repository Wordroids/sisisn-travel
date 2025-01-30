<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Currency;
use App\Models\Customers;
use App\Models\Market;
use App\Models\Quotation;
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

        // Generate Quote & Booking Reference
        $quoteReference = 'QT/SP/' . (Quotation::max('id') + 1001);
        $bookingReference = 'ST/SP/' . (Quotation::max('id') + 1001);

        return view('pages.quotations.step-01')->with(['markets' => $markets, 'customers' => $customers, 'currencies' => $currencies, 'quoteReference' => $quoteReference, 'bookingReference' => $bookingReference]);
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
        ]);


        return redirect()->route('quotations.step2', $quotation->id)->with('success', 'Step 1 saved! Proceed to Pax Slab details.');
    }

    public function step_two($id)
    {
        $quotation = Quotation::findOrFail($id);

        // Pass quotation details to the view
        return view('pages.quotations.step-02', compact('quotation'));
    }
}
