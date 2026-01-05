<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpeciesCategory extends Model
{
    protected $table = "species_categories";
    protected $primaryKey = 'species_category_id';
    protected $fillable = ['name', 'status'];

     // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_category_id;
    }
}

