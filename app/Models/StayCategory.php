<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StayCategory extends Model
{
    protected $primaryKey = "stay_category_id";
    protected $fillable = ['name', 'description'];

      // ID ALIAS
    public function getIdAttribute()
    {
        return $this->stay_category_id;
    }
}
