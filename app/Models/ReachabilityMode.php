<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;

class ReachabilityMode extends Model
{
    protected $table = "reachability_modes";
    protected $primaryKey = 'reachability_modes_id';
    protected $fillable = ['title', 'slug', 'status', 'display_image'];

    protected static function booted()
    {

        static::deleting(function ($model) {
            $imageFields = ['display_image'];

            foreach ($imageFields as $field) {
                if ($model->$field) {
                    // $path = public_path($package->$field);
                    // if (File::exists($path)) {
                    //     File::delete($path);
                    // }
                    ImageUploadHelper::delete($model->$field);
                }
            }
        });
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->reachability_modes_id;
    }
}
