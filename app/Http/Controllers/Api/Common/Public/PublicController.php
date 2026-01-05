<?php

namespace App\Http\Controllers\Api\Common\Public;

use App\Http\Controllers\Api\BaseController;
use App\Models\City;
use App\Models\Country;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Park;
use App\Models\ParkSpecies;
use App\Models\ShareSafari;
use App\Models\Species;
use App\Models\State;
use App\Models\StayCategory;
use App\Models\VisitPurpose;
use App\Models\WeatherModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicController extends BaseController
{
    private function getRandomRecords($model, $limit = 6)
    {
        return $model::inRandomOrder()->limit($limit)->get();
    }

    public function getCountry(Request $request)
    {

        $name = $request->name;
        if ($name) {
            $countries = Country::select('country_id','sortname','name')->where('name', 'like', '%' . $name . '%')->get();
        } else {
            $countries = Country::select('country_id','sortname','name')->get();
        }

        if ($countries->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No countries found.',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $countries,
        ], 200);
    }

    public function State(Request $request)
    {

         $validator = Validator::make(
            $request->all(),
            [
                'country_id' => 'required|integer|exists:countries,country_id',
                'name' => 'nullable|string',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => [],
            ], 200);
        }

        $countryId = $request->input('country_id');
        $name = $request->input('name');


        $query = State::select('state_id','name','country_id')->where('country_id', $countryId);

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        $states = $query->get();

        if ($states->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No states found for this country with the given country.',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $states,
        ], 200);
    }

    public function city(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'state_id' => 'required|integer|exists:states,state_id',
                'name' => 'nullable|string',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => [],
            ], 200);
        }

        $stateId = $request->input('state_id');
        $name = $request->input('name');


        $query = City::select('city_id','name','state_id')->where('state_id', $stateId);

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        $Cities = $query->get();

        if ($Cities->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No Cities found for this state with the given state.',
                'data' => [],
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => $Cities,
        ], 200);
    }


    public function getState()
    {
        $park = park::where('status', true)->get();
        $stateIds = $park->pluck('state.id')->filter()->unique()->values();
        $states = State::whereIn('state_id', $stateIds)->select('state_id', 'name')->get();

        if (empty($states)) {
            return response()->json([
                'success' => false,
                'message' => 'No Data found.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data found.',
            'data' => $states,
        ], 200);
    }
    public function getParks()
    {
        $parks = Park::classwhere('status', true)->get();
        return response()->json([
            'success' => true,
            'data' => $parks,
        ], 200);
    }
    public function getStayCategory()
    {
        $stayCategory = StayCategory::select('stay_category_id','name')->get();
        return response()->json([
            'success' => true,
            'data' => $stayCategory,
        ], 200);
    }
    
    public function getNationalParks()
    {
        $baseUrl = env('APP_URL');
        $parks = Park::where('status', true)->select('name', 'park_id', 'display_image')->get();

        if ($parks->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No national parks found.',
                'data' => []
            ], 404);
        }

        $parks->each(function ($park) use ($baseUrl) {
            if ($park->display_image) {
                $park->display_image = rtrim($baseUrl, '/') . '/' . ltrim($park->display_image, '/');
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'National parks retrieved successfully.',
            'data' => $parks
        ], 200);
    }

    public function getBestTimetoVisit()
    {
        $weather = WeatherModel::select('park_weather_id','title')->where('status', 1)->get();

        if ($weather->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No best time to visit data found.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Best time to visit data retrieved successfully.',
            'data' => $weather
        ], 200);
    }

    public function getInclusions()
    {
        $inclusions = Feature::select('features_id','title')->where('type', 1)->get();

        if ($inclusions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No inclusions found.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Inclusions retrieved successfully.',
            'data' => $inclusions
        ], 200);
    }

    public function getThemes()
    {
        $themes = VisitPurpose::select('visit_purpose_id','name')->get();

        if ($themes->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No themes found.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Themes retrieved successfully.',
            'data' => $themes
        ], 200);
    }

    public function getSafariBudget()
    {
        $package = Package::with('park.state')->where('status', 1)->get();
        $lowestPrice  = $package->min('min_price_pp');
        $highestPrice = $package->max('max_price_pp');
        return response()->json([
            'success' => true,
            'data' => [
                'min_price' => $lowestPrice,
                'max_price' => $highestPrice
            ]
        ], 200);
    }
    
    
    public function getFilterData(Request $request)
    {
        try {
            $type = $request->query('type');
    
            if ($type == 'package') {
                $packages = Package::with('park.state')->where('status', 1)->get();
    
                if ($packages->isEmpty()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'No package data found.',
                        'data' => []
                    ], 200);
                }
    
                $lowestPrice = $packages->min('min_price_pp');
                $highestPrice = $packages->max('max_price_pp');
    
                $stateIds = $packages->pluck('park.state.state_id')->filter()->unique();
                $parkIds = $packages->pluck('park_id')->filter()->unique();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Package filter data retrieved successfully.',
                    'data' => [
                        'lowestPrice' => $lowestPrice,
                        'highestPrice' => $highestPrice,
                        'states' => State::whereIn('state_id', $stateIds)->pluck('name', 'state_id'),
                        'parks' => Park::whereIn('park_id', $parkIds)->pluck('name', 'park_id'),
                        'stayCategory' => StayCategory::pluck('name', 'stay_category_id'),
                        'bttv_list' => WeatherModel::where('status', 1)->get(),
                        'inclusions' => Feature::where('type', 1)->pluck('title', 'features_id'),
                        'visitPurposes' => VisitPurpose::pluck('name', 'visit_purpose_id'),
                        'species' => ParkSpecies::whereIn('park_id', $parkIds)
                            ->with('speciesList')
                            ->get()
                            ->pluck('speciesList.name', 'speciesList.species_id'),
                    ]
                ], 200);
    
            } elseif ($type == 'shared-safari') {
                $safaris = ShareSafari::with('park.state')->get();
    
                if ($safaris->isEmpty()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'No shared safari data found.',
                        'data' => []
                    ], 200);
                }
    
                $lowestPrice = $safaris->min('min_price_pp');
                $highestPrice = $safaris->max('max_price_pp');
                $lowestSafari = $safaris->min('no_of_safari');
                $highestSafari = $safaris->max('no_of_safari');
    
                $stateIds = $safaris->pluck('park.state.id')->filter()->unique();
                $parkIds = $safaris->pluck('safari_park_id')->filter()->unique();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Shared Safari filter data retrieved successfully.',
                    'data' => [
                        'lowestPrice' => $lowestPrice,
                        'highestPrice' => $highestPrice,
                        'lowestSafari' => $lowestSafari,
                        'highestSafari' => $highestSafari,
                        'states' => State::whereIn('state_id', $stateIds)->pluck('name', 'state_id'),
                        'parks' => Park::whereIn('park_id', $parkIds)->pluck('name', 'park_id'),
                        'stayCategory' => StayCategory::pluck('name', 'stay_category_id'),
                        'inclusions' => Feature::where('type', 1)->pluck('title', 'features_id'),
                        'visitPurposes' => VisitPurpose::pluck('name', 'visit_purpose_id'),
                        'species' => ParkSpecies::whereIn('park_id', $parkIds)
                            ->with('speciesList')
                            ->get()
                            ->pluck('speciesList.name', 'speciesList.id'),
                    ]
                ], 200);
    
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid type provided.',
                    'data' => []
                ], 200);
            }
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching filter data.',
                'error' => $e->getMessage()
            ], 200);
        }
    }


    public function getParkSpecies()
    {

        $parks = Park::where('status', true)->get();

        if ($parks->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No active parks found.',
                'data' => []
            ], 404);
        }

        $parkSpecies = ParkSpecies::with('speciesList')
            ->whereIn('park_id', $parks->pluck('id'))
            ->get();
        $species = $parkSpecies
            ->filter(fn($item) => $item->speciesList)
            ->map(fn($item) => [
                'id' => $item->speciesList->id,
                'name' => $item->speciesList->name
            ])
            ->unique('id')
            ->values()
            ->toArray();

        if (empty($species)) {
            return response()->json([
                'success' => false,
                'message' => 'No species found for the active parks.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Park species data retrieved successfully.',
            'data' => $species
        ], 200);
    }
}
