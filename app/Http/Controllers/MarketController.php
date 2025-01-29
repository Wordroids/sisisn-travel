<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarketRequest;
use App\Http\Requests\UpdateMarketRequest;
use App\Models\Market;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $markets = Market::latest()->paginate(10);
        return view('pages.markets.index', compact('markets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.markets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:markets',
        ]);

        Market::create($request->all());

        return redirect()->route('markets.index')->with('success', 'Market added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Market $market)
    {
        return view('pages.markets.show', compact('market'));
    }

    public function edit(Market $market)
    {
        return view('pages.markets.edit', compact('market'));
    }

    public function update(Request $request, Market $market)
    {
        $request->validate([
            'name' => "required|string|max:255|unique:markets,name,{$market->id}",
        ]);

        $market->update($request->all());

        return redirect()->route('markets.index')->with('success', 'Market updated successfully.');
    }

    public function destroy(Market $market)
    {
        $market->delete();
        return redirect()->route('markets.index')->with('success', 'Market deleted successfully.');
    }
}
