<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $primaryKey = 'features_id';
    protected $fillable = [
        'type',
        'icon',
        'title',
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->features_id;
    }
}
