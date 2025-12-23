<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SpeciesDetailsCharactersticModel extends Model
{
    use HasFactory;

    protected $table ="species_details_characterstics";
    protected $primaryKey = 'species_details_characterstic_id';

    protected $fillable = [
        'species_details_characterstic_id',
        'species_characterstics',
        'species_id',
        'title',
        'status'
    ];

     // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_details_characterstic_id;
    }
}
