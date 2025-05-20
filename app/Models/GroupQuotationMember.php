<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupQuotationMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_quotations_id',
        'name',
        'email',
        'phone',
        'whatsapp',
        'country',
    ];

    /**
     * Get the group quotation that owns the member.
     */
    public function groupQuotation()
    {
        return $this->belongsTo(GroupQuotation::class, 'group_quotations_id');
    }

    public function members()
{
    return $this->hasMany(GroupQuotationMember::class, 'group_quotations_id');
}
}