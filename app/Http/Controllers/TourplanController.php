<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupQuotation;
use App\Models\TourPlanGroup;
use App\Models\Quotation;
use Illuminate\Support\Carbon;

class TourplanController extends Controller
{
    public function index($main_ref)
    {
        // Get the group quotation
        $groupQuotation = GroupQuotation::where('booking_reference', $main_ref)->first();

        // Get all tour plans for this group quotation
        $tourPlans = TourPlanGroup::where('group_quotation_id', $main_ref)->orderBy('created_at', 'desc')->get();

        // For each tour plan, extract start and end dates from itinerary
        foreach ($tourPlans as $plan) {
            // Initialize with default values
            $plan->start_date = null;
            $plan->end_date = null;
            $plan->duration = null;

            // Get start and end dates from itinerary if available
            if (!empty($plan->itinerary_days)) {
                $dates = collect($plan->itinerary_days)
                    ->pluck('date')
                    ->filter()
                    ->filter(function ($date) {
                        return !empty($date) && $date !== '0000-00-00';
                    })
                    ->values();

                if ($dates->isNotEmpty()) {
                    try {
                        $plan->start_date = $dates->min();
                        $plan->end_date = $dates->max();

                        // Calculate duration - corrected to prevent negative values
                        if ($plan->start_date && $plan->end_date) {
                            $start = Carbon::parse($plan->start_date);
                            $end = Carbon::parse($plan->end_date);

                            // Calculate from start date to end date (not the reverse)
                            $plan->duration = $start->diffInDays($end); // +1 to include both start and end days
                        }
                    } catch (\Exception $e) {
                        // Log error but continue processing
                        \Log::error('Error calculating dates for tour plan ID: ' . $plan->id . ' - ' . $e->getMessage());
                    }
                }
            }

            // Set a title for the tour plan
            $plan->title = 'Tour Plan (' . Carbon::parse($plan->created_at)->format('d M Y') . ')';
        }

        return view('pages.allquotes.tour_plan.tourplanindex', [
            'groupQuotation' => $groupQuotation,
            'tourPlans' => $tourPlans,
            'main_ref' => $main_ref,
        ]);
    }

    public function create($main_ref)
    {
        // Find all quotations with this booking reference pattern (both main and sub)
        $allQuotations = GroupQuotation::where(function ($query) use ($main_ref) {
            $query->where('booking_reference', $main_ref)->orWhere('booking_reference', 'like', $main_ref . '/%');
        })
            ->where('status', 'approved')
            ->orderBy('start_date', 'asc') // Order by start date to get proper sequence
            ->get();

        if ($allQuotations->isEmpty()) {
            return redirect()->route('all_confirmed_quotations')->with('error', 'No approved quotations found for this reference.');
        }

        // Get the earliest start date and latest end date from all quotations
        $tourStartDate = $allQuotations->min('start_date');
        $tourEndDate = $allQuotations->max('end_date');

        // Format dates if they exist
        $tourStartDate = $tourStartDate ? Carbon::parse($tourStartDate)->format('Y-m-d') : null;
        $tourEndDate = $tourEndDate ? Carbon::parse($tourEndDate)->format('Y-m-d') : null;

        // Pass the data to the view
        return view('pages.allquotes.tour_plan.tour_plan_create', [
            'groupQuotations' => $allQuotations,
            'main_ref' => $main_ref,
            'tourStartDate' => $tourStartDate,
            'tourEndDate' => $tourEndDate,
        ]);
    }

    public function store(Request $request, $main_ref)
    {
        //dd(request()->all());
        // Validate the form data
        $validated = $request->validate([
            'guests' => 'nullable|array',
            'detailed_guests' => 'nullable|array',
            'tour_notes' => 'nullable|string',
            'itinerary' => 'nullable|array',
            'important_notes' => 'nullable|string',
        ]);

        // Create a new TourPlan with JSON columns
        $tourPlan = new TourPlanGroup();
        $tourPlan->group_quotation_id = $main_ref;
        $tourPlan->tour_notes = $request->input('tour_notes');
        $tourPlan->important_notes = $request->input('important_notes');
        $tourPlan->guests = $request->input('guests', []);
        $tourPlan->detailed_guests = $request->input('detailed_guests', []);
        $tourPlan->itinerary_days = $request->input('itinerary', []);
        $tourPlan->created_by = auth()->id();
        $tourPlan->save();

        // Redirect to the tour plan view page
        return redirect()->route('tour_plan_vouchers.index', $main_ref)->with('success', 'Tour plan created successfully!');
    }

