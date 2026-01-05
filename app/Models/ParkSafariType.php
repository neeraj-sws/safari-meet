<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkSafariType extends Model
{
    protected $table = "park_safari_type";
    protected $primaryKey = "park_safari_type_id";
    protected $fillable = [
        'park_id',
        'safari_type_id',
    ];

    public function safari_type()
    {
        return $this->belongsTo(SafariType::class, 'safari_type_id');
    }

        // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_safari_type_id;
    }
}
