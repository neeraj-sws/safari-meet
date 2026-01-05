<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class DietModel extends Model
{
    use HasFactory;

    protected $table = "species_dietes";

    protected $primaryKey = "species_diete_id";

    protected $fillable = [
        'species_id',
        'title',
        'image',
        'short_description',
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
        return $this->species_diete_id;
    }
}
