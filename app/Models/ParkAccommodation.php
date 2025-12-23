<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkAccommodation extends Model
{
    protected $table = "park_accommodations";
    protected $primaryKey = 'park_accommodations_id';
    protected $fillable = ['park_id', 'accommodation_id'];


    public function accommodationList()
    {
        return $this->belongsTo(Accommodation::class, 'accommodation_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_accommodations_id;
    }
}
