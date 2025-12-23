<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ParkTraveltipsModel extends Model
{
    protected $table = "park_travel_tips";
    protected $primaryKey = 'park_travel_tips_id';
    protected $fillable = [
        'park_id',
        'best_time_visit',
        'weather',
        'whatToCarry',
        'safetyTips',
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_travel_tips_id;
    }
}
