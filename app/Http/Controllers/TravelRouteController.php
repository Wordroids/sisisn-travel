<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTravelRouteRequest;
use App\Http\Requests\UpdateTravelRouteRequest;
use App\Models\TravelRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Assets;

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
            'mileage' => 'nullable|integer|min:1',
            'images' => 'array|max:2', // Validate max 2 images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Each image max 2MB
        ]);

        // Create travel route
        $travelRoute = TravelRoute::create($request->except('images'));

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('travel-routes', 'public');

                // Create asset record
                $travelRoute->assets()->create([
                    'file_path' => $path,
                    'file_type' => 'image',
                    'is_featured' => false,
                ]);
            }

            // Set first image as featured
            if ($travelRoute->assets()->count() > 0) {
                $travelRoute
                    ->assets()
                    ->first()
                    ->update(['is_featured' => true]);
            }
        }

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
            'images' => 'array|max:2',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $travelRoute->update($request->except('images'));

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('travel-routes', 'public');

                $travelRoute->assets()->create([
                    'file_path' => $path,
                    'file_type' => 'image',
                    'is_featured' => false,
                ]);
            }

            // Set first image as featured if no featured image exists
            if (!$travelRoute->assets()->where('is_featured', true)->exists()) {
                $travelRoute
                    ->assets()
                    ->first()
                    ->update(['is_featured' => true]);
            }
        }

        return redirect()->route('travel_routes.index')->with('success', 'Travel Route updated successfully.');
    }

    // Add this new method for deleting images
    public function deleteImage($id)
    {
        $asset = Assets::findOrFail($id);
        $wasFeatured = $asset->is_featured;

        // Delete the file from storage
        Storage::disk('public')->delete($asset->file_path);

        // Delete the asset record
        $asset->delete();

        // If this was the featured image, set another image as featured
        if ($wasFeatured) {
            $firstAsset = $asset->assetable->assets()->first();
            if ($firstAsset) {
                $firstAsset->update(['is_featured' => true]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function destroy(TravelRoute $travelRoute)
    {
        $travelRoute->delete();
        return redirect()->route('travel_routes.index')->with('success', 'Travel Route deleted successfully.');
    }
}
