<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafariRatingHeading extends Model
{
    protected $table = "safari_rating_heading";
    protected $primaryKey = 'safari_rating_heading_id';
    protected $fillable = ['package_id', 'share_safari_id', 'heading_label'];

    public function ratings()
    {
        return $this->hasMany(SafariRating::class, 'safari_rating_heading_id', 'safari_rating_heading_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_rating_heading_id;
    }
}
