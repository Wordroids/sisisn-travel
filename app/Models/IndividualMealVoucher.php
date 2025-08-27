<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualMealVoucher extends Model
{
    //


    use HasFactory;

    protected $table = 'individual_meal_vouchers';

    protected $fillable = [
        'quotation_id',
        'voucher_date',
        'hotel_id',
        'hotel_name',
        'hotel_address',
        'meal_plan',
        'market',
        'special_notes',
        'meal_dates',
        'billing_instructions',
        'remarks',
        'reservation_note',
        'contact_person',
        'is_amendment',
        'amendment_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'voucher_date' => 'datetime',
        'is_amendment' => 'boolean',
    ];

    /**
     * Get the quotation that owns the meal voucher.
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    /**
     * Get the hotel associated with the meal voucher.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
