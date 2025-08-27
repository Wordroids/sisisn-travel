<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Hotel;
use App\Models\QuotationAccommodation;
use App\Models\IndividualHotelVoucher;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class IndividualhotelvoucherController extends Controller
{
    /**
     * Display a listing of hotel vouchers for the specified individual quotation.
     *
     * @param string $quotationId
     * @return \Illuminate\Http\Response
     */
    public function individualHotelVouchers($quotationId)
    {
        // Find the quotation
        $quotation = Quotation::findOrFail($quotationId);
        
        // Get all accommodations for this quotation
        $accommodations = QuotationAccommodation::with(['hotel', 'roomCategory', 'mealPlan'])
            ->where('quotation_id', $quotation->id)
            ->get();
            
        // Group accommodations by hotel
        $hotelGroups = [];
        foreach ($accommodations as $accommodation) {
            if (!isset($hotelGroups[$accommodation->hotel_id])) {
                $hotelGroups[$accommodation->hotel_id] = [
                    'hotel' => $accommodation->hotel,
                    'accommodations' => []
                ];
            }
            
            $hotelGroups[$accommodation->hotel_id]['accommodations'][] = $accommodation;
        }
        
        return view('pages.allsinglequotes.hotel_voucher.hotel_vouchers', [
            'quotation' => $quotation,
            'hotelGroups' => $hotelGroups,
        ]);
    }
    
    /**
     * Show the form for creating a new hotel voucher.
     *
     * @param string $quotationId
     * @param int $accommodationId
     * @return \Illuminate\Http\Response
     */
    public function editHotelVoucher($quotationId, $accommodationId)
    {
        $quotation = Quotation::findOrFail($quotationId);
        $accommodation = QuotationAccommodation::with(['hotel', 'roomCategory', 'mealPlan'])->findOrFail($accommodationId);
        
        // Check if a voucher already exists for this accommodation
        $voucher = IndividualHotelVoucher::where('quotation_id', $quotation->id)
            ->where('hotel_id', $accommodation->hotel_id)
            ->first();
            
        // If no voucher exists, create default data
        if (!$voucher) {
            $voucher = new IndividualHotelVoucher();
            $voucher->quotation_id = $quotation->id;
            $voucher->hotel_id = $accommodation->hotel_id;
            $voucher->booking_name = $quotation->customer ? $quotation->customer->name : '';
            $voucher->voucher_date = now();
            $voucher->arrival_date = $accommodation->start_date;
            $voucher->departure_date = $accommodation->end_date;
            $voucher->total_nights = $accommodation->nights;
            $voucher->hotel_address = $accommodation->hotel ? $accommodation->hotel->address : '';
            $voucher->room_category = $accommodation->roomCategory ? $accommodation->roomCategory->name : '';
            $voucher->meal_plan = $accommodation->mealPlan ? $accommodation->mealPlan->name : '';
            $voucher->adults = $quotation->adults ?? 1;
            $voucher->children = $quotation->children ?? 0;
            
            // Create room counts JSON
            $roomCounts = [
                'single' => 0,
                'double' => 0,
                'twin' => 0,
                'triple' => 0,
                'extra_bed' => 0
            ];
            
            // Set default room based on quotation data
            $paxCount = ($quotation->adults ?? 1) + ($quotation->children ?? 0);
            if ($paxCount <= 1) {
                $roomCounts['single'] = 1;
            } else if ($paxCount == 2) {
                $roomCounts['double'] = 1;
            } else if ($paxCount == 3) {
                $roomCounts['triple'] = 1;
            } else {
                // For larger groups, calculate rooms (simplified)
                $roomCounts['double'] = floor($paxCount / 2);
                if ($paxCount % 2 != 0) {
                    $roomCounts['single'] = 1;
                }
            }
            
            $voucher->room_counts = json_encode($roomCounts);
        }
        
        $markets = Market::all();
        
        return view('pages.allsinglequotes.hotel_voucher.edit_hotel_voucher2', [
            'quotation' => $quotation,
            'accommodation' => $accommodation,
            'voucher' => $voucher,
            'markets' => $markets
        ]);
    }
    
    /**
     * Store or update the hotel voucher.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $quotationId
     * @param int $accommodationId
     * @return \Illuminate\Http\Response
     */
    public function storeHotelVoucher(Request $request, $quotationId, $accommodationId)
    {
        // Validate the request data
        $validated = $request->validate([
            'voucher_date' => 'required|date',
            'booking_name' => 'required|string|max:255',
            'arrival_date' => 'required|date',
            'departure_date' => 'required|date|after_or_equal:arrival_date',
            'total_nights' => 'required|integer|min:1',
            'hotel_address' => 'nullable|string',
            'room_category' => 'nullable|string|max:255',
            'meal_plan' => 'required|string|max:255',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'special_notes' => 'nullable|string',
            'billing_instructions' => 'nullable|string',
            'remarks' => 'nullable|string',
            'reservation_note' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'room_counts.single' => 'required|integer|min:0',
            'room_counts.double' => 'required|integer|min:0',
            'room_counts.twin' => 'required|integer|min:0',
            'room_counts.triple' => 'required|integer|min:0',
            'room_counts.extra_bed' => 'required|integer|min:0',
        ]);
        
        $quotation = Quotation::findOrFail($quotationId);
        $accommodation = QuotationAccommodation::findOrFail($accommodationId);
        
        // Prepare room counts
        $roomCounts = [
            'single' => $request->input('room_counts.single', 0),
            'double' => $request->input('room_counts.double', 0),
            'twin' => $request->input('room_counts.twin', 0),
            'triple' => $request->input('room_counts.triple', 0),
            'extra_bed' => $request->input('room_counts.extra_bed', 0)
        ];
        
        // Find or create the voucher
        $voucher = IndividualHotelVoucher::updateOrCreate(
            [
                'quotation_id' => $quotation->id,
                'hotel_id' => $accommodation->hotel_id
            ],
            [
                'booking_name' => $request->booking_name,
                'voucher_date' => $request->voucher_date,
                'arrival_date' => $request->arrival_date,
                'departure_date' => $request->departure_date,
                'total_nights' => $request->total_nights,
                'hotel_address' => $request->hotel_address,
                'room_category' => $request->room_category,
                'meal_plan' => $request->meal_plan,
                'adults' => $request->adults,
                'children' => $request->children,
                'room_counts' => json_encode($roomCounts),
                'special_notes' => $request->special_notes,
                'billing_instructions' => $request->billing_instructions,
                'remarks' => $request->remarks,
                'reservation_note' => $request->reservation_note,
                'contact_person' => $request->contact_person,
            ]
        );
        
        return redirect()
            ->route('quotations.hotel_vouchers', $quotation->id)
            ->with('success', 'Hotel voucher saved successfully.');
    }
    
    /**
     * Generate and download the hotel voucher PDF.
     *
     * @param int $voucherId
     * @return \Illuminate\Http\Response
     */
    public function downloadHotelVoucherPDF($voucherId)
{
    // Find the voucher with related data
    $voucher = IndividualHotelVoucher::with(['quotation', 'hotel'])->findOrFail($voucherId);
    $quotation = $voucher->quotation;
    
    // Decode JSON data for room counts
    $roomCounts = json_decode($voucher->room_counts, true);
    
    // Generate PDF using the hotel_voucher_pdf_amendment2 template but adapted for individual vouchers
    $pdf = PDF::loadView('pages.allsinglequotes.pdf.hotel_voucher_pdf_amendment2', [
        'voucher' => $voucher,
        'quotation' => $quotation,
        'hotel' => $voucher->hotel,
        'arrivalDate' => \Carbon\Carbon::parse($voucher->arrival_date),
        'departureDate' => \Carbon\Carbon::parse($voucher->departure_date),
        'totalNights' => $voucher->total_nights,
        'roomCounts' => $roomCounts,
        'amendment' => $voucher, // Pass voucher as amendment to match template variables
        'amendmentText' => $voucher->is_amendment ? $voucher->amendment_number . '<sup>' . $this->getOrdinalSuffix($voucher->amendment_number) . '</sup> AMENDMENT' : '',
    ]);

    // Generate a safe filename by replacing slashes with underscores
    $safeBookingRef = str_replace(['/', '\\'], '_', $quotation->booking_reference);
    $fileName = 'hotel_voucher_' . $safeBookingRef . '_' . now()->format('Ymd') . '.pdf';
    
    return $pdf->download($fileName);
}

/**
 * Get the ordinal suffix for a number (1st, 2nd, 3rd, etc.)
 * 
 * @param int $number
 * @return string
 */
private function getOrdinalSuffix($number)
{
    if (!in_array(($number % 100), [11, 12, 13])) {
        switch ($number % 10) {
            case 1:  return 'ST';
            case 2:  return 'ND';
            case 3:  return 'RD';
        }
    }
    return 'TH';
}
}