<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PackageDetailsTabs extends Model
{
    use HasFactory;

    protected $table ="package_details_tabs";

    protected $primaryKey = 'package_details_tabs_id';

    protected $fillable = [
        'package_tabs_id',
        'package_id',
        'title',
        'status'
    ];

      // ID ALIAS
    public function getIdAttribute()
    {
        return $this->package_details_tabs_id;
    }

}
