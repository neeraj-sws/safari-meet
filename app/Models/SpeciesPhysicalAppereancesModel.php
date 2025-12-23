<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SpeciesPhysicalAppereancesModel extends Model
{
    use HasFactory;

    protected $table = "species_physical_appereances";
    protected $primaryKey = "species_physical_appereances_id";

    protected $fillable = [
        'species_id',
        'species_details_characterstics_id',
        'adaptation_description',
        'appearance_description',
        'trait',
    ];


    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_physical_appereances_id;
    }
}
