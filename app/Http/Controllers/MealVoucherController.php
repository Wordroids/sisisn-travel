<?php

namespace App\Http\Controllers;

use App\Models\MealVoucherAmendment;
use App\Models\GroupQuotation;
use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Models\Market;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;

class MealVoucherController extends Controller
{
    public function index($mainRef)
{
    // First find the group quotation record(s) that match this main reference
    $quotations = GroupQuotation::where('booking_reference', $mainRef)
        ->orWhere('booking_reference', 'like', $mainRef . '/%')
        ->where('status', 'approved')
        ->get();

    if ($quotations->isEmpty()) {
        return redirect()->back()->with('error', 'Group quotation not found');
    }

    // Get all the quotation IDs
    $quotationIds = $quotations->pluck('id')->toArray();

    // Now fetch meal vouchers that are linked to any of these quotations
    $mealVouchers = MealVoucherAmendment::whereIn('group_quotation_id', $quotationIds)
        ->orderBy('voucher_date', 'desc')
        ->get();

    return view('pages.allquotes.meal_voucher.meal_vouchers', compact('mealVouchers', 'mainRef'));
}

    public function create($mainRef)
    {
        $groupQuotation = GroupQuotation::where('booking_reference', $mainRef)
            ->orWhere('booking_reference', 'like', $mainRef . '/%')
            ->where('status', 'approved')
            ->first();

        if (!$groupQuotation) {
            return redirect()->back()->with('error', 'Group quotation not found');
        }

        // Get the base reference (without sub-numbers)
        $baseRef = preg_replace('/\/\d+$/', '', $groupQuotation->booking_reference);

        // Find all quotations with this booking reference pattern
        $subTours = GroupQuotation::where(function ($query) use ($baseRef) {
            $query->where('booking_reference', $baseRef)
                ->orWhere('booking_reference', 'like', $baseRef . '/%');
        })
            ->where('status', 'approved')
            ->get();
        
        $hotels = Hotel::orderBy('name')->get();
        $markets = Market::orderBy('name')->get();
        $mealVoucher = new MealVoucherAmendment();
        
        return view('pages.allquotes.meal_voucher.edit', compact('mainRef', 'groupQuotation', 'hotels', 'markets', 'mealVoucher', 'subTours'));
    }

    public function store(Request $request, $mainRef)
    {
        $request->validate([
            'voucher_date' => 'required|date',
            'hotel_name' => 'required|string',
            'meal_plan' => 'required|string',
            'selected_tours_data' => 'required|json',
        ]);

        // Find the group quotation
        $groupQuotation = GroupQuotation::where('booking_reference', $mainRef)
            ->orWhere('booking_reference', 'like', $mainRef . '/%')
            ->where('status', 'approved')
            ->first();

        if (!$groupQuotation) {
            return redirect()->back()->with('error', 'Group quotation not found');
        }
        
        $hotel = null;
        if ($request->hotel_id) {
            $hotel = Hotel::find($request->hotel_id);
        }

        // Create the meal voucher
        $mealVoucher = MealVoucherAmendment::create([
            'group_quotation_id' => $groupQuotation->id,
            'voucher_date' => $request->voucher_date,
            'hotel_id' => $request->hotel_id,
            'hotel_name' => $request->hotel_name,
            'hotel_address' => $hotel ? $hotel->location : null,
            'market' => $request->market,
            'meal_plan' => $request->meal_plan,
            'special_notes' => $request->special_notes,
            'billing_instructions' => $request->billing_instructions,
            'remarks' => $request->remarks,
            'reservation_note' => $request->reservation_note,
            'contact_person' => $request->contact_person,
            'selected_tours_data' => $request->selected_tours_data,
        ]);

        return redirect()->route('meal_vouchers.index', $mainRef)
            ->with('success', 'Meal voucher created successfully.');
    }

    public function edit($mainRef, $id)
    {
        $mealVoucher = MealVoucherAmendment::findOrFail($id);
        $groupQuotation = GroupQuotation::findOrFail($mealVoucher->group_quotation_id);
        
        // Get the base reference (without sub-numbers)
        $baseRef = preg_replace('/\/\d+$/', '', $groupQuotation->booking_reference);

        // Find all quotations with this booking reference pattern
        $subTours = GroupQuotation::where(function ($query) use ($baseRef) {
            $query->where('booking_reference', $baseRef)
                ->orWhere('booking_reference', 'like', $baseRef . '/%');
        })
            ->where('status', 'approved')
            ->get();
            
        $hotels = Hotel::orderBy('name')->get();
        $markets = Market::orderBy('name')->get();
        
        return view('pages.allquotes.meal_voucher.edit', compact('mealVoucher', 'mainRef', 'hotels', 'markets', 'subTours'));
    }

    public function update(Request $request, $mainRef, $id)
    {
        $request->validate([
            'voucher_date' => 'required|date',
            'hotel_name' => 'required|string',
            'meal_plan' => 'required|string',
            'selected_tours_data' => 'required|json',
        ]);

        $mealVoucher = MealVoucherAmendment::findOrFail($id);
        
        $hotel = null;
        if ($request->hotel_id) {
            $hotel = Hotel::find($request->hotel_id);
        }

        $mealVoucher->update([
            'voucher_date' => $request->voucher_date,
            'hotel_id' => $request->hotel_id,
            'hotel_name' => $request->hotel_name,
            'hotel_address' => $hotel ? $hotel->location : null,
            'market' => $request->market,
            'meal_plan' => $request->meal_plan,
            'special_notes' => $request->special_notes,
            'billing_instructions' => $request->billing_instructions,
            'remarks' => $request->remarks,
            'reservation_note' => $request->reservation_note,
            'contact_person' => $request->contact_person,
            'selected_tours_data' => $request->selected_tours_data,
        ]);

        return redirect()->route('meal_vouchers.index', $mainRef)
            ->with('success', 'Meal voucher updated successfully.');
    }

    public function destroy($mainRef, $id)
    {
        $mealVoucher = MealVoucherAmendment::findOrFail($id);
        $mealVoucher->delete();

        return redirect()->route('meal_vouchers.index', $mainRef)
            ->with('success', 'Meal voucher deleted successfully.');
    }

    public function generatePdf($mainRef, $id)
{
    $mealVoucher = MealVoucherAmendment::findOrFail($id);
        $quotation = GroupQuotation::findOrFail($mealVoucher->group_quotation_id);
        
        $amendmentText = null; // Set this if it's an amendment
        
        // Spatie PDF generation is different from DomPDF
        return Pdf::view('pages.allquotes.pdf.meal_voucher_pdf', [
            'mealVoucher' => $mealVoucher,
            'quotation' => $quotation,
            'amendmentText' => $amendmentText
        ])
          ->format('a4')
          ->name('meal_voucher.pdf')
         ->download();
    }
}
