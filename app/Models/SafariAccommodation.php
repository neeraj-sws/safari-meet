<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafariAccommodation extends Model
{
    protected $table = "safari_accommodations";
    protected $primaryKey = 'safari_accommodations_id';
    protected $fillable = ['package_id', 'accommodation_id'];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'accommodation_id', 'accommodation_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_accommodations_id;
    }
}
