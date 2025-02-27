<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempBookRef extends Model
{
    protected $table = 'temp_save_refno';

    protected $fillable = ['quote_reference','booking_reference'];

}
