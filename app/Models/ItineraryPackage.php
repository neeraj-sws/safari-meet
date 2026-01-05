<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItineraryPackage extends Model
{
    protected $table = "safari_itineraries";
    protected $primaryKey = 'safari_itineraries_id';
    protected $fillable = [
        'package_id',
        'share_safari_id',
        'short_description',
        'order_by',
    ];

    public function packageActivities()
    {
        return $this->hasMany(ItineraryPackageActivity::class, 'itinerary_packages_id','safari_itineraries_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_itineraries_id;
    }
}
