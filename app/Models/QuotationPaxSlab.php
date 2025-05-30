<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationPaxSlab extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'pax_slab_id', // Ensure this column exists
        'vehicle_type_id',
        'exact_pax',
        'vehicle_payout_rate',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
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
