<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SpeciesDetailsDynamicTabs extends Model
{
    use HasFactory;

    protected $table = "species_details_dynamic_tabs";
    protected $primaryKey = "species_details_dynamic_tab_id";
    protected $fillable = [
        'species_id',
        'species_details_characterstics_id',
        'short_description',
        'key',
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_details_dynamic_tab_id;
    }
}
