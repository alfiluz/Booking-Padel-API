<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $fillable = [
        'field_id',
        'user_id',
        'date',
        'quantity',
        'total_price'
    ];

}
