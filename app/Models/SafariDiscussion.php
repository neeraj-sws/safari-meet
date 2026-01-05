<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafariDiscussion extends Model
{
    protected $table = 'safari_discussion';

    protected $primaryKey = "safari_discussion_id";

    protected $fillable = [
        'package_id',
        'share_safari_id',
        'user_id',
        'content',
        'is_admin',
        'parent_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(SafariDiscussion::class, 'parent_id')->with(['user', 'admin', 'replies'])->orderBy('created_at');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_discussion_id;
    }
}
