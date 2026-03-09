<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    protected $table = "enquiries";
<<<<<<< HEAD
    protected $primaryKey = 'enquiry_id';
=======
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b

    protected $fillable = [
         'safaris',
        'travellers',
        'accommodation_id',
        'ip_address',
        'source',
        'browser',
        'os',
        'device',
        'start_date',
        'end_date',
        'type',
        'type_id',
        'url',
        'name',
        'number',
         'email',
    ];

    public function accommodation()
    {
        return $this->belongsTo(EnquiryAccommodation::class, 'accommodation_id');
    }
}
