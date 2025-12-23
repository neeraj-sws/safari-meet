<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ThreatModel extends Model
{
    use HasFactory;

    protected $table = "threat_details";

    protected $fillable = [
        'species_id',
        'title',
        'short_distription',
    ];


}
