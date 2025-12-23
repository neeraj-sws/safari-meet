<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ParkSafariTimeDetail extends Model
{
    use HasFactory;

    protected $table = "park_safari_time_details";

    protected $primaryKey = 'park_safari_time_details_id';

    protected $fillable = [
        'park_safari_time_id',
        'month',
        'slot_type',
        'start_time',
        'end_time',
    ];

    public function parktiming()
    {
        return $this->belongsTo(ParkSafariTime::class, 'park_safari_time_id');
    }

     // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_safari_time_details_id;
    }
}
