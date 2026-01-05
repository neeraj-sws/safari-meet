<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;

class PackageBanner extends Model
{
    protected $table = "package_banners";
    protected $primaryKey = 'package_banners_id';
    protected $fillable = [
        'package_id',
        'image',
    ];


     protected static function boot()
    {
        parent::boot();

        static::deleting(function ($species) {
            $imageFields = ['image'];

            foreach ($imageFields as $field) {
                if ($species->$field) {
                    $path = public_path($species->$field);
                    // if (File::exists($path)) {
                    //     File::delete($path);
                    // }
                     ImageUploadHelper::delete($species->$field);
                }
            }
        });
    }

        // ID ALIAS
    public function getIdAttribute()
    {
        return $this->package_banners_id;
    }

}
