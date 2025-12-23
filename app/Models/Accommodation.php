<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $table = "accommodations";

    protected $primaryKey = "accommodation_id";

    protected $fillable = ['title', 'category_id', 'rating', 'country_id', 'state_id', 'city_id'];

    public function amenity()
    {
        return $this->hasMany(AccommodationAmenity::class,'accommodation_id', 'accommodation_id');
    }
    public function image()
    {
        return $this->hasMany(AccommodationImage::class, 'accommodation_id', 'accommodation_id');
    }
    public function category()
    {
        return $this->belongsTo(StayCategory::class, 'category_id', 'stay_category_id');
    }
    public function cuntry()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->accommodation_id;
    }
}
