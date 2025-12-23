<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;

class HomePageBannerModel extends Model
{
    protected $table = 'home_page_banners';
    protected $primaryKey = "ihome_page_banners_d";
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
        return $this->ihome_page_banners_d;
    }
}
