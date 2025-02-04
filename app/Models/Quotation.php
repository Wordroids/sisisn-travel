<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    /** @use HasFactory<\Database\Factories\QuotationFactory> */
    use HasFactory;

    protected $fillable = [
        'quote_reference',       // Auto-generated (QT/SP/1001)
        'booking_reference',     // Temporary reference (ST/SP/1001)
        'market_id',             // Market selection
        'customer_id',           // Customer selection
        'start_date',            // Tour start date
        'end_date',              // Tour end date
        'duration',              // Auto-calculated from date range
        'currency',              // Default: USD
        'conversion_rate',       // Auto-filled based on selected currency
        'markup_per_person',     // System-defined markup per person
        'status',                // ['draft', 'pending', 'approved', 'rejected']
        'pax_slab_id',           // Links to selected Pax Slab
    ];

    // ✅ Relationship with Market
    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    // ✅ Relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }
}
