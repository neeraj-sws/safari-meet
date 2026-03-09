<?php

namespace App\Http\Controllers\Api\Common\Public;

use App\Http\Controllers\Api\BaseController;
use App\Models\{Park, ParkAboutSection, ParkAccommodation, ParkBestTimeVistModel, ParkDetailsDynamicTabs, ParkInformationModel, ParkKeyInfoModel, ParkReachability, ParkSafariTime, ParkSpecies, ParkTraveltipsModel, ParkWhatToCarryModel, ParkZoneModel, State};
use Illuminate\Http\Request;

class ParkController extends BaseController
{

    public function getParks(Request $request)
    {
        $baseUrl = env('APP_URL');
        //   GET /api/parks?state_id=3&species_id=5&?weather_ids=2,3,4

        $query = Park::with([
            'country:country_id,name',
            'state:state_id,name',
            'city:city_id,name',
            'parkSafariTypes:park_safari_type_id,park_id,safari_type_id',
            'parkSafariTypes.safari_type:safari_type_id,name',
            'parkBestTimes:park_best_time_id,park_id,weathers_id',
            'parkBestTimes.weather:park_weather_id,title',
<<<<<<< HEAD
            'wildlife.species'
        ])
            ->select('park_id', 'name', 'slug', 'short_description', 'city_id', 'state_id', 'country_id', 'display_image', 'famous_for', 'meta_title', 'meta_description', 'top_rated', 'top_safari', 'banner_title', 'popular', 'trending');
=======
        ])
            ->select('park_id', 'name', 'slug', 'short_description', 'city_id', 'state_id', 'country_id', 'display_image', 'famous_for');
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b


        if ($request->has('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->has('species_id')) {
            $query->whereHas('parkspecies', function ($q) use ($request) {
                $q->where('species_id', $request->species_id);
            });
        }

        if ($request->has('park_id')) {
            $query->where('park_id', $request->park_id);
        }

        if ($request->has('stay_category_id')) {
            $query->where('stay_category_id', $request->stay_category_id);
        }

        if ($request->has('weather_ids')) {
            $weatherIds = is_array($request->weather_ids)
                ? $request->weather_ids
                : explode(',', trim($request->weather_ids));

            $query->whereHas('parkBestTimes', function ($q) use ($weatherIds) {
                $q->whereIn('weathers_id', $weatherIds);
            });
        }

<<<<<<< HEAD
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'popular':
                    $query->where('popular', true);
                    break;

                case 'trending':
                    $query->where('trending', true);
                    break;

                case 'top-rated':
                    $query->where('top_rated', true);
                    break;

                case 'latest':
                    $query->orderBy('created_at', 'DESC');
                    break;
            }
        }

