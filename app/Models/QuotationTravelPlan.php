<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationTravelPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'start_date',
        'end_date',
        'route_id',
        'vehicle_type_id',
        'mileage',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function route()
    {
        return $this->belongsTo(TravelRoute::class);
    }

    public function vehicleType()
    {
        return $this->belongsTo(vehicleType::class);
    }
}
