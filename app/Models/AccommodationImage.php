<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;

class AccommodationImage extends Model
{
    protected $table = "accommodation_images";
    protected $primaryKey = "accommodation_image_id";
    protected $fillable = ['image', 'time', 'accommodation_id'];

    protected static function booted()
    {

        static::deleting(function ($model) {
            $imageFields = ['image'];

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
        return $this->accommodation_image_id;
    }
}
