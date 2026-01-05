<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SpeciesLifestyleModel extends Model
{
    use HasFactory;

    protected $table = "species_lifestyle";

    protected $primaryKey = "species_lifestyle_id";

    protected $fillable = [
        'species_id',
        'species_details_characterstics_id',
        'diet_short_description',
        'habitatt_short_description',
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_lifestyle_id;
    }
}
