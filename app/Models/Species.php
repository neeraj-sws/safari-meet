<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use App\Helpers\ImageUploadHelper;

class Species extends Model
{
    protected $fillable = ['name', 'status', 'display_image', 'slug', 'uuid', 'banner_image', 'meta_title', 'meta_key', 'meta_description','top_species','meta_image'];

    protected $primaryKey = 'species_id';

    protected static function booted()
    {
        static::creating(function ($species) {
            $species->uuid = Str::uuid()->toString();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($species) {
            $imageFields = ['display_image', 'banner_image','meta_image'];

            foreach ($imageFields as $field) {
                if ($species->$field) {
                    // $path = public_path($species->$field);
                    // if (File::exists($path)) {
                    //     File::delete($path);
                    // }
                     ImageUploadHelper::delete($species->$field);
                }
            }


            SpeciesThreatModel::where('species_id', $species->id)->get()->each->delete();
            SpeciesOverviewModel::where('species_id', $species->id)->get()->each->delete();
            DietModel::where('species_id', $species->id)->get()->each->delete();

            SpeciesPhysicalAppereancesModel::where('species_id', $species->id)->delete();
            SpeciesLifestyleModel::where('species_id', $species->id)->delete();
            SpeciesInterestingFactsModel::where('species_id', $species->id)->delete();
            SpeciesDetailsDynamicTabs::where('species_id', $species->id)->delete();
            SpeciesDetailsCharactersticModel::where('species_id', $species->id)->delete();
            AdaptationModel::where('species_id', $species->id)->delete();
        });
    }

    public function charactersticDetails()
    {
        return $this->hasMany(SpeciesDetailsCharactersticModel::class, 'species_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_id;
    }
}
