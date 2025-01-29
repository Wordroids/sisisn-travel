<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::latest()->paginate(10);
        return view('pages.currencies.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:currencies',
            'code' => 'required|string|max:10|unique:currencies',
            'conversion_rate' => 'required|numeric|min:0',
        ]);

        Currency::create($request->all());

        return redirect()->route('currencies.index')->with('success', 'Currency added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Currency $currency)
    {
        return view('pages.currencies.show', compact('currency'));
    }

    public function edit(Currency $currency)
    {
        return view('pages.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'name' => "required|string|max:255|unique:currencies,name,{$currency->id}",
            'code' => "required|string|max:10|unique:currencies,code,{$currency->id}",
            'conversion_rate' => 'required|numeric|min:0',
        ]);

        $currency->update($request->all());

        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
}
