<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafariType extends Model
{
    protected $table = "safari_types";
    protected $primaryKey = "safari_type_id";
    protected $fillable = [
        'name',
        'status',
    ];

    public function safariTypes()
    {
        return $this->hasMany(ParkSafariType::class);
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_type_id;
    }
}
