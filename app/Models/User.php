<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'username',
        'email',
        'password',
        'user_type',
        'status',
        'experience_year',
        'country_id',
        'state_id',
        'city_id',
        'website_url',
        'phone_number',
        'contact_person',
        'license_number',
        'dob',
        'gender',
        'short_title',
        'short_description',
        'facebook',
        'instagram',
        'youtube',
        'twitter',
        'profile_photo_path',
        'ip_address',
        'browser',
        'os',
        'device',
        'login_at',
        'logout_at',
        'agency_name',
        'otp_expires_at',
        'email_verified_otp',
        'email_verified_at',
        'stauts',
        'remark',
        'is_profile_complete',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->user_id;
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function userFollowings()
    {
        return $this->hasMany(Follow::class, 'follower_id', 'id')
            ->where('status', 'accepted');
    }

    public function userFollowers()
    {
        return $this->hasMany(Follow::class, 'following_id', 'id')
            ->where('status', 'accepted');
    }

    public function sharedSafariSeats()
    {
        return $this->hasOne(SafariAllottedSeat::class, 'user_id', 'user_id');
    }
}
