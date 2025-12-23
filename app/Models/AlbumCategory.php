<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumCategory extends Model
{
    protected $fillable = ['name'];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
