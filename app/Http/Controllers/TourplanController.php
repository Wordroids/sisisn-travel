<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupQuotation;
use App\Models\Quotation;
use Illuminate\Support\Carbon;

class TourplanController extends Controller
{
    public function index($main_ref)
    {
        //dd("TourplanController index method reached", $main_ref);
        // Get the group quotation
        $groupQuotation = GroupQuotation::where('booking_reference', $main_ref)->first();

        // For debugging, try without TourPlan query first
        return view('pages.allquotes.tour_plan.tourplanindex', [
            'groupQuotation' => $groupQuotation,
            'tourPlans' => [], // Empty array for now
            'main_ref' => $main_ref,
        ]);
    }

    public function create($main_ref)
    {
        // Get the group quotation
        $groupQuotation = GroupQuotation::where('booking_reference', $main_ref)
            ->orWhere('booking_reference', 'like', $main_ref . '/%')
            ->where('status', 'approved')
            ->get();

        if (!$groupQuotation) {
            return redirect()->route('all_confirmed_quotations')->with('error', 'Group quotation not found.');
        }

        //dd($groupQuotation);

        // Pass the data to the view
        return view('pages.allquotes.tour_plan.tour_plan_create', [
            'groupQuotation' => $groupQuotation,

            'main_ref' => $main_ref,
        ]);
    }

    
}
