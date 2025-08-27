<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\IndividualTourPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;


class IndividualTourPlanController extends Controller
{
    /**
     * Display a listing of the tour plans for an individual quotation.
     *
     * @param string $quotationId
     * @return \Illuminate\Http\Response
     */
    public function index($quotationId)
    {
        $quotation = Quotation::findOrFail($quotationId);
        $tourPlans = IndividualTourPlan::where('quotation_id', $quotationId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.allsinglequotes.tour_plan.tourplanindex', [
            'quotation' => $quotation,
            'tourPlans' => $tourPlans
        ]);
    }

    /**
     * Show the form for creating a new tour plan.
     *
     * @param string $quotationId
     * @return \Illuminate\Http\Response
     */
    public function create($quotationId)
    {
        $quotation = Quotation::findOrFail($quotationId);
        
        // Get tour dates for min/max date validation
        $tourStartDate = $quotation->start_date;
        $tourEndDate = $quotation->end_date;

        return view('pages.allsinglequotes.tour_plan.tour_plan_create', [
            'quotation' => $quotation,
            'tourStartDate' => $tourStartDate,
            'tourEndDate' => $tourEndDate
        ]);
    }

    /**
     * Store a newly created tour plan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $quotationId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $quotationId)
    {
        $quotation = Quotation::findOrFail($quotationId);
        
        $validatedData = $request->validate([
            'tour_notes' => 'nullable|string',
            'important_notes' => 'nullable|string',
            'guests' => 'nullable|array',
            'itinerary' => 'nullable|array'
        ]);

        // Create tour plan
        $tourPlan = new IndividualTourPlan();
        $tourPlan->quotation_id = $quotation->id;
        $tourPlan->title = $quotation->name . ' Tour Plan';
        $tourPlan->start_date = $quotation->start_date;
        $tourPlan->end_date = $quotation->end_date;
        $tourPlan->duration = $quotation->duration;
        $tourPlan->tour_notes = $request->tour_notes;
        $tourPlan->important_notes = $request->important_notes;
        $tourPlan->guests = json_encode($request->guests ?? []);
        $tourPlan->itinerary_days = json_encode($request->itinerary ?? []);
        $tourPlan->save();

        return redirect()->route('individual_tour_plan_vouchers.index', $quotationId)
            ->with('success', 'Tour plan created successfully.');
    }

    /**
     * Show the form for editing the specified tour plan.
     *
     * @param  string  $quotationId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($quotationId, $id)
    {
        $quotation = Quotation::findOrFail($quotationId);
        $tourPlan = IndividualTourPlan::findOrFail($id);

        // Get tour dates for min/max date validation
        $tourStartDate = $quotation->start_date;
        $tourEndDate = $quotation->end_date;

        return view('pages.allsinglequotes.tour_plan.tour_plan_edit', [
            'quotation' => $quotation,
            'tourPlan' => $tourPlan,
            'tourStartDate' => $tourStartDate,
            'tourEndDate' => $tourEndDate
        ]);
    }

    /**
     * Update the specified tour plan in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $quotationId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $quotationId, $id)
    {
        $validatedData = $request->validate([
            'tour_notes' => 'nullable|string',
            'important_notes' => 'nullable|string',
            'guests' => 'nullable|array',
            'itinerary' => 'nullable|array'
        ]);

        // Update tour plan
        $tourPlan = IndividualTourPlan::findOrFail($id);
        $tourPlan->tour_notes = $request->tour_notes;
        $tourPlan->important_notes = $request->important_notes;
        $tourPlan->guests = json_encode($request->guests ?? []);
        $tourPlan->itinerary_days = json_encode($request->itinerary ?? []);
        $tourPlan->save();

        return redirect()->route('individual_tour_plan_vouchers.index', $quotationId)
            ->with('success', 'Tour plan updated successfully.');
    }

    /**
     * Remove the specified tour plan from storage.
     *
     * @param  string  $quotationId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($quotationId, $id)
    {
        $tourPlan = IndividualTourPlan::findOrFail($id);
        $tourPlan->delete();

        return redirect()->route('individual_tour_plan_vouchers.index', $quotationId)
            ->with('success', 'Tour plan deleted successfully.');
    }

    /**
     * Generate PDF for the specified tour plan.
     *
     * @param  string  $quotationId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generatePdf($mainRef, $id)
{
    // Fetch the tour plan
    $tourPlan = IndividualTourPlan::findOrFail($id);

    // Fetch related quotation
    $quotation = $tourPlan->quotation;

    // Prepare variables for the view
    $main_ref = $mainRef;
    $startDate = $tourPlan->start_date ? $tourPlan->start_date->format('d M Y') : null;
    $endDate = $tourPlan->end_date ? $tourPlan->end_date->format('d M Y') : null;
    $duration = $tourPlan->duration ?? null;

    // Generate PDF using Spatie
    return Pdf::view('pages.allquotes.pdf.tour_plan_pdf', [
        'quotation' => $quotation,
        'tourPlan' => $tourPlan,
        'main_ref' => $main_ref,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'duration' => $duration
    ])
    ->format('a4')
    ->name("Tour_Plan_{$tourPlan->title}.pdf")
    ->download(); // Use ->stream() to open in browser
}

}