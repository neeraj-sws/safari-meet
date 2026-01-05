<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ParkTabs extends Model
{
    use HasFactory;

    protected $table = "park_tabs";

    protected $primaryKey = "park_tabs_id";

    protected $fillable = [
        'title',
        'status'
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_tabs_id;
    }
}
