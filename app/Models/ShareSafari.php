<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ShareSafari extends Model
{
    protected $table = "shared_safaris";
    protected $primaryKey = "shared_safari_id";

    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'short_description',
        'safari_park_id',
        'day',
        'night',
        'no_of_safari',
        'visit_purpose_id',
        'stay_category_id',
        'min_price_pp',
        'max_price_pp',
        'total_seats',
        'share_seats',
        'is_create_safari_complete',
        'display_image',
        'organized_by',
        'best_month_start',
        'best_month_end',
        'category_id',
        'organized_type',
        'popular',
        'trending',
        'top_rated',
        'ip_address',
        'browser',
        'os',
        'device',
        'is_seat_full',
        'is_admin_approvel',
        'is_paid',
        'status',
        'is_approved',
    ];

    public function park()
    {
        return $this->belongsTo(Park::class, 'safari_park_id', 'park_id');
    }

    protected function getSlugSourceField()
    {
        return 'title';
    }

    protected function getSlugField()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(SpeciesCategory::class, 'category_id', 'species_category_id');
    }

    public function featuer_safaries()
    {
        return $this->hasMany(FeaturePackageSafari::class, 'share_safari_id', 'shared_safari_id');
    }

    public function safariTypes()
    {
        return $this->hasMany(SafariesType::class, 'shared_safari_id', 'shared_safari_id');
    }

    public function dynamicTabs()
    {
        return $this->hasMany(SafariDetailsDynamicTabs::class, 'shared_safari_id', 'shared_safari_id');
    }

    public function detailsTabs()
    {
        return $this->hasMany(SharedSafariDetailsTabs::class, 'shared_safari_id', 'shared_safari_id');
    }

    public function joinedsafari()
    {
        return $this->hasMany(JoinSharedSafari::class, 'share_safari_id');
    }

    public function allottedSeat()
    {
        return $this->hasMany(SafariAllottedSeat::class, 'shared_safari_id');
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organized_by');
    }



    protected static function booted()
    {
        static::creating(function ($shared_safari) {
            $shared_safari->uuid = Str::uuid()->toString();
        });

        static::deleting(function ($model) {
            $imageFields = ['display_image'];

            foreach ($imageFields as $field) {
                if ($model->$field) {
                    // $path = public_path($model->$field);
                    // if (File::exists($path)) {
                    //     File::delete($path);
                    // }
                    ImageUploadHelper::delete($model->$field);

                }
            }
            SafariDiscussion::where('share_safari_id', $model->id)->delete();
            // SafariFaq::where('share_safari_id',$model->id)->delete();
            FeatureThingsToCarrySafari::where('share_safari_id', $model->id)->delete();
            FeaturePackageSafari::where('share_safari_id', $model->id)->delete();
            SharedSafariDetailsTabs::where('shared_safari_id', $model->id)->delete();
            Wishlist::where('shared_safari_id', $model->id)->delete();
            JoinSharedSafari::where('share_safari_id', $model->id)->delete();
            SafariAllottedSeat::where('shared_safari_id', $model->id)->delete();
        });
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->shared_safari_id;
    }

    public function payments()
    {
        return $this->hasOne(Payment::class, 'payable_id')
            ->where('payable_type', 'shared-safari');
    }

}
