<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinSharedSafari extends Model
{
    protected $table = 'join_shared_safaris';
    protected $primaryKey = "join_shared_safari_id";
    protected $fillable = ['user_id', 'share_safari_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','user_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->join_shared_safari_id;
    }
}
