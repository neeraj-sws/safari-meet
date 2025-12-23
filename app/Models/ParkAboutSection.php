<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;


class ParkAboutSection extends Model
{
    use HasFactory;

    protected $table = "park_about_section";

    protected $primaryKey = "park_about_section_id";

    protected $fillable = [
        'park_id',
        'title',
        'image',
        'short_description',
    ];

    protected static function booted(){
        static::deleting(function($parkId){
            if ($parkId->image) {
                // $path = public_path($parkId->image);
                // if (File::exists($path)) {
                //     File::delete($path);
                // }
                ImageUploadHelper::delete($parkId->image);
            }
        });
    }

      // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_about_section_id;
    }
}
