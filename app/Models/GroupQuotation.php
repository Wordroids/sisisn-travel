<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quote_reference',
        'booking_reference',
        'market_id',
        'customer_id',
        'start_date',
        'end_date',
        'duration',
        'currency',
        'conversion_rate',
        'markup_per_person',
        'status',
        'pax_slab_id',
        'driver_id',
        'guide_id',
        'description',
        'is_template',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'conversion_rate' => 'decimal:4',
        'markup_per_person' => 'decimal:2',
        'is_template' => 'boolean',
    ];

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function paxSlab()
    {
        return $this->belongsTo(PaxSlab::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    public function accommodations()
    {
        return $this->hasMany(GroupQuotationAccommodation::class);
    }

    public function travelPlans()
    {
        return $this->hasMany(GroupQuotationTravelPlan::class);
    }

    public function siteSeeings()
    {
        return $this->hasMany(GroupQuotationSiteSeeing::class);
    }

    public function extras()
    {
        return $this->hasMany(GroupQuotationExtra::class);
    }

    public function jeepCharges()
    {
        return $this->hasMany(GroupQuotationJeepCharge::class);
    }

    public function paxSlabs()
    {
        return $this->hasMany(GroupQuotationPaxSlab::class);
    }

    public function quotations()
    {
        return $this->belongsToMany(Quotation::class, 'group_quotation_members');
    }

    public function members()
    {
        return $this->hasMany(GroupQuotationMember::class, 'group_quotations_id');
    }
}