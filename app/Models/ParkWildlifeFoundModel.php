<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ParkWildlifeFoundModel extends Model
{


    protected $table = "park_wildlife_found";
    protected $primaryKey = "park_wildlife_found_id";
    protected $fillable = [
        'park_id',
        'species_id',
    ];

    public function species()
    {
        return $this->belongsTo(Species::class, 'species_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_wildlife_found_id;
    }
}
