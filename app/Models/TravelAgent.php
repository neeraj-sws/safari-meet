<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class TravelAgent extends Authenticatable
{

    use HasFactory, Notifiable, HasApiTokens;

    protected $table = "travel_agents";
    protected $primaryKey = 'travel_agents_id';
    protected $fillable = ['name', 'email', 'phone_number', 'password', 'status'];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->travel_agents_id;
    }
}
