<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitat extends Model
{
    protected $table = "habitats";
    protected $fillable = ['name', 'status', 'species_id'];

    public function details()
    {
        return $this->hasMany(HabitatDetailsModel::class, 'habitat_id');
    }
}
