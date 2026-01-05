<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryPackageActivity extends Model
{
    protected $table = "safari_itinerary_activities";
    protected $primaryKey = 'safari_itinerary_activities_id';
    protected $fillable = [
        'itinerary_packages_id',
        'activity',
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_itinerary_activities_id;
    }
}
