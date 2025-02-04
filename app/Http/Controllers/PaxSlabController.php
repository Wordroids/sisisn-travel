<?php

namespace App\Http\Controllers;

use App\Models\PaxSlab;
use Illuminate\Http\Request;

class PaxSlabController extends Controller
{

    public function index()
    {
        $paxSlabs = PaxSlab::orderBy('order')->get();
        return view('pages.pax_slabs.index', compact('paxSlabs'));
    }

    public function create()
    {
        return view('pages.pax_slabs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:pax_slabs,name',
            'min_pax' => 'required|integer|min:1',
            'max_pax' => 'required|integer|min:1|gte:min_pax',
            'order' => 'required|integer',
        ]);

        PaxSlab::create($request->all());

        return redirect()->route('pax_slabs.index')->with('success', 'Pax Slab created successfully.');
    }

    public function edit(PaxSlab $paxSlab)
    {
        return view('pages.pax_slabs.edit', compact('paxSlab'));
    }

    public function update(Request $request, PaxSlab $paxSlab)
    {
        $request->validate([
            'name' => 'required|string|unique:pax_slabs,name,' . $paxSlab->id,
            'min_pax' => 'required|integer|min:1',
            'max_pax' => 'required|integer|min:1|gte:min_pax',
            'order' => 'required|integer',
        ]);

        $paxSlab->update($request->all());

        return redirect()->route('pax_slabs.index')->with('success', 'Pax Slab updated successfully.');
    }

    public function destroy(PaxSlab $paxSlab)
    {
        $paxSlab->delete();

        return redirect()->route('pax_slabs.index')->with('success', 'Pax Slab deleted successfully.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            PaxSlab::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['message' => 'Order updated successfully.']);
    }
}
