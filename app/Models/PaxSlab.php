<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaxSlab extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'min_pax',
        'max_pax',
        'order'
    ];


    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
