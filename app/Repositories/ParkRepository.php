<?php

namespace App\Repositories;

use App\Contracts\Repositories\ParkRepositoryInterface;
use App\Models\Park;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class ParkRepository
 *
 * Following Single Responsibility Principle (SRP)
 * This class is responsible ONLY for data access operations
 *
 * Following Dependency Inversion Principle (DIP)
 * Depends on abstraction (Model) not concrete implementation
 */
class ParkRepository implements ParkRepositoryInterface
{
    /**
     * @var Park
     */
    protected Park $model;

    /**
     * ParkRepository constructor.
     *
     * @param Park $model - Dependency Injection
     */
    public function __construct(Park $model)
    {
        $this->model = $model;
    }

    /**
     * Get top rated parks with their relationships
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getTopRatedParks(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with([
                'country:country_id,name',
                'state:state_id,name',
                'city:city_id,name',
                'parkSafariTypes:park_safari_type_id,park_id,safari_type_id',
                'parkSafariTypes.safari_type:safari_type_id,name',
                'parkBestTimes:park_best_time_id,park_id,weathers_id',
                'parkBestTimes.weather:park_weather_id,title',
                'wildlife.species'
            ])
            ->select([
                'park_id',
                'name',
                'slug',
                'short_description',
                'city_id',
                'state_id',
                'country_id',
                'display_image',
                'famous_for',
                'meta_title',
                'meta_description',
                'top_rated',
                'banner_title'
            ])
            ->where('status', true)
            ->where('top_rated', true)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }
}
