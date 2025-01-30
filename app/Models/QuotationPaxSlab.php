<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationPaxSlab extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'exact_pax',
        'vehicle_type',
        'vehicle_payout_rate',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
