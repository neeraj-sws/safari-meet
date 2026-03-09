<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConservationModel extends Model
{
    protected $table = "conservation";
<<<<<<< HEAD

    protected $primaryKey = 'conservation_id';
=======
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    protected $fillable = ['name', 'status', 'species_id'];

    public function details()
    {
        return $this->hasMany(ConservationDetailsModel::class, 'conservation_id');
    }
}
