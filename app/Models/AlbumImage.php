<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumImage extends Model
{
    protected $fillable = ['album_id', 'image_path','upload_id'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }
}
