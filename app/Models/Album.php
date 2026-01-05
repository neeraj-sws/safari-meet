<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['title', 'description', 'cover_image', 'category_id', 'upload_id'];

    public function images()
    {
        return $this->hasMany(AlbumImage::class);
    }

    public function category()
    {
        return $this->belongsTo(AlbumCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }
}
