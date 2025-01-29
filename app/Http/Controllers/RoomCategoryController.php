<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomCategoryRequest;
use App\Http\Requests\UpdateRoomCategoryRequest;
use App\Models\RoomCategory;
use Illuminate\Http\Request;

class RoomCategoryController extends Controller
{
    public function index()
    {
        $roomCategories = RoomCategory::latest()->paginate(10);
        return view('pages.room_categories.index', compact('roomCategories'));
    }

    public function create()
    {
        return view('pages.room_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:room_categories',
            'description' => 'nullable|string',
        ]);

        RoomCategory::create($request->all());

        return redirect()->route('room_categories.index')->with('success', 'Room Category added successfully.');
    }

    public function show(RoomCategory $roomCategory)
    {
        return view('pages.room_categories.show', compact('roomCategory'));
    }

    public function edit(RoomCategory $roomCategory)
    {
        return view('pages.room_categories.edit', compact('roomCategory'));
    }

    public function update(Request $request, RoomCategory $roomCategory)
    {
        $request->validate([
            'name' => "required|string|max:255|unique:room_categories,name,{$roomCategory->id}",
            'description' => 'nullable|string',
        ]);

        $roomCategory->update($request->all());

        return redirect()->route('room_categories.index')->with('success', 'Room Category updated successfully.');
    }

    public function destroy(RoomCategory $roomCategory)
    {
        $roomCategory->delete();
        return redirect()->route('room_categories.index')->with('success', 'Room Category deleted successfully.');
    }
}
