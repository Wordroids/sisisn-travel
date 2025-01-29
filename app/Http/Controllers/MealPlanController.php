<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMealPlanRequest;
use App\Http\Requests\UpdateMealPlanRequest;
use App\Models\MealPlan;
use Illuminate\Http\Request;

class MealPlanController extends Controller
{
    public function index()
    {
        $mealPlans = MealPlan::latest()->paginate(10);
        return view('pages.meal_plans.index', compact('mealPlans'));
    }

    public function create()
    {
        return view('pages.meal_plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:meal_plans',
            'description' => 'nullable|string',
        ]);

        MealPlan::create($request->all());

        return redirect()->route('meal_plans.index')->with('success', 'Meal Plan added successfully.');
    }

    public function show(MealPlan $mealPlan)
    {
        return view('pages.meal_plans.show', compact('mealPlan'));
    }

    public function edit(MealPlan $mealPlan)
    {
        return view('pages.meal_plans.edit', compact('mealPlan'));
    }

    public function update(Request $request, MealPlan $mealPlan)
    {
        $request->validate([
            'name' => "required|string|max:255|unique:meal_plans,name,{$mealPlan->id}",
            'description' => 'nullable|string',
        ]);

        $mealPlan->update($request->all());

        return redirect()->route('meal_plans.index')->with('success', 'Meal Plan updated successfully.');
    }

    public function destroy(MealPlan $mealPlan)
    {
        $mealPlan->delete();
        return redirect()->route('meal_plans.index')->with('success', 'Meal Plan deleted successfully.');
    }
}
