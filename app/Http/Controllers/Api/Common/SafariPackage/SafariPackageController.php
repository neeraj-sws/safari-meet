<?php

namespace App\Http\Controllers\Api\Common\SafariPackage;

use App\Http\Controllers\Api\BaseController;
use App\Models\FeaturePackageSafari;
use App\Models\FeatureThingsToCarrySafari;
use App\Models\ItineraryPackage;
use App\Models\Package;
use App\Models\Park;
use App\Models\SafariAccommodation;
use App\Models\SafariDetailsDynamicTabs;
use App\Models\SafariDiscussion;
use App\Models\SafariFaq;
use App\Models\SafariRatingHeading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SafariPackageController extends BaseController
{
    public function getsafariPackage(Request $request)
    {
        $query = Package::select('package_id','title','slug','park_id','visit_purpose_id','stay_category_id','min_price_pp','max_price_pp','display_image','end_tour','start_tour','tour_highlights','no_of_safari')->with(
            'park:park_id,name,slug,short_description',
            'park.wildlife.species:species_id,name'
        );

        if ($request->stateSelect) {
            $query->whereHas('park.state', fn($q) => $q->where('id', $request->stateSelect));
        }
        if ($request->inclusion_select) {
            $query->whereHas('featuer_safaries', fn($q) => $q->whereIn('feature_id', $request->inclusion_select));
        }
        if ($request->parkSelect) {
            $query->where('park_id', $request->parkSelect);
        }
        if ($request->theme_select) {
            $query->whereIn('visit_purpose_id', $request->theme_select);
        }
        if ($request->bttv_selected) {
            $query->whereIn('best_time', $request->bttv_selected);
        }
        if ($request->speciesSelected) {
            $parkIDs = Park::whereHas('ParkSpecies', fn($q) => $q->where('species_id', $request->speciesSelected))
                ->pluck('id');
            $query->whereIn('park_id', $parkIDs);
        }
        if ($request->selectedStayCategories) {
            $query->whereIn('stay_category_id', $request->selectedStayCategories);
        }
        if (is_numeric($request->minPrice) && is_numeric($request->maxPrice)) {
            $query->whereRaw('CAST(min_price_pp AS UNSIGNED) <= ?', [$request->maxPrice])
                ->whereRaw('CAST(max_price_pp AS UNSIGNED) >= ?', [$request->minPrice]);
        }
        if (is_numeric($request->minday) && is_numeric($request->maxday)) {
            $query->whereRaw('CAST(start_tour AS UNSIGNED) <= ?', [$request->maxday])
                ->whereRaw('CAST(start_tour AS UNSIGNED) >= ?', [$request->minday]);
        }
        if (is_numeric($request->minSafari) && is_numeric($request->maxSafari)) {
            $query->whereRaw('CAST(no_of_safari AS UNSIGNED) <= ?', [$request->maxSafari])
                ->whereRaw('CAST(no_of_safari AS UNSIGNED) >= ?', [$request->minSafari]);
        }
        if (!empty($request->orderbyfilter)) {
            switch ($request->orderbyfilter) {
                case 'popular':
                    $query->orderBy('popular', 'DESC');
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'DESC');
                    break;
                case 'trending':
                    $query->orderBy('trending', 'DESC');
                    break;
                case 'top':
                    $query->orderBy('top_rated', 'DESC');
                    break;
            }
        }

        $perPage = $request->get('perPage', 10);
        $packages = $query->where('status', 1)->paginate($perPage);

        $baseUrl = env('APP_URL');

        $data = collect($packages->items())->map(function ($package) use ($baseUrl) {

            $package->display_image = $package->display_image && !preg_match('/^https?:\/\//', $package->display_image)
                ? $baseUrl . '/' . ltrim($package->display_image, '/')
                : $package->display_image;

            if (isset($package->park) && isset($package->park->wildlife) && is_iterable($package->park->wildlife)) {
                foreach ($package->park->wildlife as $wildlife) {
                    if (isset($wildlife->species)) {
                        $wildlife->species->display_image = $wildlife->species->display_image && !preg_match('/^https?:\/\//', $wildlife->species->display_image)
                            ? $baseUrl . '/' . ltrim($wildlife->species->display_image, '/')
                            : $wildlife->species->display_image;

                        $wildlife->species->banner_image = $wildlife->species->banner_image && !preg_match('/^https?:\/\//', $wildlife->species->banner_image)
                            ? $baseUrl . '/' . ltrim($wildlife->species->banner_image, '/')
                            : $wildlife->species->banner_image;
                    }
                }
            }


            return $package;
        });

        return response()->json([
            'data' => $data,
            'current_page' => $packages->currentPage(),
            'last_page' => $packages->lastPage(),
            'total' => $packages->total(),
        ]);
    }

    public function getSafariPackageDetails(Request $request)
    {
        $package = Package::select('package_id','title','slug','park_id','visit_purpose_id','stay_category_id','min_price_pp','max_price_pp','display_image','end_tour','start_tour','tour_highlights','no_of_safari')->with([
        'park:park_id,name',
        'detailsTabs' => function ($query) {
        $query->where('status', 1); // Exclude specific tabs
            }
        ])->where('slug', $request->slug)->first();


        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found',
            ], 404);
        }


        $baseUrl = env('APP_URL');


        if (!empty($package->display_image) && filter_var($package->display_image, FILTER_VALIDATE_URL) === false) {

            $package->display_image = rtrim($baseUrl, '/') . '/' . ltrim($package->display_image, '/');
        }

        return response()->json([
            'success' => true,
            'data' => $package,
        ], 200);
    }

    public function getSafariPackageTabsDetails(Request $request)
    {
        if (!$request->has('package_id') || !$request->has('characterstic_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Missing package_id or characteristic_id',
                'data' => null,
            ], 400);
        }

        $packageId = $request->package_id;
        $charactersticId = $request->characterstic_id;


        $packageExists = Package::find($packageId);
        if (!$packageExists) {
            return response()->json([
                'success' => false,
                'message' => 'Safari Package not found.',
                'data' => null,
            ], 404);
        }

        $responseData = $this->getPackagesDataByTitle($charactersticId, $packageId);

        if (empty($responseData) || (is_array($responseData) && empty($responseData))) {
            return response()->json([
                'success' => false,
                'message' => 'No data found for the given package_id and characteristic_id',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data found.',
            'data' => $responseData,
        ], 200);
    }

    private function getPackagesDataByTitle($characterstic_id, $package_id)
    {
        switch ($characterstic_id) {
            case '2':
                return $this->getItineraryData($package_id);
            case '3':
                return $this->getInclusionsData($package_id);
            case '4':
                return $this->getExclusionsData($package_id);
            case '5':
                return $this->getAccommodationData($package_id);
            case '6':
                return $this->getRateData($package_id);
            case '7':
                return $this->getThingsToCarryData($package_id);
            case '8':
                return $this->getFAQData($package_id);
            case '9':
                return $this->getDiscussionData($package_id);
            default:
                return $this->getDynamicData($characterstic_id, $package_id);
        }
    }

    private function getItineraryData($package_id)
    {

        $ItineraryPackage = ItineraryPackage::with('packageActivities')->where('package_id', $package_id)->get();
        
            $result = $ItineraryPackage->map(function($item) {
                return [
                    'title' => $item->short_description,
                    'short_dec' => $item->packageActivities->pluck('activity'),
                ];
            });

         return $result ?? [];
    
    }

    private function getInclusionsData($package_id)
    {

        $InclusionsData = FeaturePackageSafari::select('icon','title')->where('package_id', $package_id)->where('type', 1)->get();

        return $InclusionsData ?? [];
    }
    private function getExclusionsData($package_id)
    {

        $ExclusionsData = FeaturePackageSafari::select('icon','title')->where('package_id', $package_id)->where('type', 2)->get();

        return $ExclusionsData ?? [];
    }

 private function getAccommodationData($package_id)
    {
        $accommodationData = SafariAccommodation::with([
            'accommodation',
            'accommodation.amenity.amenity',
            'accommodation.image',
            'accommodation.category',
            'accommodation.cuntry',
            'accommodation.state',
            'accommodation.city',
        ])->where('package_id', $package_id)->first();
 
        if (!$accommodationData) {
            return null;
        }
 
        $baseUrl = env('APP_URL');
 
        $accommodation = $accommodationData->accommodation;
 
        $images = [];
        if (!empty($accommodation->image)) {
            foreach ($accommodation->image as $image) {
                $imgUrl = $image->image;
                if (!empty($imgUrl) && filter_var($imgUrl, FILTER_VALIDATE_URL) === false) {
                    $imgUrl = rtrim($baseUrl, '/') . '/' . ltrim($imgUrl, '/');
                }
                $images[] = $imgUrl;
            }
        }
 
        $amenities = [];
        if (!empty($accommodation->amenity)) {
            foreach ($accommodation->amenity as $accAmenity) {
                if (!empty($accAmenity->amenity)) {
                    $amenities[] = [
                        'id' => $accAmenity->amenity->id,
                        'title' => $accAmenity->amenity->title,
                        'icon' => $accAmenity->amenity->icon,
                    ];
                }
            }
        }
 
        $result = [
            'id' => $accommodationData->id,
            'package_id' => $accommodationData->package_id,
            'accommodation' => [
                'id' => $accommodation->id,
                'title' => $accommodation->title,
                'rating' => $accommodation->rating,
                'category' => [
                    'id' => $accommodation->category->id ?? null,
                    'name' => $accommodation->category->name ?? null,
                ],
                'country' => [
                    'id' => $accommodation->cuntry->id ?? null,
                    'name' => $accommodation->cuntry->name ?? null,
                ],
                'state' => [
                    'id' => $accommodation->state->id ?? null,
                    'name' => $accommodation->state->name ?? null,
                ],
                'city' => [
                    'id' => $accommodation->city->id ?? null,
                    'name' => $accommodation->city->name ?? null,
                ],
                'amenities' => $amenities,
                'images' => $images,
            ]
        ];
 
        return $result;
    }


        private function getRateData($package_id)
        {
            $headings = SafariRatingHeading::with('ratings.parkSafariTypes.safari_type')
                ->where('package_id', $package_id)
                ->get();
        
            // headings array
            $headingLabels = $headings->pluck('heading_label')->prepend('Safari Type')->values();
        
            // safari types with prices
            $safariData = [];
            foreach ($headings as $heading) {
                foreach ($heading->ratings as $rating) {
                    $safariType = optional($rating->parkSafariTypes->safari_type)->name;
                    if (!isset($safariData[$safariType])) {
                        $safariData[$safariType] = ['Safari Type' => $safariType];
                    }
                    $safariData[$safariType][$heading->heading_label] = (int) $rating->price;
                }
            }
        
            // convert to array format [ "Canter", 200, 2001, 2001 ]
            $finalData = collect($safariData)->map(function ($row) use ($headingLabels) {
                return $headingLabels->map(function ($heading) use ($row) {
                    return $row[$heading] ?? null;
                })->toArray();
            })->values();
        
        $responseData = $finalData;
        
        if ($package_id == 5) {
            // Wrap $finalData inside another 'data' key
            $responseData = [
                'data' => $finalData
            ];
        }
        
            return [
                'success'  => true,
                'message'  => $finalData->isNotEmpty() ? 'Data found.' : 'No data found.',
                'headings' => $headingLabels,
                'data'     => $responseData,
            ];
        }

 
 
    private function getThingsToCarryData($package_id)
    {

        $ThingsToCarry = FeatureThingsToCarrySafari::where('package_id', $package_id)->get();

        return $ThingsToCarry ?? [];
    }
    private function getFAQData($package_id)
    {

        $SafariFaq = SafariFaq::with([])->where('package_id', $package_id)->get();

        return $SafariFaq ?? [];
    }
    private function getDiscussionData($package_id)
    {

        $discussions = SafariDiscussion::with(['user', 'admin'])
            ->where('package_id', $package_id)->get();

        return $discussions ?? [];
    }

    public function DiscussionData(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'package_id' => 'required|exists:packages,id',
            'content'    => 'required|string',
            'parentId'   => 'nullable|exists:safari_discussion,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $discussion = SafariDiscussion::create([
            'package_id' => $request->package_id,
            'user_id'    => Auth::id() ?? 1,
            'content'    => $request->content,
            'is_admin'   => 0,
            'parent_id'  => $request->parentId ?? null,
        ]);

        $discussions = SafariDiscussion::with(['user', 'admin'])
            ->where('package_id', $request->package_id)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Discussion created successfully',
            'data' => $discussions,
        ], 201);
    }
    private function getDynamicData($characterstic_id, $package_id)
    {

        $tabData = SafariDetailsDynamicTabs::where('package_id', $package_id)
            ->where('package_details_tabs_id', $characterstic_id)
            ->first();

        return $tabData ?? null;
    }
}
