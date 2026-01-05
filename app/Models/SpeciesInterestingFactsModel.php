<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SpeciesInterestingFactsModel extends Model
{
    use HasFactory;

    protected $table = "species_interesting_facts";

    protected $primaryKey = "species_interesting_fact_id";

    protected $fillable = [
        'species_id',
        'species_details_characterstics_id',
        'short_description',
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_interesting_fact_id;
    }
}
