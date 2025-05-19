<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuotationSiteSeeing extends Model
{
    use HasFactory;
    
    protected $table = 'group_quotation_site_seeings';

    protected $fillable = [
        'group_quotation_id',
        'name',
        'type',
        'description',
        'unit_price',
        'quantity',
        'price_per_adult'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'price_per_adult' => 'decimal:2',
    ];

    public function groupQuotation()
    {
        return $this->belongsTo(GroupQuotation::class);
    }
}