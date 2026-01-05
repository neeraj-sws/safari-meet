<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ParkBestTimeVistModel extends Model
{
    protected $table = "park_best_time_visit";
    protected $primaryKey = 'park_best_time_visit_id';
    protected $fillable = [
        'park_id',
        'heading',
        'description',
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_best_time_visit_id;
    }
}
