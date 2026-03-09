<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use App\Actions\Accommodation\GetAccommodationListAction;
use App\Http\Resources\AccommodationResource;

class AccommodationController extends Controller
{
    public function index(GetAccommodationListAction $action)
    {
        $accommodations = $action->execute();

        return response()->json([
            'status' => true,
            'data'   => AccommodationResource::collection($accommodations),
        ], 200);
    }
}
