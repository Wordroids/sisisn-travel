<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;

class GuidesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guides = Guide::paginate(10);

        return view('pages.guides.index', compact('guides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('pages.guides.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_no' => 'required|string|min:10|max:15',
            'address' => 'required|string',
            'email' => 'required|email|unique:guides,email',
            'per_day_charge' => 'required|numeric|min:0',
        ]);
    
        Guide::create($validated);
    
        return redirect()->route('guides.index')
            ->with('success', 'Guide created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guide $guide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $guides = Guide::findOrFail($id);
        
        return view('pages.guides.edit', compact('guides'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guide $guide)
    {
        //
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_no' => 'required|string|min:10|max:15',
            'address' => 'required|string',
            'email' => 'required|email|unique:guides,email,' . $guide->id,
            'per_day_charge' => 'required|numeric|min:0',
        ]);
    
        $guide->update($validated);
    
        return redirect()->route('guides.index')
            ->with('success', 'Guide updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guide $guide)
    {
        //
        $guide = Guide::findOrFail($guide->id);
        $guide->delete();

        return redirect()->route('guides.index')
            ->with('success', 'Guide deleted successfully.');
    }
}
