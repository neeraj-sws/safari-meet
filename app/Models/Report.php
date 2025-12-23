<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = "reports";
    protected $primaryKey = "report_id";

    protected $fillable = [
        'report_type',
        'share_safari_id',
        'report_resion_id',
        'package_id',
        'comment_id',
        'comment',
        'details',
        'post_id',
    ];

    public function getIdAttribute()
    {
        return $this->report_id;
    }


    public function reportReason()
    {
        return $this->belongsTo(ReportResion::class, 'report_resion_id', 'report_resion_id');
    }

    public function sharedSafari()
    {
        return $this->belongsTo(ShareSafari::class, 'share_safari_id', 'shared_safari_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'package_id');
    }

    public function discussion()
    {
        return $this->belongsTo(SafariDiscussion::class, 'comment_id', 'safari_discussion_id');
    }

    public function mediaPost()
    {
        return $this->belongsTo(MediaPost::class, 'post_id', 'id');
    }
}
