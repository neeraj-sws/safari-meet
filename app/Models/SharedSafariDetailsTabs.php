<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SharedSafariDetailsTabs extends Model
{
    use HasFactory;

    protected $table = "shared_safari_details_tabs";

    protected $primaryKey = "shared_safari_details_tabs_id";

    protected $fillable = [
        'shared_safari_tabs_id',
        'shared_safari_id',
        'title',
        'status'
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->shared_safari_details_tabs_id;
    }
}
