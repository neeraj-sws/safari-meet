<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafariAllottedSeat extends Model
{
    protected $table = "safari_allotted_seats";
    protected $primaryKey = 'safari_allotted_seat_id';
    protected $fillable = ['shared_safari_id', 'user_id', 'number_of_seat'];


    public function allottedUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_allotted_seat_id;
    }
}
