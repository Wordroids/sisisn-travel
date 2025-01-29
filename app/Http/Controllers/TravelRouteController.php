<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTravelRouteRequest;
use App\Http\Requests\UpdateTravelRouteRequest;
use App\Models\TravelRoute;
use Illuminate\Http\Request;

class TravelRouteController extends Controller
{
    public function index()
    {
        $travelRoutes = TravelRoute::latest()->paginate(10);
        return view('pages.travel_routes.index', compact('travelRoutes'));
    }

    public function create()
    {
        return view('pages.travel_routes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:travel_routes',
            'description' => 'nullable|string',
            'mileage' => 'nullable|integer|min:1', // Validate mileage
        ]);

        TravelRoute::create($request->all());

        return redirect()->route('travel_routes.index')->with('success', 'Travel Route added successfully.');
    }

    public function show(TravelRoute $travelRoute)
    {
        return view('pages.travel_routes.show', compact('travelRoute'));
    }

    public function edit(TravelRoute $travelRoute)
    {
        return view('pages.travel_routes.edit', compact('travelRoute'));
    }

    public function update(Request $request, TravelRoute $travelRoute)
    {
        $request->validate([
            'name' => "required|string|max:255|unique:travel_routes,name,{$travelRoute->id}",
            'description' => 'nullable|string',
            'mileage' => 'nullable|integer|min:1',
        ]);

        $travelRoute->update($request->all());

        return redirect()->route('travel_routes.index')->with('success', 'Travel Route updated successfully.');
    }


    public function destroy(TravelRoute $travelRoute)
    {
        $travelRoute->delete();
        return redirect()->route('travel_routes.index')->with('success', 'Travel Route deleted successfully.');
    }
}
