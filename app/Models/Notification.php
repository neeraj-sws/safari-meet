<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';

    /**
     * Fillable Columns
     */
    protected $fillable = [
        'receiver_id',
        'receiver_type',
        'sender_id',
        'sender_type',
        'type',
        'heading',
        'message',
        'data',
        'category',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function receiver()
    {
        return $this->morphTo(__FUNCTION__, 'receiver_type', 'receiver_id');
    }

    public function sender()
    {
        return $this->morphTo(__FUNCTION__, 'sender_type', 'sender_id');
    }


    public function template()
    {
        return $this->belongsTo(NotificationMessage::class, 'type', 'key');
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function getIdAttribute()
    {
        return $this->notification_id;
    }
}
