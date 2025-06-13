<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelVoucherAmendment extends Model
{
    //
    protected $table = 'hotel_voucher_amendments';
    
    protected $fillable = [
        'group_quotation_id', 
        'hotel_id',
        'booking_name',
        'voucher_date',
        'arrival_date',
        'departure_date',
        'total_nights',
        'hotel_address',
        'room_category',
        'meal_plan',
        'adults',
        'children',
        'room_counts',
        'special_notes',
        'billing_instructions',
        'remarks',
        'reservation_note',
        'contact_person',
        'daily_rooms',
        'rooming_list',
        'is_amendment',
        'amendment_number',
    ];

    protected $casts = [
        'voucher_date' => 'date',
        'arrival_date' => 'date',
        'departure_date' => 'date',
         'room_counts' => 'array',
        'daily_rooms' => 'array',
        'rooming_list' => 'array',
        'is_amendment' => 'boolean',
    ];

    public function groupQuotation()
    {
        return $this->belongsTo(GroupQuotation::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
