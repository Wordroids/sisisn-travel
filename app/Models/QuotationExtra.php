<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationExtra extends Model
{
    use HasFactory;

    protected $table = 'quotation_extras';

    protected $fillable = [
        'quotation_id',
        'date',
        'description',
        'unit_price',
        'quantity_per_pax',
        'total_price',
    ];

    protected $casts = [
        'date' => 'date',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    // Relationship with Quotation
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}