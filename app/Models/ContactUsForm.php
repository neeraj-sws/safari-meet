<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUsForm extends Model
{
    use HasFactory;

    protected $table = "contact_us_forms";
     protected $primaryKey = 'contact_us_form_id';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'people_traveling',
        'travel_date',
        'park_id',
        'safari_type_id',
        'message',
    ];

    public function park()
    {
        return $this->belongsTo(Park::class,'park_id');
    }

    public function safariType()
    {
        return $this->belongsTo(ParkSafariType::class, 'safari_type_id','park_safari_type_id');
    }
}
