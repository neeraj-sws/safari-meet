<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ParkSafariTime extends Model
{
    use HasFactory;

    protected $table = "park_safari_time";

    protected $primaryKey = 'park_safari_time_id';

    protected $fillable = [
        'park_id',
        'weather_id',
        'start',
        'end',
    ];

    public function details()
    {
        return $this->hasMany(ParkSafariTimeDetail::class, 'park_safari_time_id');
    }

    public function weather(){
        return $this->belongsTo(WeatherModel::class,'weather_id');
    }

     // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_safari_time_id;
    }
}
