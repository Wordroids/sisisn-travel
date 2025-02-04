<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $vehicleTypes = VehicleType::all();
        return view('pages.vehicle_types.index', compact('vehicleTypes'));
    }

    public function create()
    {
        return view('pages.vehicle_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:vehicle_types,name',
            'default_rate' => 'required|numeric|min:0',
        ]);

        VehicleType::create($request->all());

        return redirect()->route('vehicle_types.index')->with('success', 'Vehicle Type created successfully.');
    }

    public function edit(VehicleType $vehicleType)
    {
        return view('pages.vehicle_types.edit', compact('vehicleType'));
    }

    public function update(Request $request, VehicleType $vehicleType)
    {
        $request->validate([
            'name' => 'required|string|unique:vehicle_types,name,' . $vehicleType->id,
            'default_rate' => 'required|numeric|min:0',
        ]);

        $vehicleType->update($request->all());

        return redirect()->route('vehicle_types.index')->with('success', 'Vehicle Type updated successfully.');
    }

    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();

        return redirect()->route('vehicle_types.index')->with('success', 'Vehicle Type deleted successfully.');
    }
}
