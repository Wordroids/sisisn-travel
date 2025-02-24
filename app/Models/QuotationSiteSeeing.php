<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationSiteSeeing extends Model
{
    use HasFactory;

    protected $table = 'quotation_site_seeings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quotation_id',
        'name',
        'type',
        'description',
        'unit_price',
        'quantity',
        'price_per_adult'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'unit_price' => 'decimal:2',
        'price_per_adult' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the quotation that owns the site seeing.
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}