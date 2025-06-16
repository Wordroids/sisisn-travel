<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupQuotation;
use App\Models\GroupQuotationAccommodation;
use App\Models\GroupQuotationMember;
use App\Models\Hotel;
use App\Models\MealPlan;
use App\Models\RoomCategory;
use App\Models\RoomDetail;
use Illuminate\Support\Facades\DB;
use App\Models\HotelVoucherAmendment;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;

class VoucherController extends Controller
{
    public function hotelVouchers($id)
    {
        // Load the group quotation with its accommodations
        $groupQuotation = GroupQuotation::with([
            'accommodations.hotel',
            'accommodations.mealPlan',
            'accommodations.roomCategory',
            'accommodations.roomDetails',
            'accommodations.additionalRooms',
            // Load related members and their quotations
            'members.quotation.accommodations.hotel',
            'members.quotation.accommodations.mealPlan',
            'members.quotation.accommodations.roomCategory',
            'members.quotation.accommodations.roomDetails',
        ])->findOrFail($id);

        // Collect related sub-quotations through members for easier access in the view
        $subQuotations = collect();
        foreach ($groupQuotation->members as $member) {
            if ($member->quotation && !$subQuotations->contains('id', $member->quotation->id)) {
                $subQuotations->push($member->quotation);
            }
        }

        return view('pages.allquotes.hotel_voucher.hotel_vouchers', compact('groupQuotation', 'subQuotations'));
    }

    public function groupVouchers($mainRef)
    {
        // Find all quotations with booking references that match the main reference pattern
        $quotations = GroupQuotation::where('booking_reference', 'like', $mainRef . '%')
            ->where('status', 'approved')
            ->get();

        if ($quotations->isEmpty()) {
            return redirect()->back()->with('error', 'No approved quotations found for this reference.');
        }

        return view('pages.allquotes.voucherselection', compact('mainRef', 'quotations'));
    }

    public function editHotelVoucher($quotationId, $accommodationId)
    {
        $quotation = GroupQuotation::findOrFail($quotationId);
        $accommodation = GroupQuotationAccommodation::findOrFail($accommodationId);
        $hotel = $accommodation->hotel;

        // Get the main reference (strip everything after the last slash if it exists)
        $mainRef = preg_replace('/\/.*$/', '', $quotation->booking_reference);

        // Find all related accommodations for this hotel across all quotations in the group
        $relatedQuotations = GroupQuotation::where(function ($query) use ($mainRef) {
            $query->where('booking_reference', $mainRef)->orWhere('booking_reference', 'like', $mainRef . '/%');
        })
            ->where('status', 'approved')
            ->get();

        $relatedAccommodations = GroupQuotationAccommodation::whereIn('group_quotation_id', $relatedQuotations->pluck('id'))->where('hotel_id', $hotel->id)->get();

        // Calculate total room counts across all related accommodations
        $roomCounts = [
            'single' => 0,
            'double' => 0,
            'twin' => 0,
            'triple' => 0,
            'guide' => 0,
        ];

        $adults = 0;
        $children = 0;

        // Get the latest amendment for this hotel voucher
        $latestAmendment = HotelVoucherAmendment::where('group_quotation_id', $quotation->id)->where('hotel_id', $hotel->id)->latest()->first();

        // If we have a previous amendment, use its values for room counts and additional info
        if ($latestAmendment) {
            // Use room counts from amendment
            $roomCounts = $latestAmendment->room_counts;
            $adults = $latestAmendment->adults;
            $children = $latestAmendment->children;

            // Get additional information from amendment
            $specialNotes = $latestAmendment->special_notes;
            $billingInstructions = $latestAmendment->billing_instructions;
            $remarks = $latestAmendment->remarks;
            $reservationNote = $latestAmendment->reservation_note;
            $contactPerson = $latestAmendment->contact_person;
            $mealPlan = $latestAmendment->meal_plan;

            // Calculate next amendment number
            $amendmentNumber = $latestAmendment->amendment_number + 1;
        } else {
            // Calculate from accommodations if no amendment exists
            foreach ($relatedAccommodations as $relatedAccommodation) {
                $roomCounts['single'] += $relatedAccommodation->single_rooms ?? 0;
                $roomCounts['double'] += $relatedAccommodation->double_rooms ?? 0;
                $roomCounts['twin'] += $relatedAccommodation->twin_rooms ?? 0;
                $roomCounts['triple'] += $relatedAccommodation->triple_rooms ?? 0;
                $roomCounts['guide'] += $relatedAccommodation->guide_rooms ?? 0;

                $adults += $relatedAccommodation->adults ?? 0;
                $children += $relatedAccommodation->children ?? 0;
            }

            $mealPlan = $accommodation->mealPlan ? $accommodation->mealPlan->name : 'BB';
        }

        // Get meal plan and room category from the first accommodation
        $roomCategory = $accommodation->roomCategory ? $accommodation->roomCategory->name : 'N/A';

        return view('pages.allquotes.hotel_voucher.edit_hotel_voucher', compact('quotation', 'accommodation', 'hotel', 'roomCounts', 'adults', 'children', 'mealPlan', 'roomCategory', 'relatedAccommodations', 'specialNotes', 'billingInstructions', 'remarks', 'reservationNote', 'contactPerson', 'amendmentNumber'));
    }

