<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface ParkRepositoryInterface
{
    public function getTopRatedParks(int $perPage = 10): LengthAwarePaginator;
}
