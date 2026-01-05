<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MediaPost extends Model
{
    use HasFactory;

    protected $table = 'media_posts';

    protected $fillable = [
        'user_id',
        'user_type',
        'media_url',
        'caption',
        'type',
        'visibility',
        'park_id',
    ];

    protected static function booted()
    {

        static::deleting(function ($model) {
            $imageFields = ['media_url'];

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function adminUser()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function park()
    {
        return $this->belongsTo(Park::class, 'park_id', 'park_id');
    }


    public function getUserModelAttribute()
    {
        return $this->user_type === 'user' || $this->user_type === 'agent' ? $this->user : $this->adminUser;
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }
}
