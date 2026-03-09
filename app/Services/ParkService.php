<?php

namespace App\Services;

use App\Contracts\Repositories\ParkRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ParkService
{

    protected ParkRepositoryInterface $parkRepository;

    protected string $baseUrl;


    public function __construct(ParkRepositoryInterface $parkRepository)
    {
        $this->parkRepository = $parkRepository;
        $this->baseUrl = rtrim(env('APP_URL'), '/');
    }


    public function getTopRatedParks(int $perPage = 10): LengthAwarePaginator
    {
        $parks = $this->parkRepository->getTopRatedParks($perPage);

        $parks->getCollection()->transform(function ($park) {
            return $this->transformParkData($park);
        });

        return $parks;
    }


    protected function transformParkData($park)
    {

        if ($park->display_image) {
            $park->display_image = $this->baseUrl . '/' . $park->display_image;
        }

        $park->park_safari_types = $park->parkSafariTypes->map(function ($item) {
            return [
                'id' => $item->park_safari_type_id,
                'type' => $item->safari_type->name ?? null,
            ];
        });

        $park->park_best_times = $park->parkBestTimes->map(function ($item) {
            return [
                'id' => $item->park_best_time_id,
                'weather' => $item->weather->title ?? null,
            ];
        });

        $park->species_list = $park->wildlife->map(function ($wildlife) {
            return [
                'id' => $wildlife->species->species_id ?? null,
                'name' => $wildlife->species->name ?? null,
            ];
        })->filter(function ($species) {
            return !is_null($species['id']);
        })->values();

       
        unset($park->parkSafariTypes, $park->parkBestTimes, $park->wildlife);

        return $park;
    }
}
