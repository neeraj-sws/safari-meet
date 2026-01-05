<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FactsModel extends Model
{
    use HasFactory;

    protected $table = "facts";

    protected $fillable = [
        'species_id',
        'title',
        'short_description',
    ];


}
