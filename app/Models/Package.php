<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use App\Livewire\Admin\SafariTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class Package extends Model
{
    protected $primaryKey = 'package_id';
    protected $fillable = [
        'title',
        'slug',
        'park_id',
        'visit_purpose_id',
        'stay_category_id',
        'min_price_pp',
        'max_price_pp',
        'display_image',
        'organized_by',
        'end_tour',
        'start_tour',
        'tour_highlights',
        'status',
        'best_time',
        'no_of_safari',
        'type',
        'popular',
        'trending',
        'top_rated',
        'ip_address',
        'browser',
        'os',
        'device',
        'is_completed',
        'meta_title',
        'meta_description',
        'meta_image',
        'is_paid',
    ];

    public function park()
    {
        return $this->belongsTo(Park::class, 'park_id', 'park_id');
    }
    public function SafariFaq()
    {
        // return $this->hasMany(SafariFaq::class, 'package_id', 'package_id');
    }

    public function featuer_safaries()
    {
        return $this->hasMany(FeaturePackageSafari::class, 'package_id', 'package_id');
    }

    public function safariTypes()
    {
        return $this->hasMany(SafariesType::class, 'package_id', 'package_id');
    }

    public function bestTimeToVisit()
    {
        return $this->belongsTo(WeatherModel::class, 'best_time', 'package_id');
    }

    public function detailsTabs()
    {
        return $this->hasMany(PackageDetailsTabs::class, 'package_id', 'package_id');
    }

    public function banners()
    {
        return $this->hasMany(PackageBanner::class, 'package_id', 'package_id');
    }

    public function thingsToCarries()
    {
        return $this->hasMany(FeatureThingsToCarrySafari::class, 'package_id', 'package_id');
    }

    public function safariRatingHeading()
    {
        return $this->hasMany(SafariRatingHeading::class, 'package_id', 'package_id');
    }
    public function itinerary()
    {
        return $this->hasMany(ItineraryPackage::class, 'package_id', 'package_id');
    }
    public function dynamicTabs()
    {
        return $this->hasMany(SafariDetailsDynamicTabs::class, 'package_id', 'package_id');
    }
    public function agent()
    {
        return $this->belongsTo(User::class, 'organized_by', 'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(admin::class, 'organized_by', 'admin_id');
    }
    public function safariaccommodation()
    {
        return $this->hasOne(SafariAccommodation::class, 'package_id', 'package_id');
    }
    // public function admin(){
    //      return $this->belongsTo(admin::class,'organized_by','id');
    // }



    protected static function booted()
    {
        static::creating(function ($package) {
            $package->uuid = Str::uuid()->toString();
        });

        static::deleting(function ($package) {
            $imageFields = ['display_image', 'meta_image'];

            foreach ($imageFields as $field) {
                if ($package->$field) {
                    // $path = public_path($package->$field);
                    // if (File::exists($path)) {
                    //     File::delete($path);
                    // }
                    ImageUploadHelper::delete($package->$field);
                }
            }

            SafariDetailsDynamicTabs::where('package_id', $package->id)->delete();
            SafariDiscussion::where('package_id', $package->id)->delete();
            // SafariFaq::where('package_id', $package->id)->delete();
            FeatureThingsToCarrySafari::where('package_id', $package->id)->delete();
            SafariRating::where('package_id', $package->id)->delete();
            SafariRatingHeading::where('package_id', $package->id)->delete();
            SafariAccommodation::where('package_id', $package->id)->delete();
            FeaturePackageSafari::where('package_id', $package->id)->delete();
            Wishlist::where('package_id', $package->id)->delete();
            PackageDetailsTabs::where('package_id', $package->id)->delete();
            ItineraryPackage::where('package_id', $package->id)->each(function ($package) {
                $package->packageActivities()->delete();
                $package->delete();
            });

            PackageBanner::where('package_id', $package->id)->get()->each->delete();
        });
    }

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payable');
    }


    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->package_id;
    }
}
