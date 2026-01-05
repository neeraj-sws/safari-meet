<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use App\Traits\HasSlug;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class Park extends Model
{
    use HasFactory;
    protected $primaryKey = "park_id";
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'city_id',
        'state_id',
        'country_id',
        'wildlife_found',
        'closed_months',
        'area',
        'established',
        'famous_for',
        'core_zone_price',
        'status',
        'buffer_zone_price',
        'core_zone',
        'buffer_zone',
        'entry_gates',
        'nearest_railway',
        'morning_time',
        'afternoon_time',
        'display_image',
        'banner_image',
        'meta_title',
        'meta_description',
        'description',
        'banner_title',
        'top_rated',
        'popular',
        'trending',
        'top_safari',
        'meta_image',
    ];

    protected function getSlugSourceField()
    {
        return 'title';
    }

    // protected function getSlugField()
    // {
    //     return 'slug';
    // }

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','country_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class,'state_id','state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id','city_id');
    }
    public function wildlife()
    {
        return $this->hasMany(ParkWildlifeFoundModel::class, 'park_id');
    }
    public function parkdetail()
    {
        return $this->hasOne(ParkDetail::class);
    }

    public function parkSafariTypes()
    {
        return $this->hasMany(ParkSafariType::class, 'park_id');
    }
    public function parkrule()
    {
        // return $this->hasMany(ParkRule::class, 'park_id');
    }
    public function parkspecies()
    {
        return $this->hasMany(ParkSpecies::class, 'park_id','park_id');
    }
    public function parkBestTimes()
    {
        return $this->hasMany(ParkBestTimeModel::class, 'park_id');
    }

    public function DetailsCharacterstic()
    {
        return $this->hasMany(ParkDetailsTabs::class, 'park_id');
    }

    protected static function booted()
    {
        static::creating(function ($park) {
            $park->uuid = Str::uuid()->toString();
        });


        static::deleting(function ($parkId) {
            $imageFields = ['dos_image', 'donts_image','meta_image'];

            foreach ($imageFields as $field) {
                if ($parkId->$field) {
                    // $path = public_path($parkId->$field);
                    // if (File::exists($path)) {
                    //     File::delete($path);
                    // }
                    ImageUploadHelper::delete($parkId->$field);
                }
            }

            ParkZoneModel::where('park_id', $parkId)->get()->each->delete();
            ParkWhatToCarryModel::where('park_id', $parkId)->get()->each->delete();
            ParkSpecies::where('park_id', $parkId)->get()->each->delete();
            ParkReachability::where('park_id', $parkId)->get()->each->delete();
            ParkKeyInfoModel::where('park_id', $parkId)->get()->each->delete();
            ParkInformationModel::where('park_id', $parkId)->get()->each->delete();
            ParkAboutSection::where('park_id', $parkId)->get()->each->delete();

            ParkWildlifeFoundModel::where('park_id', $parkId)->delete();
            ParkTraveltipsModel::where('park_id', $parkId)->delete();
            ParkSafariType::where('park_id', $parkId)->delete();

            $safariTimes = ParkSafariTime::where('park_id', $parkId)->get();
            foreach ($safariTimes as $safariTime) {
                ParkSafariTimeDetail::where('park_safari_time_id', $safariTime->id)->delete();
            }
            ParkSafariTime::where('park_id', $parkId)->delete();
            ParkReachabilityDistance::where('park_id', $parkId)->delete();
            ParkDetailsTabs::where('park_id', $parkId)->delete();
            ParkDetailsDynamicTabs::where('park_id', $parkId)->delete();
            ParkDetail::where('park_id', $parkId)->delete();
            ParkBestTimeVistModel::where('park_id', $parkId)->delete();
            ParkBestTimeModel::where('park_id', $parkId)->delete();
            ParkAccommodation::where('park_id', $parkId)->delete();
        });
    }

        // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_id;
    }
}
