<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafariConversation extends Model
{
    protected $table = "safari_conversations";
    protected $primaryKey = "safari_conversations_id";
    protected $fillable = [
        'package_id',
        'share_safari_id',
        'creator_id',
        'participant_id',
        'parent_id',
        'organized_type',
        'creator_type',
        'participant_type',
    ];

    public function safari()
    {
        return $this->belongsTo(ShareSafari::class, 'share_safari_id');
    }

    // public function creator()
    // {
    //     return $this->belongsTo(User::class, 'creator_id');
    // }

    // public function participant()
    // {
    //     return $this->belongsTo(User::class, 'participant_id');
    // }

    public function creator()
    {
        return $this->morphTo(__FUNCTION__, 'creator_type', 'creator_id');
    }

    public function participant()
    {
        return $this->morphTo(__FUNCTION__, 'participant_type', 'participant_id');
    }

    public function participantAdmin()
    {
        return $this->belongsTo(Admin::class, 'participant_id');
    }

    public function messages()
    {
        return $this->hasMany(SafariConversationMessage::class, 'safari_conversation_id', 'safari_conversations_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_conversations_id;
    }
}