    public function generateHotelVouchers($mainRef)
    {
        // Remove the dd() debug statement
        // dd($mainRef);

        // Decode the mainRef if it was URL encoded
        $mainRef = urldecode($mainRef);

        // Find the main group quotation - modified to handle both formats
        // First try exact match
        $groupQuotation = GroupQuotation::where('booking_reference', $mainRef)->where('status', 'approved')->first();

        // If not found, check if this is already a sub-reference (like ST/SIC/1001/01)
        if (!$groupQuotation) {
            // Extract the main part (remove the last segment if it has more than 2 slashes)
            $parts = explode('/', $mainRef);
            if (count($parts) > 2) {
                // Remove the last segment to get the main reference
                array_pop($parts);
                $mainRef = implode('/', $parts);

                // Try to find the main quotation again
                $groupQuotation = GroupQuotation::where('booking_reference', $mainRef)->where('status', 'approved')->first();

                // If still not found, try finding a quotation with this reference pattern
                if (!$groupQuotation) {
                    $groupQuotation = GroupQuotation::where('booking_reference', 'like', $mainRef . '/%')
                        ->where('status', 'approved')
                        ->first();
                }
            }
        }

        if (!$groupQuotation) {
            return redirect()
                ->back()
                ->with('error', 'Group quotation not found for reference: ' . $mainRef);
        }

        // Get the base reference (without sub-numbers)
        $baseRef = preg_replace('/\/\d+$/', '', $groupQuotation->booking_reference);

        // Ensure accommodations relationship is loaded
        $groupQuotation->load('accommodations.hotel', 'accommodations.mealPlan', 'accommodations.roomCategory');

        // Find all quotations with this booking reference pattern (both main and sub)
        $allQuotations = GroupQuotation::where(function ($query) use ($baseRef) {
            $query->where('booking_reference', $baseRef)->orWhere('booking_reference', 'like', $baseRef . '/%');
        })
            ->where('status', 'approved')
            ->with(['accommodations.hotel', 'accommodations.mealPlan', 'accommodations.roomCategory'])
            ->get();

        // Set the main quotation (either the one found or the first one with this pattern)
        $mainQuotation = $groupQuotation;

        // Set sub-quotations (all except the main one)
        $subQuotations = $allQuotations->where('id', '!=', $mainQuotation->id);

        // Initialize an array to store hotels and their accommodations
        $hotelGroups = [];

        // Process all quotations to group accommodations by hotel
        foreach ($allQuotations as $quotation) {
            foreach ($quotation->accommodations as $accommodation) {
                // Skip if this accommodation doesn't have a hotel
                if (!$accommodation->hotel_id || !$accommodation->hotel) {
                    continue;
                }

                $hotelId = $accommodation->hotel_id;

                if (!isset($hotelGroups[$hotelId])) {
                    $hotelGroups[$hotelId] = [
                        'hotel' => $accommodation->hotel,
                        'accommodations' => [],
                        'quotations' => [],
                    ];
                }

                $hotelGroups[$hotelId]['accommodations'][] = $accommodation;
                $hotelGroups[$hotelId]['quotations'][$quotation->id] = $quotation;
            }
        }

        // Return the view with hotel groups data
        return view('pages.allquotes.hotel_voucher.hotel_vouchers', compact('groupQuotation', 'subQuotations', 'hotelGroups'));
    }


