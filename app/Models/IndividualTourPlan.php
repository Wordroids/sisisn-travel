<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualTourPlan extends Model
{
    use HasFactory;

    protected $table = 'individual_tour_plans';

    protected $fillable = [
        'quotation_id',
        'title',
        'start_date',
        'end_date',
        'duration',
        'tour_notes',
        'important_notes',
        'guests',
        'itinerary_days'
    ];

   protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    'guests' => 'array',
    'itinerary_days' => 'array',
];
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}