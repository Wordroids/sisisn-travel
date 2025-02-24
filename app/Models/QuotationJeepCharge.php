<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationJeepCharge extends Model
{
    use HasFactory;

    protected $table = 'quotation_jeep_charges';

    protected $fillable = [
        'quotation_id',
        'pax_range',
        'unit_price',
        'quantity',
        'total_price',
        'per_person',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}