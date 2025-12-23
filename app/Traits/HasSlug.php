<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            $model->{$model->getSlugField()} = static::generateUniqueSlug($model->{$model->getSlugSourceField()});
        });

        static::updating(function ($model) {
            $slugField = $model->getSlugField();
            $sourceField = $model->getSlugSourceField();

            if ($model->isDirty($sourceField)) {
                $model->{$slugField} = static::generateUniqueSlug(
                    $model->{$sourceField},
                    $model->id
                );
            }
        });
    }

    protected static function generateUniqueSlug($value, $ignoreId = null)
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $i++;
        }

        return $slug;
    }

    protected function getSlugSourceField()
    {
        return 'title';
    }

    protected function getSlugField()
    {
        return 'slug';
    }
}
