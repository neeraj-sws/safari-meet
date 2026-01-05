<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ParkSpecies extends Model
{
    protected $table = "park_species";
    protected $primaryKey = "park_species_id";

    protected $fillable = ['park_id', 'species_id', 'name', 'display_image', 'slug'];

    protected static function booted()
    {
        static::deleting(function ($parkId) {
            if ($parkId->display_image) {
                $path = public_path($parkId->display_image);
                // if (File::exists($path)) {
                //     File::delete($path);
                // }
                 ImageUploadHelper::delete($parkId->display_image);
            }
        });
    }

    public function speciesList()
    {
        return $this->belongsTo(Species::class, 'species_id','species_id');
    }

     // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_species_id;
    }
}
