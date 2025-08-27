<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;

class Individualquotecontroller extends Controller
{
    //
    public function generateVoucher($bookingReference)
    {
        //dd($bookingReference);
        // Find the quotation by booking reference
        $quotation = Quotation::where('booking_reference', $bookingReference)->firstOrFail();

        // Debug the received booking reference and found quotation
        // dd($bookingReference, $quotation);

        // Check if the quotation is confirmed
        if ($quotation->status !== 'approved') {
            return redirect()->back()->with('error', 'Vouchers can only be generated for confirmed quotations.');
        }

        // Create an array of this single quotation to pass to the view
        $quotations = collect([$quotation]);
        $mainRef = $quotation->booking_reference;

        // Redirect to the voucher selection page
        return view('pages.allsinglequotes.voucherselection', compact('quotation', 'quotations', 'mainRef'));
    }
}
