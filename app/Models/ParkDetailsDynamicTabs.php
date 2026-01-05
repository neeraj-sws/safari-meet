<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ParkDetailsDynamicTabs extends Model
{
    use HasFactory;

    protected $table = "park_details_dynamic_tabs";

    protected $fillable = [
        'park_id',
        'park_details_characterstics_id',
        'short_description',
        'key',
    ];
}
