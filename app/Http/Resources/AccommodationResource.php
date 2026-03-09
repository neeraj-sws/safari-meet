<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccommodationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'accommodation_id'   => $this->id,
            'name' => $this->title,
        ];
    }
}
