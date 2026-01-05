<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;

class ParkKeyInfoModel extends Model
{
    protected $table = "park_key_info";
    protected $primaryKey = 'park_key_info_id';
    protected $fillable = [
        'park_id',
        'overview_image',
        'travel_info_image',
        'timing_cost_image',
    ];

    protected static function booted()
    {
        static::deleting(function ($parkId) {
            $imageFields = ['overview_image', 'travel_info_image', 'timing_cost_image'];

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
        return $this->park_key_info_id;
    }
}
