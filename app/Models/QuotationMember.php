<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotations_id',
        'name',
        'email',
        'phone',
        'whatsapp',
        'country',
    ];

    /**
     * Get the quotation that owns the member.
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotations_id');
    }
}