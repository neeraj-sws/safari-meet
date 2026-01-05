<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SpeciesCharacterstic extends Model
{
    use HasFactory;

    protected $table = "species_characterstics";
    protected $primaryKey = 'species_characterstic_id';
    protected $fillable = [
        'species_characterstic_id',
        'title',
        'status'
    ];


    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_characterstic_id;
    }
}
