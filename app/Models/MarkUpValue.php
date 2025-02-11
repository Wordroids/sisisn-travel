<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkUpValue extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mark_up';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'amount'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2'
    ];
}