<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Payment extends Model
{
    protected $table = "payments";
    protected $fillable = [
        'user_id',
        'payable_type',
        'payable_id',
        'amount',
        'rrn',
        'screenshot',
    ];

    public function safari()
    {
        return $this->belongsTo(ShareSafari::class, 'payable_id');
    }


}
