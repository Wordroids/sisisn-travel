<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuotationAccommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_quotation_id',
        'hotel_id',
        'start_date',
        'end_date',
        'nights',
        'meal_plan_id',
        'room_category_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function groupQuotation()
    {
        return $this->belongsTo(GroupQuotation::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class);
    }

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class);
    }

    public function roomDetails()
    {
        return $this->hasMany(GroupRoomDetail::class, 'group_quotation_accommodation_id');
    }
    
    public function additionalRooms()
    {
        return $this->hasMany(GroupAdditionalRoom::class, 'group_quotation_accommodation_id');
    }
}