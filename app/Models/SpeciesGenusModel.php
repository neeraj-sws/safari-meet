<?php

namespace App\Models;

use App\Livewire\Admin\SpeciesFamily;
use Illuminate\Database\Eloquent\Model;

class SpeciesGenusModel extends Model
{
    protected $table = "species_genus";
    protected $primaryKey = "species_genus_id";
    protected $fillable = ['name', 'category_id', 'species_family_id', 'status'];

    public function species_family()
    {
        return $this->belongsTo(SpeciesFamilyModel::class, 'species_family_id');
    }
    public function species_category()
    {
        return $this->belongsTo(SpeciesCategory::class, 'category_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_genus_id;
    }
}
