<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::latest()->paginate(10);
        return view('pages.hotels.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.hotels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:hotels',
            'location' => 'required|string|max:255',
            'star_rating' => 'required|integer|min:1|max:5',
            'description' => 'nullable|string',
        ]);

        Hotel::create($request->all());

        return redirect()->route('hotels.index')->with('success', 'Hotel added successfully.');
    }

    public function show(Hotel $hotel)
    {
        return view('pages.hotels.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        return view('pages.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name' => "required|string|max:255|unique:hotels,name,{$hotel->id}",
            'location' => 'required|string|max:255',
            'star_rating' => 'required|integer|min:1|max:5',
            'description' => 'nullable|string',
        ]);

        $hotel->update($request->all());

        return redirect()->route('hotels.index')->with('success', 'Hotel updated successfully.');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('hotels.index')->with('success', 'Hotel deleted successfully.');
    }
}
