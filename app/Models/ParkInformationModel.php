<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;

class ParkInformationModel extends Model
{
    protected $table = "park_information";
    protected $primaryKey = "park_information_id";
    protected $fillable = [
        'park_id',
        'information',
        'booking_process',
        'dos_image',
        'dos_description',
        'donts_image',
        'donts_description',
    ];

    protected static function booted()
    {
        static::deleting(function ($parkId) {
            $imageFields = ['dos_image', 'donts_image'];

            foreach ($imageFields as $field) {
                if ($parkId->$field) {
                    // $path = public_path($parkId->$field);
                    // if (File::exists($path)) {
                    //     File::delete($path);
                    // }
                     ImageUploadHelper::delete($parkId->$field);
                }
            }
        });
    }

     // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_information_id;
    }
}
