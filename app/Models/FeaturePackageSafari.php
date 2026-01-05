<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturePackageSafari extends Model
{

    protected $table = "safari_inclusion_exclusions";

    protected $primaryKey = 'safari_inclusion_exclusions_id';
    protected $fillable = [
        'package_id',
        'share_safari_id',
        'type',
        'icon',
        'title',
        'feature_id',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'package_id');
    }
    public function shareSafari()
    {
        return $this->belongsTo(ShareSafari::class, 'share_safari_id', 'shared_safari_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_inclusion_exclusions_id;
    }
}
