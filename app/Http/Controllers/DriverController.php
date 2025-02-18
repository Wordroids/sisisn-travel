<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::paginate(10);
        
        return view('pages.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('pages.drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|email|unique:drivers,email',
            'per_day_charge' => 'required|numeric',
        ]);

        Driver::create($request->all());

        return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
        

    }


    public function edit($id)
    {
        
        $driver = Driver::findOrFail($id);

        return view('pages.drivers.edit', compact('driver'));
    }

    public function update(Request $request,  $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|email|unique:drivers,email,' . $id,
            'per_day_charge' => 'required|numeric',
        ]);

        $driver = Driver::findOrFail($id);
        $driver->update($request->all());

        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully.');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully.');
        
    }
}
