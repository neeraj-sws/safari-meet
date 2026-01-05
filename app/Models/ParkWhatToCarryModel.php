<?php

namespace App\Models;

use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ParkWhatToCarryModel extends Model
{
    use HasFactory;

    protected $table = "park_what_to_carry";

    protected $primaryKey = 'park_what_to_carry_id';

    protected $fillable = [
        'park_id',
        'heading',
        'short_description',
        'image'
    ];
    protected static function booted()
    {
        static::deleting(function ($parkId) {
            if ($parkId->image) {
                $path = public_path($parkId->image);
                // if (File::exists($path)) {
                //     File::delete($path);
                // }
                 ImageUploadHelper::delete($parkId->image);
            }
        });
    }

    // ID ALIAS
    public function getIdAttribute()
    {
        return $this->park_what_to_carry_id;
    }
}
