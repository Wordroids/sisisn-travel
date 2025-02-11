<?php

namespace App\Http\Controllers;

use App\Models\MarkUpValue;
use Illuminate\Http\Request;

class MarkUpValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $markups = MarkUpValue::all();
        return view('pages.markupvalue.index', compact('markups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.markupvalue.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        MarkUpValue::create($request->all());
        
        return redirect()->route('markup.index')
            ->with('success', 'Markup created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MarkUpValue $markup)
    {
        return view('pages.markupvalue.show', compact('markup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MarkUpValue $markup)
    {
        return view('pages.markupvalue.edit', compact('markup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MarkUpValue $markup)
    {
        $request->validate([
            'name' => 'required|unique:mark_up,name,' . $markup->id,
            'amount' => 'required|numeric|min:0',
        ]);

        $markup->update($request->all());
        
        return redirect()->route('markup.index')
            ->with('success', 'Markup updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarkUpValue $markup)
    {
        $markup->delete();
        
        return redirect()->route('markup.index')
            ->with('success', 'Markup deleted successfully.');
    }
}