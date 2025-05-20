<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuotationJeepCharge extends Model
{
    use HasFactory;
    
    protected $table = 'group_quotation_jeep_charges';

    protected $fillable = [
        'group_quotation_id',
        'travel_plan_id',
        'pax_range',
        'unit_price',
        'quantity',
        'total_price',
        'per_person',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'per_person' => 'decimal:2',
    ];

    public function groupQuotation()
    {
        return $this->belongsTo(GroupQuotation::class);
    }

    public function travelPlan()
    {
        return $this->belongsTo(GroupQuotationTravelPlan::class, 'travel_plan_id');
    }
}