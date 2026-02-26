<?php

namespace App\Http\Controllers\Api\Common\Public;

use App\Http\Controllers\Api\BaseController;
use App\Services\ParkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TopRatedParksController extends BaseController
{

    protected ParkService $parkService;

    public function __construct(ParkService $parkService)
    {
        $this->parkService = $parkService;
    }
    public function index(Request $request): JsonResponse
    {
        try {

            $perPage = $request->input('per_page', 10);

            if (!is_numeric($perPage) || $perPage < 1 || $perPage > 100) {
                return $this->sendError(
                    'Invalid per_page parameter',
                    ['per_page' => ['Must be a number between 1 and 100']],
                    422
                );
            }

            $parks = $this->parkService->getTopRatedParks((int) $perPage);

            return $this->sendResponse(
                $parks,
                'Top rated parks retrieved successfully'
            );

        } catch (\Exception $e) {

            \Log::error('Error fetching top rated parks: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);


            return $this->sendError(
                'Failed to retrieve top rated parks',
                ['error' => $e->getMessage()],
                500
            );
        }
    }
}
