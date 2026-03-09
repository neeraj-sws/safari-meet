<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConservationDetailsModel extends Model
{
    protected $table = "conservation_details";
    protected $primaryKey = 'conservation_detail_id';
    protected $fillable = ['conservation_id', 'title','short_description'];

    public function habitat()
{
    return $this->belongsTo(ConservationModel::class, 'conservation_id');
}

}
