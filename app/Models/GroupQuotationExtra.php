<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuotationExtra extends Model
{
    use HasFactory;
    
    protected $table = 'group_quotation_extras';

    protected $fillable = [
        'group_quotation_id',
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

    public function groupQuotation()
    {
        return $this->belongsTo(GroupQuotation::class);
    }
}