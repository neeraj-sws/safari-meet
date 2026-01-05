<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;


class SpeciesThreatModel extends Model
{
    use HasFactory;

    protected $table = "species_threats";

    protected $primaryKey = "species_threat_id";

    protected $fillable = [
        'species_id',
        'species_details_characterstics_id',
        'short_description',
        'image',
        'threat',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if ($model->image) {
                $path = public_path($model->image);
                // if (File::exists($path)) {
                //     File::delete($path);
                // }
                 ImageUploadHelper::delete($model->image);
            }
        });
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_threat_id;
    }
}
