<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ParkDetailsTabs extends Model
{
    use HasFactory;

    protected $table = "park_details_tabs";

    protected $primaryKey = "park_details_tabs_id";

    protected $fillable = [
        'park_tabs_id',
        'park_id',
        'title',
        'status'
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_details_tabs_id;
    }
}
