<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PackageTabs extends Model
{
    use HasFactory;

    protected $table = "package_tabs";

    protected $primaryKey = 'package_tabs_id';

    protected $fillable = [
        'title',
        'status'
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->package_tabs_id;
    }
}
