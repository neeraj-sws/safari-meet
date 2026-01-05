<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AdaptationDetailsModel extends Model
{
    use HasFactory;

    protected $table ="adaptations_details";

    protected $fillable = [
        'adaptations_id',
        'title',
        'short_description',
    ];


}
