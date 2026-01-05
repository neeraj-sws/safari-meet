<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportResion extends Model
{
    protected $table = "report_resions";
    protected $primaryKey = "report_resion_id";
    protected $fillable = [
        'title',
        'status',
    ];

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->report_resion_id;
    }
}
