<?php


namespace App\Http\Controllers;

use App\Models\IndividualMealVoucher;
use App\Models\Quotation;
use App\Models\Hotel;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;

class IndividualMealVoucherController extends Controller
{
    public function index($quotationId)
    {
        // Find the quotation
        $quotation = Quotation::findOrFail($quotationId);
        
        // Get all meal vouchers for this quotation
        $mealVouchers = IndividualMealVoucher::where('quotation_id', $quotationId)
            ->orderBy('voucher_date', 'desc')
            ->get();
            
        return view('pages.allsinglequotes.meal_voucher.meal_vouchers', [
            'mealVouchers' => $mealVouchers,
            'quotation' => $quotation,
            'mainRef' => $quotation->booking_reference
        ]);
    }
    
    /**
     * Show the form for creating a new meal voucher.
     *
     * @param string $quotationId
     * @return \Illuminate\Http\Response
     */
    public function create($quotationId)
    {
        // Find the quotation
        $quotation = Quotation::findOrFail($quotationId);
        
        // Get hotels and markets for dropdown
        $hotels = Hotel::orderBy('name')->get();
        $markets = Market::orderBy('name')->get();
        
        // Create a new meal voucher instance
        $mealVoucher = new IndividualMealVoucher();
        
        // Get start and end dates from quotation for date range
        $startDate = $quotation->start_date ? \Carbon\Carbon::parse($quotation->start_date) : now();
        $endDate = $quotation->end_date ? \Carbon\Carbon::parse($quotation->end_date) : now()->addDays(1);
        
        return view('pages.allsinglequotes.meal_voucher.edit', [
            'mealVoucher' => $mealVoucher,
            'quotation' => $quotation,
            'mainRef' => $quotation->id,
            'hotels' => $hotels,
            'markets' => $markets,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'paxCount' => $quotation->adults + $quotation->children
        ]);
    }
    
    /**
     * Store a newly created meal voucher in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $quotationId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $quotationId)
    {
        $request->validate([
            'voucher_date' => 'required|date',
            'hotel_name' => 'required|string',
            'meal_plan' => 'required|string',
            'meal_dates' => 'required|string'
        ]);
        
        $quotation = Quotation::findOrFail($quotationId);
        
        $hotel = null;
        if ($request->hotel_id) {
            $hotel = Hotel::find($request->hotel_id);
        }
        
        // Create the meal voucher
        $mealVoucher = IndividualMealVoucher::create([
            'quotation_id' => $quotation->id,
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
           'meal_dates' => $request->meal_dates
        ]);
        
        return redirect()->route('individual_meal_vouchers.index', $quotation->id)
            ->with('success', 'Meal voucher created successfully.');
    }
    
    /**
     * Show the form for editing the specified meal voucher.
     *
     * @param  string  $quotationId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($quotationId, $id)
    {
        // Find the meal voucher
        $mealVoucher = IndividualMealVoucher::findOrFail($id);
        
        // Find the quotation
        $quotation = Quotation::findOrFail($quotationId);
        
        // Get hotels and markets for dropdown
        $hotels = Hotel::orderBy('name')->get();
        $markets = Market::orderBy('name')->get();
        
        // Get start and end dates from quotation for date range
        $startDate = $quotation->start_date ? \Carbon\Carbon::parse($quotation->start_date) : now();
        $endDate = $quotation->end_date ? \Carbon\Carbon::parse($quotation->end_date) : now()->addDays(1);
        
        return view('pages.allsinglequotes.meal_voucher.edit', [
            'mealVoucher' => $mealVoucher,
            'quotation' => $quotation,
            'mainRef' => $quotation->booking_reference,
            'hotels' => $hotels,
            'markets' => $markets,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'paxCount' => $quotation->adults + $quotation->children
        ]);
    }
    
    /**
     * Update the specified meal voucher in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $quotationId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $quotationId, $id)
    {
        $request->validate([
            'voucher_date' => 'required|date',
            'hotel_name' => 'required|string',
            'meal_plan' => 'required|string',
            'meal_dates' => 'required|string' 
        ]);
        
        // Find the meal voucher
        $mealVoucher = IndividualMealVoucher::findOrFail($id);
        
        $hotel = null;
        if ($request->hotel_id) {
            $hotel = Hotel::find($request->hotel_id);
        }
        
        // Update the meal voucher
        $mealVoucher->update([
            'voucher_date' => $request->voucher_date,
            'hotel_id' => $request->hotel_id,
            'hotel_name' => $request->hotel_name,
            'hotel_address' => $hotel ? $hotel->location : $mealVoucher->hotel_address,
            'market' => $request->market,
            'meal_plan' => $request->meal_plan,
            'special_notes' => $request->special_notes,
            'billing_instructions' => $request->billing_instructions,
            'remarks' => $request->remarks,
            'reservation_note' => $request->reservation_note,
            'contact_person' => $request->contact_person,
            'meal_dates' => $request->meal_dates
        ]);
        
        return redirect()->route('individual_meal_vouchers.index', $quotationId)
            ->with('success', 'Meal voucher updated successfully.');
    }
    
    /**
     * Remove the specified meal voucher from storage.
     *
     * @param  string  $quotationId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($quotationId, $id)
    {
        $mealVoucher = IndividualMealVoucher::findOrFail($id);
        $mealVoucher->delete();
        
        return redirect()->route('individual_meal_vouchers.index', $quotationId)
            ->with('success', 'Meal voucher deleted successfully.');
    }
    
    /**
     * Generate PDF for the specified meal voucher.
     *
     * @param  string  $quotationId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generatePdf($quotationId, $id)
{
    // Find the meal voucher with related data
    $mealVoucher = IndividualMealVoucher::with('quotation')->findOrFail($id);
    $quotation = $mealVoucher->quotation;
    
    $amendmentText = null;
    if ($mealVoucher->is_amendment) {
        $amendmentText = $mealVoucher->amendment_number . '<sup>' . $this->getOrdinalSuffix($mealVoucher->amendment_number) . '</sup>';
    }
    
    // Spatie PDF generation - matching your group meal voucher controller
    return Pdf::view('pages.allsinglequotes.pdf.meal_voucher_pdf', [
        'mealVoucher' => $mealVoucher,
        'quotation' => $quotation,
        'amendmentText' => $amendmentText
    ])
    ->format('a4')
    ->name('meal_voucher_' . str_replace(['/', '\\'], '_', $quotation->booking_reference) . '.pdf')
    ->download();
}
    
    /**
     * Create a meal voucher amendment based on an existing voucher.
     *
     * @param  string  $quotationId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createAmendment($quotationId, $id)
    {
        // Find the original meal voucher
        $originalVoucher = IndividualMealVoucher::findOrFail($id);
        $quotation = Quotation::findOrFail($quotationId);
        
        // Create a new amendment voucher based on the original
        $amendment = $originalVoucher->replicate();
        $amendment->is_amendment = true;
        $amendment->amendment_number = ($originalVoucher->is_amendment ? $originalVoucher->amendment_number : 0) + 1;
        $amendment->voucher_date = now();
        $amendment->save();
        
        return redirect()->route('individual_meal_vouchers.edit', ['quotation' => $quotationId, 'id' => $amendment->id])
            ->with('success', 'Amendment created successfully. Please make your changes and save.');
    }
    
    /**
     * Get ordinal suffix for a number
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