=======
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        $parks = $query->where('status', true)->paginate(10);

        $parks->getCollection()->transform(function ($park) use ($baseUrl) {
            if ($park->display_image) {
                $park->display_image = rtrim($baseUrl, '/') . '/'  . $park->display_image;
            }
<<<<<<< HEAD

            // Optimize park_safari_types
=======
            
                     // Optimize park_safari_types
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            $park->park_safari_types = $park->parkSafariTypes->map(function ($item) {
                return [
                    'id' => $item->park_safari_type_id,
                    'type' => $item->safari_type->name ?? null,
                ];
            });
<<<<<<< HEAD

=======
        
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            // Optimize park_best_times
            $park->park_best_times = $park->parkBestTimes->map(function ($item) {
                return [
                    'id' => $item->park_best_time_id,
                    'weather' => $item->weather->title ?? null,
                ];
            });
<<<<<<< HEAD

            // Wildlife Found
            $park->wildlife_found = $park->wildlife->map(function ($wildlife) {
                return
                    ucfirst($wildlife->species?->name);
            });

=======
        
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            unset($park->parkSafariTypes);
            unset($park->parkBestTimes);
            return $park;
        });

        return response()->json([
            'success' => true,
            'message' => $parks->isEmpty() ? 'No active parks found.' : 'Parks retrieved successfully.',
            'data' => $parks->items(),
            'pagination' => [
                'total' => $parks->total(),
                'current_page' => $parks->currentPage(),
                'last_page' => $parks->lastPage(),
                'per_page' => $parks->perPage(),
                'next_page_url' => $parks->nextPageUrl(),
                'previous_page_url' => $parks->previousPageUrl(),
            ]
        ], 200);
    }

    public function getSearchParks(Request $request)
    {
        $baseUrl = env('APP_URL');

        $query = Park::select('park_id', 'name', 'slug', 'short_description',  'display_image');
        //GET /api/parks?park_name=kanha

        if ($request->has('park_name')) {
            $query->where('name', 'LIKE', '%' . $request->park_name . '%');
        }

        $parks = $query->where('status', true)->paginate(10);

        $parks->getCollection()->transform(function ($park) use ($baseUrl) {
            if ($park->display_image) {
                $park->display_image = rtrim($baseUrl, '/') . '/' . $park->display_image;
            }
            return $park;
        });

        return response()->json([
            'success' => true,
            'message' => $parks->isEmpty() ? 'No active parks found.' : 'Parks retrieved successfully.',
            'data' => $parks->items(),
            'pagination' => [
                'total' => $parks->total(),
                'current_page' => $parks->currentPage(),
                'last_page' => $parks->lastPage(),
                'per_page' => $parks->perPage(),
                'next_page_url' => $parks->nextPageUrl(),
                'previous_page_url' => $parks->previousPageUrl(),
            ]
        ], 200);
    }

    public function getParkDetails($slug)
    {
        $baseUrl = env('APP_URL');

        if (empty($slug)) {
            return response()->json([
                'success' => false,
                'message' => 'Slug parameter is required.',
                'data' => null
            ], 200);
        }

        $parkDetails = Park::with(['DetailsCharacterstic' => function ($query) {
<<<<<<< HEAD
            $query->select('park_details_tabs_id', 'park_tabs_id', 'park_id', 'title', 'status')->where('status', 1);
=======
            $query->select('park_details_tabs_id','park_tabs_id','park_id','title','status')->where('status', 1);
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        }])->where('slug', $slug)->first();

        if (!$parkDetails) {
            return response()->json([
                'success' => false,
                'message' => 'Park not found.',
                'data' => null
            ], 200);
        }

        $parkDetails->share_link = route('park.detail', ['slug' => $parkDetails->slug]);

        if ($parkDetails->display_image) {
            if (filter_var($parkDetails->display_image, FILTER_VALIDATE_URL) === false) {
                $parkDetails->display_image = $baseUrl . '/' . ltrim($parkDetails->display_image, '/');
            }
        }

        if ($parkDetails->banner_image) {
            if (filter_var($parkDetails->banner_image, FILTER_VALIDATE_URL) === false) {
                $parkDetails->banner_image = $baseUrl . '/' . ltrim($parkDetails->banner_image, '/');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Park data found.',
            'data' => $parkDetails,
        ], 200);
    }

    public function getParkTabsDetails(Request $request)
    {
        if (!$request->has('park_id') || !$request->has('park_tabs_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Missing park_id or characteristic_id',
                'data' => null,
            ], 400);
        }

        $parkId = $request->park_id;
        $charactersticId = $request->park_tabs_id;


        $parkExists = Park::find($parkId);
        if (!$parkExists) {
            return response()->json([
                'success' => false,
                'message' => 'Park not found.',
                'data' => null,
            ], 404);
        }

<<<<<<< HEAD
        $perPage =  $request->per_page;
