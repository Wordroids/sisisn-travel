<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationAccommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'hotel_id',
        'start_date',
        'end_date',
        'nights',
        'meal_plan_id',
        'room_category_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
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

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function roomDetails()
    {
        return $this->hasMany(QuotationAccommodationRoomDetails::class);
    }
    
    public function additionalRooms()
    {
        return $this->hasMany(AdditionalRooms::class);
    }
}
