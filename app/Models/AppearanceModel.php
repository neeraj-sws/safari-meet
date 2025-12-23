<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AppearanceModel extends Model
{
    use HasFactory;

    protected $table = "appearance";

    protected $fillable = [
        'species_id',
        'title',
        'short_distription',
    ];


}
