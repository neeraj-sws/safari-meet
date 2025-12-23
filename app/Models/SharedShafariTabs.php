<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SharedShafariTabs extends Model
{
    use HasFactory;

    protected $table = "shared_shafari_tabs";

    protected $primaryKey = "shared_shafari_tabs_id";

    protected $fillable = [
        'title',
        'status'
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->shared_shafari_tabs_id;
    }
}
