<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AdaptationModel extends Model
{
    use HasFactory;

    protected $table = "species_adaptations";

    protected $primaryKey = "species_adaptations_id";

    protected $fillable = [
        'species_id',
        'title',
        'short_description',
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_adaptations_id;
    }
}
