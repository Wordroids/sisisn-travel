<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPlanGroup extends Model
{
    use HasFactory;

    protected $table = 'tour_plans';

    protected $fillable = [
        'group_quotation_id',
        'tour_notes',
        'important_notes',
        'guests',
        'detailed_guests',
        'itinerary_days',
        'created_by',
    ];

    protected $casts = [
        'guests' => 'array',
        'detailed_guests' => 'array',
        'itinerary_days' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the group quotation for this tour plan.
     */
    public function groupQuotation()
    {
        return $this->belongsTo(GroupQuotation::class, 'group_quotation_id', 'booking_reference');
    }
}
