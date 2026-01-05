<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'actor_type',
        'actor_id',
        'actor_identifier',
        'action',
        'category',
        'message',
        'guard',
        'method',
        'url',
        'parameters',
        'ip_address',
        'user_agent',
        'happened_at',
    ];

    protected $casts = [
        'parameters' => 'array',
        'happened_at' => 'datetime',
    ];


    public function getActorNameAttribute()
    {
        try {
            if ($this->actor_type && $this->actor_id) {
                $modelClass = "\\App\\Models\\{$this->actor_type}";

                if (class_exists($modelClass)) {
                    $user = $modelClass::find($this->actor_id);

                    if ($user) {
                        if (isset($user->name)) {
                            return $user->name;
                        } elseif (isset($user->username)) {
                            return $user->username;
                        } elseif (isset($user->email)) {
                            return $user->email;
                        }
                    }
                }
            }
            return $this->actor_identifier ?? 'Guest';
        } catch (\Throwable $e) {
            return 'Guest';
        }
    }

    public function getReadableMessageAttribute()
    {
        $user = $this->actor_name;
        $time = $this->happened_at ? $this->happened_at->format('d M Y h:i A') : '';
        return "{$user} {$this->message} ({$time})";
    }
}