=======
         $perPage =  $request->per_page;
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        $page =  $request->page;
        $responseData = $this->getSpeciesDataByTitle($charactersticId, $parkId, $perPage, $page);

        if (empty($responseData) || (is_array($responseData) && empty($responseData))) {
            return response()->json([
                'success' => false,
                'message' => 'No data found for the given park_id and characteristic_id',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data found.',
            'data' => $responseData,
        ], 200);
    }

    private function getSpeciesDataByTitle($characterstic_id, $park_id, $perPage = null, $page = null)
    {
        switch ($characterstic_id) {
            case '1':
                return $this->getKeyIData($park_id);
            case '2':
                return $this->getParkAboutSectionIData($park_id);
            case '3':
                return $this->getSafariInformationData($park_id);
            case '4':
<<<<<<< HEAD
                return $this->getAccommodationData($park_id, $perPage, $page);
=======
                return $this->getAccommodationData($park_id,$perPage, $page);
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            case '5':
                return $this->getWildLifeYouMaySeeData($park_id);
            case '6':
                return $this->getParkReachabilityData($park_id);
            case '7':
                return $this->getTraveltipsData($park_id);
            default:
                return $this->getDynamicData($characterstic_id, $park_id);
        }
    }

    private function getKeyIData($park_id)
    {
        $baseUrl = env('APP_URL');
        $park = Park::find($park_id);

        if (!$park) {
            return null;
        }
        $parkKeyInfo = ParkKeyInfoModel::where('park_id', $park_id)->first();

        if ($parkKeyInfo->overview_image) {
            if (filter_var($parkKeyInfo->overview_image, FILTER_VALIDATE_URL) === false) {
                $parkKeyInfo->overview_image = $baseUrl . '/' . ltrim($parkKeyInfo->overview_image, '/');
            }
        }
        if ($parkKeyInfo->travel_info_image) {
            if (filter_var($parkKeyInfo->travel_info_image, FILTER_VALIDATE_URL) === false) {
                $parkKeyInfo->travel_info_image = $baseUrl . '/' . ltrim($parkKeyInfo->travel_info_image, '/');
            }
        }
        if ($parkKeyInfo->timing_cost_image) {
            if (filter_var($parkKeyInfo->timing_cost_image, FILTER_VALIDATE_URL) === false) {
                $parkKeyInfo->timing_cost_image = $baseUrl . '/' . ltrim($parkKeyInfo->timing_cost_image, '/');
            }
        }

        return [
            'park_key_info' => $parkKeyInfo,
        ];
    }

    private function getParkAboutSectionIData($park_id)
    {
        $baseUrl = env('APP_URL');
<<<<<<< HEAD
        $aboutSections = ParkAboutSection::select('title', 'short_description','image')->where('park_id', $park_id)->get();
=======
        $aboutSections = ParkAboutSection::select('title','short_description')->where('park_id', $park_id)->get();
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b

        foreach ($aboutSections as $section) {
            if (!empty($section->image)) {
                if (filter_var($section->image, FILTER_VALIDATE_URL) === false) {
                    $section->image = $baseUrl . '/' . ltrim($section->image, '/');
                }
            }
        }

        return $aboutSections->isEmpty() ? [] : $aboutSections;
    }
<<<<<<< HEAD

    private function getAccommodationData($park_id, $perPage, $page)
=======
    
    private function getAccommodationData($park_id,$perPage, $page)
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    {
        $perPage = empty($perPage) ? 10 : $perPage;

        $accommodations = ParkAccommodation::where('park_id', $park_id)
            ->paginate($perPage);


<<<<<<< HEAD
        if (!empty($accommodations)) {
=======
         if (!empty($accommodations)) {
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            return [
                'accommodations' => $accommodations->items(),
                'pagination' => [
                    'total' => $accommodations->total(),
                    'count' => $accommodations->count(),
                    'per_page' => $accommodations->perPage(),
                    'current_page' => $accommodations->currentPage(),
                    'last_page' => $accommodations->lastPage(),
                    'next_page_url' => $accommodations->nextPageUrl(),
                    'prev_page_url' => $accommodations->previousPageUrl(),
                ]
            ];
        } else {
            return [
                'accommodations' => [],
            ];
        }
    }

    private function getSafariInformationData($park_id)
    {
        $baseUrl = env('APP_URL');
        $safariInformation = ParkInformationModel::where('park_id', $park_id)->first();

        if ($safariInformation) {
            if (!empty($safariInformation->dos_image)) {
                if (filter_var($safariInformation->dos_image, FILTER_VALIDATE_URL) === false) {
                    $safariInformation->dos_image = $baseUrl . '/' . ltrim($safariInformation->dos_image, '/');
                }
            }

            if (!empty($safariInformation->donts_image)) {
                if (filter_var($safariInformation->donts_image, FILTER_VALIDATE_URL) === false) {
                    $safariInformation->donts_image = $baseUrl . '/' . ltrim($safariInformation->donts_image, '/');
                }
            }
        }

        $parkZones = ParkZoneModel::where('park_id', $park_id)
            ->get()
            ->map(function ($zone) {
                return collect($zone)->except(['created_at', 'updated_at', 'park_id']);
            });
<<<<<<< HEAD

=======
        
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        $parkTimings = ParkSafariTime::with(['details', 'weather'])
            ->where('park_id', $park_id)
            ->get()
            ->map(function ($timing) {
                // Remove unneeded fields from main timing
                $timingData = collect($timing)->except([
<<<<<<< HEAD
                    'created_at',
                    'updated_at',
                    'park_id',
                    'weather_id',
                    'start',
                    'end'
                ]);

                // Clean up details
                $timingData['details'] = collect($timing->details)->map(function ($detail) {
                    return collect($detail)->except([
                        'created_at',
                        'updated_at',
                        'park_safari_time_id'
                    ]);
                });

                // Clean up weather
                if ($timing->weather) {
                    $timingData['weather'] = collect($timing->weather)->except([
                        'created_at',
                        'updated_at',
                        'start',
                        'end',
                        'status'
                    ]);
                }

=======
                    'created_at', 'updated_at', 'park_id', 'weather_id', 'start', 'end'
                ]);
        
                // Clean up details
                $timingData['details'] = collect($timing->details)->map(function ($detail) {
                    return collect($detail)->except([
                        'created_at', 'updated_at', 'park_safari_time_id'
                    ]);
                });
        
                // Clean up weather
                if ($timing->weather) {
                    $timingData['weather'] = collect($timing->weather)->except([
                        'created_at', 'updated_at', 'start', 'end', 'status'
                    ]);
                }
        
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
                return $timingData;
            });



        return [
            'safariInformation' => $safariInformation,
            'parkZones' => $parkZones,
            'parkTimings' => $parkTimings,
        ];
    }

    private function getWildLifeYouMaySeeData($park_id)
    {
        $baseUrl = env('APP_URL');

        $parkSpecies = ParkSpecies::with('speciesList')
            ->where('park_id', $park_id)
            ->paginate(10);


        foreach ($parkSpecies as $species) {
            if (!empty($species->speciesList)) {
                if (!empty($species->speciesList->display_image) && filter_var($species->speciesList->display_image, FILTER_VALIDATE_URL) === false) {
                    $species->speciesList->display_image = $baseUrl . '/' . ltrim($species->speciesList->display_image, '/');
                }
                if (!empty($species->speciesList->banner_image) && filter_var($species->speciesList->banner_image, FILTER_VALIDATE_URL) === false) {
                    $species->speciesList->banner_image = $baseUrl . '/' . ltrim($species->speciesList->banner_image, '/');
                }
            }
        }

        return [
            'data' => $parkSpecies->items(),
            'pagination' => [
                'total' => $parkSpecies->total(),
                'current_page' => $parkSpecies->currentPage(),
                'last_page' => $parkSpecies->lastPage(),
                'per_page' => $parkSpecies->perPage(),
                'next_page_url' => $parkSpecies->nextPageUrl(),
                'previous_page_url' => $parkSpecies->previousPageUrl(),
            ],
            'message' => $parkSpecies->isEmpty() ? 'No wildlife data found.' : 'Wildlife data retrieved successfully.'
        ];
    }


