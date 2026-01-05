<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkReachabilityDistance extends Model
{
    protected $table = "park_reachabilities_distance";
    protected $primaryKey = 'park_reachabilities_distance_id';
    protected $fillable = ['park_id', 'city_id', 'reachability_id', 'heading', 'distance'];

    public function cityData()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }
    public function reachability()
    {
        return $this->belongsTo(ParkReachability::class, 'reachability_id', 'park_reachability_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_reachabilities_distance_id;
    }
}
