<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ParkReachability extends Model
{
    protected $table = "park_reachabilities";
    protected $primaryKey = 'park_reachability_id';
    protected $fillable = ['park_id', 'title', 'display_image', 'description', 'heading', 'reachability_id'];

    public function reachabilityDistance()
    {
        return $this->hasMany(ParkReachabilityDistance::class, 'reachability_id');
    }

    public function reachability()
    {
        return $this->belongsTo(ReachabilityMode::class, 'reachability_id');
    }

    protected static function booted()
    {
        static::deleting(function ($parkId) {
            if ($parkId->display_image) {
                // $path = public_path($parkId->display_image);
                // if (File::exists($path)) {
                //     File::delete($path);
                // }
                 ImageUploadHelper::delete($parkId->display_image);
            }
        });
    }

      // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_reachability_id;
    }
}
