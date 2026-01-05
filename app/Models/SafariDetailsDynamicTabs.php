<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SafariDetailsDynamicTabs extends Model
{
    use HasFactory;

    protected $table = "safari_details_dynamic_tabs";

    protected $primaryKey = 'safari_details_dynamic_tabs_id';

    protected $fillable = [
        'package_id',
        'shared_safari_id',
        'package_details_tabs_id',
        'shared_shafari_details_tabs_id',
        'short_description',
        'key',
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_details_dynamic_tabs_id;
    }
}
