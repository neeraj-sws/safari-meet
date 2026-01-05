<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $table = "cities";

    protected $primaryKey = 'city_id';

    protected $fillable = ['name', 'state_id'];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->city_id;
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }
}
