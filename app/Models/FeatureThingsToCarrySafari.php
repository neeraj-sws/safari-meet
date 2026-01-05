<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureThingsToCarrySafari extends Model
{
    protected $table = "safari_things_to_carries";

    protected $primaryKey = 'safari_things_to_carries_id';

    protected $fillable = [
        'package_id',
        'share_safari_id',
        'title',
        'description',
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_things_to_carries_id;
    }
}
