<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $table = "countries";

    protected $primaryKey = 'country_id';

    protected $fillable = ['sortname', 'name', 'phonecode'];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->country_id;
    }
}
