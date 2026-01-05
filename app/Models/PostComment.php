<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostComment extends Model
{
    use HasFactory;

    protected $table = 'post_comments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function post()
    {
        return $this->belongsTo(MediaPost::class, 'post_id');
    }
}
