<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = "coupons";

    protected $primaryKey = 'coupon_id';

    protected $fillable = ["coupon_code","start_date","end_date","status","amount"];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->coupon_id;
    }
}
