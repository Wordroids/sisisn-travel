<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationAccommodationRoomDetails extends Model
{
    //
    protected $table = 'accommodations_room_details';

    protected $fillable = [
        'quotation_accommodation_id',
        'room_type',
        'per_night_cost',
        'nights',
        'total_cost'
    ];

    public function quotationAccommodation()
    {
        return $this->belongsTo(QuotationAccommodation::class);
    }

}
