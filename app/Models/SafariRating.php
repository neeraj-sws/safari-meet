<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafariRating extends Model
{
    protected $table = "safari_ratings";
    protected $primaryKey = 'safari_ratings_id';
    protected $fillable = ['package_id', 'share_safari_id', 'safari_type_id', 'safari_rating_heading_id', 'price'];

    public function heading()
    {
        return $this->belongsTo(SafariRatingHeading::class, 'safari_rating_heading_id','safari_rating_heading_id');
    }

    public function safariType()
    {
        return $this->belongsTo(ParkSafariType::class, 'safari_type_id','park_safari_type_id');
    }
    public function parkSafariTypes()
    {
        return $this->belongsTo(ParkSafariType::class, 'safari_type_id','park_safari_type_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_ratings_id;
    }
}
