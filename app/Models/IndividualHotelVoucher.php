<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualHotelVoucher extends Model
{
    use HasFactory;

    protected $table = 'individual_hotel_vouchers';

    protected $fillable = [
        'quotation_id',
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
        'is_amendment',
        'amendment_number',
    ];

    protected $casts = [
        'voucher_date' => 'datetime',
        'arrival_date' => 'datetime',
        'departure_date' => 'datetime',
        'is_amendment' => 'boolean',
    ];

    // Relationship with the quotation
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    // Relationship with the hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}