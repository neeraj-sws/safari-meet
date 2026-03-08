<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConservationModel extends Model
{
    protected $table = "conservation";
    protected $primaryKey = 'conservation_id';
    protected $fillable = ['name', 'status', 'species_id'];

    public function details()
    {
        return $this->hasMany(ConservationDetailsModel::class, 'conservation_id');
    }
}
