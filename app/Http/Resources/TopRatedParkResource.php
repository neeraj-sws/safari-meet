<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TopRatedParkResource
 *
 * Following Single Responsibility Principle (SRP)
 * This resource is responsible ONLY for transforming Park model data into JSON response
 *
 * Following Open/Closed Principle (OCP)
 * Can be extended for additional transformations without modifying core logic
 *
 * @package App\Http\Resources
 */
class TopRatedParkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->park_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'famous_for' => $this->famous_for,
            'banner_title' => $this->banner_title,
            'display_image' => $this->display_image,

            // Location information
            'location' => [
                'city' => $this->whenLoaded('city', fn() => [
                    'id' => $this->city->city_id,
                    'name' => $this->city->name,
                ]),
                'state' => $this->whenLoaded('state', fn() => [
                    'id' => $this->state->state_id,
                    'name' => $this->state->name,
                ]),
                'country' => $this->whenLoaded('country', fn() => [
                    'id' => $this->country->country_id,
                    'name' => $this->country->name,
                ]),
            ],

            // Safari types available
            'safari_types' => $this->when(isset($this->park_safari_types), $this->park_safari_types),

            // Best time to visit (weather-based)
            'best_time_to_visit' => $this->when(isset($this->park_best_times), $this->park_best_times),

            // Wildlife/Species available
            'species' => $this->when(isset($this->species_list), $this->species_list),

            // SEO metadata
            'meta' => [
                'title' => $this->meta_title,
                'description' => $this->meta_description,
            ],

            // Flags
            'is_top_rated' => (bool) $this->top_rated,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Top rated parks retrieved successfully',
        ];
    }
}
