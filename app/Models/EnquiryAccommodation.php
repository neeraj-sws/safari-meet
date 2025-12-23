<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnquiryAccommodation extends Model
{
   protected $table = 'enquiries_accommodations';
   protected $fillable = ['title','status'];
}
