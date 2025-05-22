<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTempSaveRefno extends Model
{
    //
    protected $table = 'group_temp_save_refno';
    
    protected $fillable = ['quote_reference','booking_reference'];

}
