<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    protected $table = "seo_pages";
    protected $primaryKey = "seo_pages_id";
    protected $fillable = ['title', 'slug', 'meta_title', 'meta_description', 'meta_image'];

    protected static function booted()
    {

        static::deleting(function ($model) {
            $imageFields = ['meta_image'];

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
        return $this->seo_pages_id;
    }
}
