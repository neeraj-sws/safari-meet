<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafariConversationMessage extends Model
{
    protected $table = "safari_conversation_messages";
    protected $primaryKey = "safari_conversation_messages_id";

    protected $fillable = [
        'safari_conversation_id',
        'sender_id',
        'sender_type',
        'receiver_type',
        'receiver_id',
        'message',
    ];

    public function sender()
    {
        return $this->morphTo(__FUNCTION__, 'sender_type', 'sender_id');
    }

    public function receiver()
    {
        return $this->morphTo(__FUNCTION__, 'receiver_type', 'receiver_id');
    }

    /**
     * Relation with Conversation
     */
    public function conversation()
    {
        return $this->belongsTo(SafariConversation::class, 'safari_conversation_id', 'safari_conversations_id');
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->safari_conversation_messages_id;
    }
}
