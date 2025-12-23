<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    protected $table = "notification_templates";
    protected $primaryKey = "notification_templates_id";
    protected $fillable = ['template_code', 'name', 'subject', 'body', 'short_codes', 'status'];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->notification_templates_id;
    }
}
