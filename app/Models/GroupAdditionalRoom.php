<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupAdditionalRoom extends Model
{
    use HasFactory;
    
    protected $table = 'group_additional_rooms';

    protected $fillable = [
        'group_quotation_accommodation_id',
        'room_type',
        'per_night_cost',
        'nights',
        'total_cost',
        'provided_by_hotel',
    ];

    protected $casts = [
        'per_night_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'provided_by_hotel' => 'boolean',
    ];

    public function accommodation()
    {
        return $this->belongsTo(GroupQuotationAccommodation::class, 'group_quotation_accommodation_id');
    }
}