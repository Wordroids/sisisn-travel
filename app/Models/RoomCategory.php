<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    /** @use HasFactory<\Database\Factories\RoomCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
}
