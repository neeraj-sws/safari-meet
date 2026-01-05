<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitatDetailsModel extends Model
{
    protected $table = "habitat_details";
    protected $fillable = ['habitat_id', 'title','short_description'];

    public function habitat()
{
    return $this->belongsTo(Habitat::class, 'habitat_id');
}

}
