<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Amenity extends Model
{
    use HasFactory;

    protected $primaryKey = "amenity_id";
    protected $fillable = [
        'title',
        'icon'
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->amenity_id;
    }
}
