<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GroupQuotationAccommodation;

class AllocatedGroup extends Model
{
    protected $fillable = ['accommodation_id', 'group_name'];
    
    /**
     * Get the accommodation that this group is allocated to.
     * Explicitly defining the foreign key to avoid confusion.
     */
    public function accommodation()
    {
        return $this->belongsTo(GroupQuotationAccommodation::class, 'accommodation_id');
    }
}

