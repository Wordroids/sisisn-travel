<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::latest()->paginate(10);
        return view('pages.room_types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('pages.room_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:room_types',
            'description' => 'nullable|string',
        ]);

        RoomType::create($request->all());

        return redirect()->route('room_types.index')->with('success', 'Room Type added successfully.');
    }

    public function show(RoomType $roomType)
    {
        return view('pages.room_types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        return view('pages.room_types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $request->validate([
            'name' => "required|string|max:255|unique:room_types,name,{$roomType->id}",
            'description' => 'nullable|string',
        ]);

        $roomType->update($request->all());

        return redirect()->route('room_types.index')->with('success', 'Room Type updated successfully.');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return redirect()->route('room_types.index')->with('success', 'Room Type deleted successfully.');
    }
}