    public function editHotelVoucher2($quotationId, $accommodationId)
    {
        $quotation = GroupQuotation::findOrFail($quotationId);
        $accommodation = GroupQuotationAccommodation::findOrFail($accommodationId);
        $hotel = $accommodation->hotel;

        // Get the main reference (strip everything after the last slash if it exists)
        $mainRef = preg_replace('/\/.*$/', '', $quotation->booking_reference);

        // Find all related accommodations for this hotel across all quotations in the group
        $relatedQuotations = GroupQuotation::where(function ($query) use ($mainRef) {
            $query->where('booking_reference', $mainRef)->orWhere('booking_reference', 'like', $mainRef . '/%');
        })
            ->where('status', 'approved')
            ->get();

        $relatedAccommodations = GroupQuotationAccommodation::whereIn('group_quotation_id', $relatedQuotations->pluck('id'))->where('hotel_id', $hotel->id)->get();

        // Get all members from the group
        $allMembers = [];

        // Get members directly from the group quotation
        $groupMembers = $quotation->members;

        foreach ($groupMembers as $member) {
            if (!isset($allMembers[$member->id])) {
                // Add member to the list - avoid trying to access non-existent quotation relationship
                $allMembers[$member->id] = [
                    'name' => $member->name ?? 'Member #' . $member->id,
                    'country' => $member->country ?? '',
                    'email' => $member->email ?? '',
                    'phone' => $member->phone ?? '',
                    'arrival_date' => $accommodation->start_date->format('Y-m-d'),
                    'departure_date' => $accommodation->end_date->format('Y-m-d'),
                    'remarks' => $member->member_group == 'honeymoon' ? 'HONEYMOONERS' : '',
                ];
            }
        }

        // Calculate total room counts across all related accommodations
        $roomCounts = [
            'single' => 0,
            'double' => 0,
            'twin' => 0,
            'triple' => 0,
            'guide' => 0,
        ];

        $adults = 0;
        $children = 0;

        // Get the latest amendment for this hotel voucher
        $latestAmendment = HotelVoucherAmendment::where('group_quotation_id', $quotation->id)->where('hotel_id', $hotel->id)->latest()->first();

        // If we have a previous amendment, use its values for room counts and additional info
        if ($latestAmendment) {
            // Use room counts from amendment
            $roomCounts = $latestAmendment->room_counts;
            $adults = $latestAmendment->adults;
            $children = $latestAmendment->children;

            // Get additional information from amendment
            $specialNotes = $latestAmendment->special_notes;
            $billingInstructions = $latestAmendment->billing_instructions;
            $remarks = $latestAmendment->remarks;
            $reservationNote = $latestAmendment->reservation_note;
            $contactPerson = $latestAmendment->contact_person;
            $mealPlan = $latestAmendment->meal_plan;

            // Get daily rooms and rooming list if they exist
            $dailyRooms = $latestAmendment->daily_rooms ?? [];
            $roomingList = $latestAmendment->rooming_list ?? [];

            // Calculate next amendment number
            $amendmentNumber = $latestAmendment->amendment_number + 1;
        } else {
            // Calculate from accommodations if no amendment exists
            foreach ($relatedAccommodations as $relatedAccommodation) {
                $roomCounts['single'] += $relatedAccommodation->single_rooms ?? 0;
                $roomCounts['double'] += $relatedAccommodation->double_rooms ?? 0;
                $roomCounts['twin'] += $relatedAccommodation->twin_rooms ?? 0;
                $roomCounts['triple'] += $relatedAccommodation->triple_rooms ?? 0;
                $roomCounts['guide'] += $relatedAccommodation->guide_rooms ?? 0;

                $adults += $relatedAccommodation->adults ?? 0;
                $children += $relatedAccommodation->children ?? 0;
            }

            $mealPlan = $accommodation->mealPlan ? $accommodation->mealPlan->name : 'BB';

            // Create rooming list from group members if available
            $roomingList = [];
            if (count($allMembers) > 0) {
                foreach ($allMembers as $member) {
                    $roomingList[] = [
                        'guest_name' => $member['name'],
                        'arrival_date' => $member['arrival_date'],
                        'departure_date' => $member['departure_date'],
                        'remarks' => $member['remarks'],
                    ];
                }
            }

            // Create daily room details from related accommodations
            $dailyRooms = [];
            foreach ($relatedAccommodations as $acc) {
                // Only add if we have valid dates
                if ($acc->start_date) {
                    $dailyRooms[] = [
                        'date' => $acc->start_date->format('Y-m-d'),
                        'single' => $acc->single_rooms ?? 0,
                        'double' => $acc->double_rooms ?? 0,
                        'twin' => $acc->twin_rooms ?? 0,
                        'triple' => $acc->triple_rooms ?? 0,
                        'pax' => ($acc->adults ?? 0) + ($acc->children ?? 0),
                        'meal_plan' => $acc->mealPlan ? $acc->mealPlan->name : 'HB',
                        'guide_room' => $acc->guide_rooms > 0 ? '01 - HB' : '',
                    ];
                }
            }
        }

        // Get meal plan and room category from the first accommodation
        $roomCategory = $accommodation->roomCategory ? $accommodation->roomCategory->name : 'N/A';

        // Get all members for the member selection dropdown
        $availableMembers = $quotation->members;

        return view('pages.allquotes.hotel_voucher.edit_hotel_voucher2', compact('quotation', 'accommodation', 'hotel', 'roomCounts', 'adults', 'children', 'mealPlan', 'roomCategory', 'relatedAccommodations', 'specialNotes', 'billingInstructions', 'remarks', 'reservationNote', 'contactPerson', 'amendmentNumber', 'dailyRooms', 'roomingList', 'availableMembers'));
    }

