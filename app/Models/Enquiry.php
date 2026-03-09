<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    protected $table = "enquiries";
    protected $primaryKey = 'enquiry_id';

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
