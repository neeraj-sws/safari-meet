<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payable_type',
        'payable_id',
        'amount',
        'utr',
        'screenshot',
        'coupon_code',
        'discounted_amount',
        'final_amount',
    ];

    /* ---------------- Relations ---------------- */

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','user_id');
    }

    /**
     * Polymorphic relation
     * payable_type:
     *  - shared-safari
     *  - safari-package
     */
    public function payable()
    {
        return $this->morphTo();
    }
}
