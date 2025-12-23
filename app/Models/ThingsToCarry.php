<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;

class ThingsToCarry extends Model
{
    protected $primaryKey = 'things_to_carry_id';
    protected $fillable = ['title', 'short_description', 'image'];

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
        return $this->things_to_carry_id;
    }
}
