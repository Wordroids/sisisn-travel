<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationTemplate extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'template_name',
        'quote_reference',
        'booking_reference',
        'description',
        'is_active',
        'created_by',
        'accommodations',
        'travel_plans',
        'site_seeings',
        'site_extras',
        'extras'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'accommodations' => 'array',
        'travel_plans' => 'array',
        'site_seeings' => 'array',
        'site_extras' => 'array',
        'extras' => 'array',
        'is_active' => 'boolean'
    ];
    
    /**
     * Get the user who created the template.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Scope a query to only include active templates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function quotations()
    {
        return $this->hasMany(GroupQuotation::class, 'template_id');
    }
}
