<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{

    protected $table = "wishlists";
    protected $primaryKey = "wishlist_id";
    protected $fillable = [
        'user_id',
        'package_id',
        'shared_safari_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'package_id');
    }

    public function sharedSafari()
    {
        return $this->belongsTo(ShareSafari::class, 'shared_safari_id', 'shared_safari_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->wishlist_id;
    }
}
