<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitPurpose extends Model
{
    protected $primayKey = 'visit_purpose_id';
    protected $fillable = ['name', 'description'];
    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->visit_purpose_id;
    }
}
