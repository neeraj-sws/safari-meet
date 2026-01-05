<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $table = "states";

    protected $primaryKey = 'state_id';

    protected $fillable = ['name', 'country_id'];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->state_id;
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }

    public function parkState()
    {
        return $this->hasOne(Park::class, 'state_id', 'state_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'state_id', 'state_id');
    }
}