    public function storeAmendment2(Request $request, $quotation, $hotel)
    {
        // Find the models from IDs
        $quotation = GroupQuotation::findOrFail($quotation);
        $hotel = Hotel::findOrFail($hotel);

        $validatedData = $request->validate([
            'booking_name' => 'required|string|max:255',
            'voucher_date' => 'required|date',
            'hotel_address' => 'nullable|string',
            'arrival_date' => 'required|date',
            'departure_date' => 'required|date|after:arrival_date',
            'total_nights' => 'required|integer|min:1',
            'meal_plan' => 'required|string',
            'room_counts' => 'required|array',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'special_notes' => 'nullable|string',
            'billing_instructions' => 'nullable|string',
            'remarks' => 'nullable|string',
            'reservation_note' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'daily_rooms' => 'nullable|array',
            'rooming_list' => 'nullable|array',
        ]);

        // Create hotel voucher amendment record
        $voucher = HotelVoucherAmendment::updateOrCreate([
            'group_quotation_id' => $quotation->id,
            'hotel_id' => $hotel->id,
            'booking_name' => $validatedData['booking_name'],
            'voucher_date' => $validatedData['voucher_date'],
            'hotel_address' => $validatedData['hotel_address'],
            'arrival_date' => $validatedData['arrival_date'],
            'departure_date' => $validatedData['departure_date'],
            'total_nights' => $validatedData['total_nights'],
            'room_category' => $request->input('room_category'),
            'meal_plan' => $validatedData['meal_plan'],
            'room_counts' => $validatedData['room_counts'],
            'adults' => $validatedData['adults'],
            'children' => $validatedData['children'] ?? 0,
            'special_notes' => $validatedData['special_notes'],
            'billing_instructions' => $validatedData['billing_instructions'],
            'remarks' => $validatedData['remarks'],
            'reservation_note' => $validatedData['reservation_note'],
            'contact_person' => $validatedData['contact_person'],
            'daily_rooms' => $request->input('daily_rooms') ?? [],
            'rooming_list' => $request->input('rooming_list') ?? [],
            'is_amendment' => true,
            'amendment_number' => 2,
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Hotel voucher amendment created successfully!');
    }

    

    public function downloadHotelVoucherPDF2(Request $request, $quotationId, $hotelId)
    {
        // Find the models from IDs
        $quotation = GroupQuotation::findOrFail($quotationId);
        $hotel = Hotel::findOrFail($hotelId);

        // Find the latest amendment for this hotel and quotation
        $amendment = HotelVoucherAmendment::where('group_quotation_id', $quotation->id)->where('hotel_id', $hotel->id)->latest()->firstOrFail();

        // Generate PDF
        $pdf = PDF::loadView('pages.allquotes.pdf.hotel_voucher_pdf_amendment2', [
            'amendment' => $amendment,
            'quotation' => $quotation,
            'hotel' => $hotel,
            'arrivalDate' => \Carbon\Carbon::parse($amendment->arrival_date),
            'departureDate' => \Carbon\Carbon::parse($amendment->departure_date),
            'totalNights' => $amendment->total_nights,
            'roomCounts' => $amendment->room_counts,
            'dailyRooms' => $amendment->daily_rooms ?? [],
            'roomingList' => $amendment->rooming_list ?? [],
            'amendmentNumber' => $amendment->amendment_number,
        ]);

        // Download the PDF
        return $pdf->download('hotel_voucher_amendment2_' . $hotel->name . '_' . now()->format('Y-m-d') . '.pdf');
    }
}
