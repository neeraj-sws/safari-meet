<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationMessage extends Model
{
    use HasFactory;

    protected $table = 'notification_message';
    protected $primaryKey = 'notification_message_id';

    /**
     * Fillable Columns
     */
    protected $fillable = [
        'key',
        'message',
        'is_active',
    ];

    /**
     * Active Scope — sirf active templates lane ke liye
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Relation with notifications (ek template se multiple notifications)
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'type', 'key');
    }

    public function getIdAttribute()
    {
        return $this->notification_message_id;
    }
}
