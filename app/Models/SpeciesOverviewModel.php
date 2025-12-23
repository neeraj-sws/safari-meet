<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;


class SpeciesOverviewModel extends Model
{
    use HasFactory;

    protected $table = "species_overview";

    protected $primaryKey = 'species_overview_id';

    protected $fillable = [
        'species_id',
        'species_details_characterstics_id',
        'about',
        'about_image',
        'life_span',
        'speed',
        'mass',
        'height',
        'length',
        'species_category_id',
        'species_family_id',
        'species_genus_id',
    ];


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if ($model->about_image) {
                $path = public_path($model->about_image);
                // if (File::exists($path)) {
                //     File::delete($path);
                // }
                 ImageUploadHelper::delete($model->about_image);
            }
        });
    }


    public function category()
    {
        return $this->belongsTo(SpeciesCategory::class, 'species_category_id', 'species_category_id');
    }
    public function family()
    {
        return $this->belongsTo(SpeciesFamilyModel::class, 'species_family_id', 'species_family_id');
    }
    public function genus()
    {
        return $this->belongsTo(SpeciesGenusModel::class, 'species_genus_id','species_genus_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_overview_id;
    }
}
