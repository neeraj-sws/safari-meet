<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

<<<<<<< HEAD
class Payment extends Model
{
    use HasFactory;

=======

class Payment extends Model
{
    protected $table = "payments";
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    protected $fillable = [
        'user_id',
        'payable_type',
        'payable_id',
        'amount',
<<<<<<< HEAD
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
=======
        'rrn',
        'screenshot',
    ];

    public function safari()
    {
        return $this->belongsTo(ShareSafari::class, 'payable_id');
    }


>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
}
