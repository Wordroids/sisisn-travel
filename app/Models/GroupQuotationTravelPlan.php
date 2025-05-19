<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuotationTravelPlan extends Model
{
    use HasFactory;
    
    protected $table = 'group_quotation_travel_plans';

    protected $fillable = [
        'group_quotation_id',
        'start_date',
        'end_date',
        'route_id',
        'vehicle_type_id',
        'mileage',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'mileage' => 'decimal:2',
    ];

    public function groupQuotation()
    {
        return $this->belongsTo(GroupQuotation::class);
    }

    public function route()
    {
        return $this->belongsTo(TravelRoute::class);
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function jeepCharges()
    {
        return $this->hasMany(GroupQuotationJeepCharge::class, 'travel_plan_id');
    }
}