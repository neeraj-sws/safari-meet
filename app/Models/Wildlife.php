<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wildlife extends Model
{
     use HasFactory;

    protected $fillable = [
        'name', 'species_id', 'habitat_id', 'description'
    ];

    public function species(){
        return $this->belongsTo(Species::class);
    }
    public function habitat(){
        return $this->belongsTo(Habitat::class);
    }
}
