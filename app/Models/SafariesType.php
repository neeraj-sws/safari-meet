<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafariesType extends Model
{
    // this model for only booked safaries

    protected $table = "safaries_types";
    protected $primaryKey = 'safaries_type_id';
    protected $fillable = [
        'package_id',
        'shared_safari_id',
        'safari_type_id',
    ];

    public function types()
    {
        return $this->belongsTo(SafariType::class, 'safari_type_id', 'safari_type_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safaries_type_id;
    }
}
