<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkFaq extends Model
{
    protected $table = "park_faqs";
    protected $primaryKey = "park_faqs_id";
    protected $fillable = ['question', 'answer', 'park_id'];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'package_id');
    }
    public function shareSafari()
    {
        return $this->belongsTo(ShareSafari::class, 'share_safari_id', 'share_safari_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_faqs_id;
    }
}
