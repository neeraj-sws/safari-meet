<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $fillable = ['name', 'status'];
    protected $primaryKey = "faq_categoryid";
    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->faq_categoryid;
    }
}
