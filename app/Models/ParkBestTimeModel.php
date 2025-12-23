<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ParkBestTimeModel extends Model
{


    protected $table = "park_best_time";
    protected $primaryKey = "park_best_time_id";
    protected $fillable = [
        'park_id',
        'weathers_id',
    ];

    public function weather()
    {
        return $this->belongsTo(WeatherModel::class, 'weathers_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_best_time_id;
    }
}