<<<<<<< HEAD
    private function getParkReachabilityData($park_id)
    {
        $baseUrl = env('APP_URL');

        $howToReach = ParkReachability::with(['reachabilityDistance.cityData', 'reachability'])
            ->where('park_id', $park_id)
            ->get();

        $howToReachArray = [];
        $headings = [];
        $cityData = [];

=======
     private function getParkReachabilityData($park_id)
    {
        $baseUrl = env('APP_URL');
    
        $howToReach = ParkReachability::with(['reachabilityDistance.cityData', 'reachability'])
            ->where('park_id', $park_id)
            ->get();
    
        $howToReachArray = [];
        $headings = [];
        $cityData = [];
    
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        foreach ($howToReach as $reach) {

            if (!empty($reach->reachability) && !empty($reach->reachability->display_image)) {
                $displayImage = $reach->reachability->display_image;
<<<<<<< HEAD

                if (filter_var($displayImage, FILTER_VALIDATE_URL) === false) {
                    $displayImage = rtrim($baseUrl, '/') . '/' . ltrim($displayImage, '/');
                }

=======
    
                if (filter_var($displayImage, FILTER_VALIDATE_URL) === false) {
                    $displayImage = rtrim($baseUrl, '/') . '/' . ltrim($displayImage, '/');
                }
    
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
                $howToReachArray[] = [
                    'title' => $reach->title ?? '',
                    'description' => $reach->description ?? '',
                    'heading' => $reach->heading ?? '',
                    'display_image' => $displayImage,
                ];
<<<<<<< HEAD

                $heading = $reach->heading ?? 'Unknown';

                if (!in_array($heading, $headings)) {
                    $headings[] = $heading;
                }

                if (!empty($reach->reachabilityDistance)) {
                    foreach ($reach->reachabilityDistance as $distanceEntry) {
                        $cityName = $distanceEntry->cityData->name ?? 'Unknown';

=======
    
                $heading = $reach->heading ?? 'Unknown';
    
                if (!in_array($heading, $headings)) {
                    $headings[] = $heading;
                }
    
                if (!empty($reach->reachabilityDistance)) {
                    foreach ($reach->reachabilityDistance as $distanceEntry) {
                        $cityName = $distanceEntry->cityData->name ?? 'Unknown';
    
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
                        if (!isset($cityData[$cityName])) {
                            $cityData[$cityName] = [
                                'From' => $cityName
                            ];
                        }
<<<<<<< HEAD

=======
    
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
                        $cityData[$cityName][$heading] = $distanceEntry->distance ?? 'N/A';
                    }
                }
            }
        }
<<<<<<< HEAD

=======
    
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        foreach ($cityData as $cityName => &$row) {
            foreach ($headings as $heading) {
                if (!isset($row[$heading])) {
                    $row[$heading] = 'N/A';
                }
            }
        }
<<<<<<< HEAD

        return [
            'HowtoReach' => $howToReachArray,
            'columns' => array_merge(['From'], $headings),
            'rows' => array_values($cityData)
=======
    
        return [
            'HowtoReach' => $howToReachArray,  
            'columns' => array_merge(['From'], $headings), 
            'rows' => array_values($cityData) 
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ];
    }


<<<<<<< HEAD
    private function getTraveltipsData($park_id)
=======
   private function getTraveltipsData($park_id)
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    {
        $baseUrl = env('APP_URL');

        $bestTimeToVisit = ParkBestTimeVistModel::where('park_id', $park_id)->get();
        $travelTips = ParkTraveltipsModel::where('park_id', $park_id)->first();
        $whatToCarry = ParkWhatToCarryModel::where('park_id', $park_id)->get();

        $bestTimeArray = $bestTimeToVisit->map(function ($item) {
            return [
                'heading' => $item->heading,
                'description' => $item->description,
            ];
        });

        $tips = $travelTips ? [
            'weather' => $travelTips->weather,
            'safetyTips' => $travelTips->safetyTips,
        ] : null;


        $carryItems = $whatToCarry->map(function ($item) use ($baseUrl) {
            return [
                'heading' => $item->heading,
                'short_description' => $item->short_description,
                'image' => filter_var($item->image, FILTER_VALIDATE_URL)
                    ? $item->image
                    : rtrim($baseUrl, '/') . '/' . ltrim($item->image, '/'),
            ];
        });

        return [
            'bestTimeToVisit' => $bestTimeArray,
            'travelTips' => $tips,
            'whatToCarry' => $carryItems,
        ];
    }

    private function getDynamicData($characterstic_id, $park_id)
    {
        $tabData = ParkDetailsDynamicTabs::where('park_id', $park_id)
            ->where('park_details_characterstics_id', $characterstic_id)
            ->first();
        return $tabData ?? null;
    }

    public function getParkStates()
    {
        try {
            $park = Park::where('status', true)->get();
            if ($park->isEmpty()) return $this->errorResponse('No active parks found.');
            $stateIds = $park->pluck('state.state_id')->filter()->unique()->values();
            if ($stateIds->isEmpty()) return $this->errorResponse('No valid state IDs found for the active parks.');
            $states = State::whereIn('state_id', $stateIds)->select('name', 'state_id')->get();
            if ($states->isEmpty()) return $this->errorResponse('No states found for the given state IDs.');
            return response()->json([
                'success' => true,
                'message' => 'States found successfully.',
                'data' => $states,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
<<<<<<< HEAD

=======
    
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    public function getParkSpecies()
    {
        try {
            $parks = Park::where('status', true)->get();
<<<<<<< HEAD

            if ($parks->isEmpty()) {
                return $this->errorResponse('No active parks found.');
            }

=======
    
            if ($parks->isEmpty()) {
                return $this->errorResponse('No active parks found.');
            }
    
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            // Get all species for those parks
            $parkSpecies = ParkSpecies::with('speciesList:species_id,name')
                ->select('species_id')
                ->whereIn('park_id', $parks->pluck('park_id'))
                ->get();
<<<<<<< HEAD

            if ($parkSpecies->isEmpty()) {
                return $this->errorResponse('No Species found.');
            }

            // Filter unique species based on species_id
            $uniqueSpecies = $parkSpecies->pluck('speciesList')->unique('species_id')->values();

=======
    
            if ($parkSpecies->isEmpty()) {
                return $this->errorResponse('No Species found.');
            }
    
            // Filter unique species based on species_id
            $uniqueSpecies = $parkSpecies->pluck('speciesList')->unique('species_id')->values();
    
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            return response()->json([
                'success' => true,
                'message' => 'Species found successfully.',
                'data' => $uniqueSpecies,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function errorResponse($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => [],
        ], 404);
    }
}
