<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];
    protected $primaryKey = "site_settings_id";
    public $timestamps = false;

    public static function getValue($key, $default = '')
    {
        return static::where('key', $key)->value('value') ?? $default;
    }


    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->species_id;
    }
}
