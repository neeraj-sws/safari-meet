<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FactsModel extends Model
{
    use HasFactory;

    protected $table = "facts";

<<<<<<< HEAD
    protected $primaryKey = 'fact_id';

=======
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    protected $fillable = [
        'species_id',
        'title',
        'short_description',
    ];


}
