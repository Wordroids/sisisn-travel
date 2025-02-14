<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assets;

class TravelRoute extends Model
{
    /** @use HasFactory<\Database\Factories\TravelRouteFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'mileage', // New mileage field
    ];

    public function assets()
    {
        return $this->morphMany(Assets::class, 'assetable');
    }
}
