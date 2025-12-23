<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationAmenity extends Model
{
    protected $table = 'accommodation_amenities';
    protected $primaryKey = "accommodation_amenity_id";
    protected $fillable = ['accommodation_id', 'amenity_id'];

    public function amenity()
    {
        return $this->belongsTo(Amenity::class, 'amenity_id', 'amenity_id');
    }

      // ID ALIAS
    public function getIdAttribute()
    {
        return $this->accommodation_amenity_id;
    }
}
