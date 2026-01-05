<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ParkZoneModel extends Model
{
    protected $table = "park_zone";

    protected $primaryKey = "park_zone_id";
    protected $fillable = [
        'park_id',
        'type',
        'zone_name',
        'entry_gate',
    ];
     // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_zone_id;
    }
}
