<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConservationDetailsModel extends Model
{
    protected $table = "conservation_details";
<<<<<<< HEAD
    protected $primaryKey = 'conservation_detail_id';
=======
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    protected $fillable = ['conservation_id', 'title','short_description'];

    public function habitat()
{
    return $this->belongsTo(ConservationModel::class, 'conservation_id');
}

}
