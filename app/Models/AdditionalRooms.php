<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalRooms extends Model
{
    //
    protected $table = 'additional_rooms';

    protected $fillable = [
        'quotation_accommodation_id',
        'room_type',
        'per_night_cost',
        'nights',
        'total_cost',
        'provided_by_hotel',
    ];

    public function quotationAccommodation()
    {
        return $this->belongsTo(QuotationAccommodation::class);
    }
}
