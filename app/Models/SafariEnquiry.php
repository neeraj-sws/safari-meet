<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafariEnquiry extends Model
{
    use HasFactory;

    protected $table = "safari_enquiries";
    protected $primaryKey = 'enquiry_id';
    protected $fillable = [
        'package_id',
        'name',
        'email',
        'country',
        'mobile_number',
        'package_owner_type',
        'owner_id',
        'travelers',
        'start_date',
        'user_id',
        'message',
        'ip_address',
        'browser',
        'os',
        'device',
    ];

    public function packagesafari()
    {
        return $this->belongsTo(Package::class, 'package_id', 'package_id');
    }


    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->enquiry_id;
    }
}
