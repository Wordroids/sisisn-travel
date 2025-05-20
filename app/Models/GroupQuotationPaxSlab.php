<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuotationPaxSlab extends Model
{
    use HasFactory;
    
    protected $table = 'group_quotation_pax_slabs';

    protected $fillable = [
        'group_quotation_id',
        'pax_slab_id',
        'vehicle_type_id',
        'exact_pax',
        'vehicle_payout_rate',
    ];

    protected $casts = [
        'vehicle_payout_rate' => 'decimal:2',
    ];

    public function groupQuotation()
    {
        return $this->belongsTo(GroupQuotation::class);
    }

    public function paxSlab()
    {
        return $this->belongsTo(PaxSlab::class);
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }
}