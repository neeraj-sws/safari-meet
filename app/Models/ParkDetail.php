<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkDetail extends Model
{
    protected $table = "park_details";
    protected $fillable = [
        'park_id',
        'core_zone',
        'buffer_zone',
        'entry_gates',
        'morning_time',
        'afternoon_time',
        'nearest_railway',
    ];
}
