<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpeciesFamilyModel extends Model
{
    protected $table = "species_families";
    protected $primaryKey = "species_family_id";
    protected $fillable = ['name', 'category_id', 'status'];

    public function category()
    {
        return $this->belongsTo(SpeciesCategory::class, 'category_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_family_id;
    }
}
