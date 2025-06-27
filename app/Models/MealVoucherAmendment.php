<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealVoucherAmendment extends Model
{
    use HasFactory;

    protected $table = 'meal_voucher_amendments';

    protected $fillable = [
        'group_quotation_id',
        'voucher_date',
        'hotel_id',
        'hotel_name',
        'hotel_address',
        'market',
        'meal_plan',
        'selected_tours_data',
        'special_notes',
        'billing_instructions',
        'remarks',
        'reservation_note',
        'contact_person',
        
    ];

    protected $casts = [
        'voucher_date' => 'date',
    ];

    public function groupQuotation()
    {
        return $this->belongsTo(GroupQuotation::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    
    /**
     * Get the selected tours data as an array.
     */
    public function getSelectedToursAttribute()
    {
        if (!$this->selected_tours_data) {
            return [];
        }
        
        return json_decode($this->selected_tours_data, true);
    }
    
}