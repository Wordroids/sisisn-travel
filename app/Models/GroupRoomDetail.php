<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupRoomDetail extends Model
{
    use HasFactory;
    
    protected $table = 'group_room_details';

    protected $fillable = [
        'group_quotation_accommodation_id',
        'room_type',
        'per_night_cost',
        'nights',
        'total_cost'
    ];

    protected $casts = [
        'per_night_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function accommodation()
    {
        return $this->belongsTo(GroupQuotationAccommodation::class, 'group_quotation_accommodation_id');
    }
}