    public function edit($main_ref, $id)
{
    // Find the tour plan
    $tourPlan = TourPlanGroup::findOrFail($id);
    
    // Find all quotations with this booking reference pattern (both main and sub)
    $allQuotations = GroupQuotation::where(function ($query) use ($main_ref) {
        $query->where('booking_reference', $main_ref)
              ->orWhere('booking_reference', 'like', $main_ref . '/%');
    })
    ->where('status', 'approved')
    ->orderBy('start_date', 'asc')
    ->get();
    
    // Get the earliest start date and latest end date from all quotations
    $tourStartDate = $allQuotations->min('start_date');
    $tourEndDate = $allQuotations->max('end_date');
    
    // Format dates if they exist
    $tourStartDate = $tourStartDate ? Carbon::parse($tourStartDate)->format('Y-m-d') : null;
    $tourEndDate = $tourEndDate ? Carbon::parse($tourEndDate)->format('Y-m-d') : null;
    
    return view('pages.allquotes.tour_plan.tour_plan_edit', [
        'tourPlan' => $tourPlan,
        'groupQuotations' => $allQuotations,
        'main_ref' => $main_ref,
        'tourStartDate' => $tourStartDate,
        'tourEndDate' => $tourEndDate,
    ]);
}

public function update(Request $request, $main_ref, $id)
{
    // Validate the form data
    $validated = $request->validate([
        'guests' => 'nullable|array',
        'detailed_guests' => 'nullable|array',
        'tour_notes' => 'nullable|string',
        'itinerary' => 'nullable|array',
        'important_notes' => 'nullable|string',
    ]);
    
    try {
        // Find and update the tour plan
        $tourPlan = TourPlanGroup::findOrFail($id);
        $tourPlan->tour_notes = $request->input('tour_notes');
        $tourPlan->important_notes = $request->input('important_notes');
        $tourPlan->guests = $request->input('guests', []);
        $tourPlan->detailed_guests = $request->input('detailed_guests', []);
        $tourPlan->itinerary_days = $request->input('itinerary', []);
        $tourPlan->save();
        
        return redirect()->route('tour_plan_vouchers.index', $main_ref)
                        ->with('success', 'Tour plan updated successfully!');
    } catch (\Exception $e) {
        // Log the error
        \Log::error('Error updating tour plan: ' . $e->getMessage());
        
        // Redirect with error message
        return back()->withInput()
                    ->with('error', 'Failed to update tour plan: ' . $e->getMessage());
    }
}

    public function select($main_ref)
    {
        // Find all quotations with this booking reference pattern (both main and sub)
        $quotations = GroupQuotation::where(function ($query) use ($main_ref) {
            $query->where('booking_reference', $main_ref)->orWhere('booking_reference', 'like', $main_ref . '/%');
        })
            ->where('status', 'approved')
            ->orderByRaw('booking_reference = ? DESC', [$main_ref]) // Main ref first
            ->orderBy('start_date', 'asc')
            ->get();

        if ($quotations->isEmpty()) {
            return redirect()->route('all_confirmed_quotations')->with('error', 'No approved quotations found for this reference.');
        }

        // Get the earliest start date and latest end date from all quotations
        $tourStartDate = $quotations->min('start_date');
        $tourEndDate = $quotations->max('end_date');

        // Format dates if they exist
        $tourStartDate = $tourStartDate ? Carbon::parse($tourStartDate)->format('Y-m-d') : null;
        $tourEndDate = $tourEndDate ? Carbon::parse($tourEndDate)->format('Y-m-d') : null;

        return view('pages.allquotes.tour_plan.tour_plan_select', [
            'quotations' => $quotations,
            'main_ref' => $main_ref,
            'tourStartDate' => $tourStartDate,
            'tourEndDate' => $tourEndDate,
        ]);
    }

    
}
