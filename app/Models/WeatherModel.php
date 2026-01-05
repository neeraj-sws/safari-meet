<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class WeatherModel extends Model
{
    use HasFactory;

    protected $table = "park_weathers";
    protected $primaryKey = "park_weather_id";
    protected $fillable = [
        'title',
        'status',
        'start',
        'end',
    ];

        // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_weather_id;
    }

}
