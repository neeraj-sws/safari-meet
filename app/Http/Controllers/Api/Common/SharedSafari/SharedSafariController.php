<?php

namespace App\Http\Controllers\Api\Common\SharedSafari;

use App\Helpers\ImageHelper;
use App\Helpers\SettingHelper;
use App\Helpers\UserHelper;
use App\Http\Controllers\Api\BaseController;
use App\Models\Feature;
use App\Models\FeaturePackageSafari;
use App\Models\FeatureThingsToCarrySafari;
use App\Models\ItineraryPackage;
use App\Models\Park;
use App\Models\ParkSafariType;
use App\Models\SafariDiscussion;
use App\Models\SafariesType;
use App\Models\SafariFaq;
use App\Models\SharedSafariDetailsTabs;
use App\Models\SharedShafariTabs;
use App\Models\ShareSafari;
use App\Models\ThingsToCarry;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SharedSafariController extends BaseController
{
    public function getSharedSafari(Request $request)
    {
        $query = ShareSafari::select('shared_safari_id', 'slug', 'title', 'safari_park_id', 'day', 'no_of_safari', 'visit_purpose_id', 'stay_category_id', 'min_price_pp', 'max_price_pp', 'share_seats', 'display_image')->with('park:park_id,name,state_id', 'park.state:state_id,name')
            ->where('status', 1)
            ->whereDate('day', '>', Carbon::today());

        if ($request->stateSelect) {
            $query->whereHas('park.state', fn($q) => $q->where('state_id', $request->stateSelect));
        }

        if ($request->speciesSelected) {
            $parkIDs = Park::whereHas(
                'ParkSpecies',
                fn($q) => $q->where('species_id', $request->speciesSelected)
            )->pluck('park_id');
            $query->whereHas('park', fn($q) => $q->whereIn('park_id', $parkIDs));
        }

        if ($request->inclusion_select) {
            $query = $query->whereHas('featuer_safaries', fn($q) => $q->whereIn('feature_id', $request->inclusion_select));
        }

        if ($request->parkSelect) {
            $query->where('safari_park_id', $request->parkSelect);
        }

        if ($request->theme_select) {
            $query->whereIn('visit_purpose_id', $request->theme_select);
        }

        if (is_numeric($request->minPrice) && is_numeric($request->maxPrice)) {
            $query->whereRaw('CAST(min_price_pp AS UNSIGNED) <= ?', [$request->maxPrice])
                ->whereRaw('CAST(max_price_pp AS UNSIGNED) >= ?', [$request->minPrice]);
        }

        if (is_numeric($request->minSafari) && is_numeric($request->maxSafari)) {
            $query->whereRaw('CAST(no_of_safari AS UNSIGNED) <= ?', [$request->maxSafari])
                ->whereRaw('CAST(no_of_safari AS UNSIGNED) >= ?', [$request->minSafari]);
        }

        if (!empty($request->selectedStayCategories)) {
            $query->whereIn('stay_category_id', $request->selectedStayCategories);
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
        $shareSafaris = $query->paginate($perPage);


        $baseUrl = env('APP_URL');

        foreach ($shareSafaris->items() as $item) {

            if (!empty($item->display_image) && filter_var($item->display_image, FILTER_VALIDATE_URL) === false) {
                $item->display_image = rtrim($baseUrl, '/') . '/' . ltrim($item->display_image, '/');
            }

            if (!empty($item->park->display_image) && filter_var($item->park->display_image, FILTER_VALIDATE_URL) === false) {
                $item->park->display_image = rtrim($baseUrl, '/') . '/' . ltrim($item->park->display_image, '/');
            }

            if (!empty($item->park->banner_image) && filter_var($item->park->banner_image, FILTER_VALIDATE_URL) === false) {
                $item->park->banner_image = rtrim($baseUrl, '/') . '/' . ltrim($item->park->banner_image, '/');
            }
        }



        return response()->json([
            'success' => true,
            'message' => 'Data found.',
            'data' => $shareSafaris->items(),
            'current_page' => $shareSafaris->currentPage(),
            'last_page' => $shareSafaris->lastPage(),
            'total' => $shareSafaris->total(),
        ], 200);
    }

    public function getSharedSafariDetails(Request $request)
    {
        $sharedSafari = ShareSafari::select('shared_safari_id', 'slug', 'title', 'safari_park_id', 'day', 'no_of_safari', 'visit_purpose_id', 'stay_category_id', 'min_price_pp', 'max_price_pp', 'share_seats', 'display_image', 'organized_type', 'organized_by')->with(['park:park_id,name', 'detailsTabs' => function ($query) {
            $query->select('shared_safari_details_tabs_id', 'shared_safari_tabs_id', 'shared_safari_id', 'title');
        }])->where('slug', $request->slug)->first();


        if (!$sharedSafari) {
            return response()->json([
                'success' => false,
                'message' => 'Shared Safari not found',
            ], 404);
        }


        $baseUrl = env('APP_URL');
        if (!empty($sharedSafari->display_image) && filter_var($sharedSafari->display_image, FILTER_VALIDATE_URL) === false) {
            $sharedSafari->display_image = rtrim($baseUrl, '/') . '/' . ltrim($sharedSafari->display_image, '/');
        }

        return response()->json([
            'success' => true,
            'message' => 'Shared Safari found',
            'data' => $sharedSafari,
        ], 200);
    }

    public function getSharedSafariTabsDetails(Request $request)
    {
        if (!$request->has('safari_id') || !$request->has('characterstic_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Missing safari_id or characteristic_id',
                'data' => null,
            ], 400);
        }

        $safariId = $request->safari_id;
        $charactersticId = $request->characterstic_id;


        $packageExists = ShareSafari::find($safariId);
        if (!$packageExists) {
            return response()->json([
                'success' => false,
                'message' => 'Shared Safari not found.',
                'data' => null,
            ], 404);
        }

        $responseData = $this->getPackagesDataByTitle($charactersticId, $safariId);

        if (empty($responseData) || (is_array($responseData) && empty($responseData))) {
            return response()->json([
                'success' => false,
                'message' => 'No data found for the given safariId and characteristic_id',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data found.',
            'data' => $responseData,
        ], 200);
    }

    private function getPackagesDataByTitle($characterstic_id, $safariId)
    {
        switch ($characterstic_id) {
            case '1':
                return $this->getInclusionsData($safariId);
            case '2':
                return $this->getExclusionsData($safariId);
            case '3':
                return $this->getThingsToCarrysData($safariId);
            case '4':
                return $this->getFAQData($safariId);
            case '5':
                return $this->getDiscussionData($safariId);
                // default:
                //     return $this->getDynamicData($characterstic_id, $package_id);
        }
    }

    private function getInclusionsData($safariId)
    {

        $InclusionsData = FeaturePackageSafari::select('icon', 'title')->where('share_safari_id', $safariId)->where('type', 1)->get();

        return $InclusionsData ?? [];
    }

    private function getExclusionsData($safariId)
    {

        $ExclusionsData = FeaturePackageSafari::select('icon', 'title')->where('share_safari_id', $safariId)->where('type', 2)->get();

        return $ExclusionsData ?? [];
    }

    private function getThingsToCarrysData($safariId)
    {

        $ThingsToCarry = FeatureThingsToCarrySafari::select('title', 'description')->where('share_safari_id', $safariId)->get();

        return $ThingsToCarry ?? [];
    }

    private function getFAQData($package_id)
    {

        // $SafariFaq = SafariFaq::select('question', 'answer')->where('share_safari_id', $package_id)->get();

        return $SafariFaq ?? [];
    }

    private function getDiscussionData($safariId)
    {

        $discussions = SafariDiscussion::with(['user', 'admin'])
            ->where('share_safari_id', $safariId)->get();

        return $discussions ?? [];
    }

    public function getCreatedSharedSafari()
    {

        $user = Auth::guard('user_api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated.',
                'data' => null,
            ], 401);
        }

        $shareSafaris = ShareSafari::with('park.state')
            ->where('organized_by', $user->id)
            ->where('organized_type', 'user')
            ->paginate(10);

        return response()->json([
            'status' => 200,
            'message' => 'Successful',
            'data' => $shareSafaris
        ]);
    }


    public function createSharedSafari(Request $request)
    {

        $user = Auth::guard('user_api')->user();
        $shared_safari_id = $request->shared_safari_id;
        $IdAddress = UserHelper::UserIPDetails();

        if (empty($user)) {
            return response()->json([
                'status' => false,
                'status_code' => 401,
                'message' => 'User not authenticated'
            ], 401);
        }

        if (empty($request->active_tab)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Active Tab field is required.',
                'data' => null,
            ], 401);
        }
        switch ($request->active_tab) {
            case 1:

                $validator = Validator::make($request->all(), [
                    'title' => 'required|string',
                    'park_id' => 'required',
                    'day' => 'required',
                    'night' => 'required',
                    'safari_count' => 'required|numeric|min:1',
                    'safari_type' => 'required|array',
                    'safari_type.*' => 'exists:safari_types,safari_type_id',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'message' => $validator->errors()->first(),
                        'data' => ""
                    ], 200);
                }

                if (empty($shared_safari_id)) {
                    $baseSlug = Str::slug($request->title);
                    $slug = $baseSlug;
                    $counter = 1;
                    while (ShareSafari::where('slug', $slug)->exists()) {
                        $slug = $baseSlug . '-' . $counter++;
                    }

                    $shareSafari = ShareSafari::create([
                        'title' => $request->title,
                        'slug' => $slug,
                        'safari_park_id' => $request->park_id,
                        'day' => $request->day,
                        'night' => $request->night,
                        'no_of_safari' => $request->safari_count,
                        'organized_by' => $user->id,
                        'organized_type' => 'user',
                        'status' => 1,
                        'ip_address' => $IdAddress['ip_address'],
                        'browser' => $IdAddress['browser'],
                        'os' => $IdAddress['os'],
                        'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
                    ]);


                    foreach ($request->safari_type as $type_id) {
                        SafariesType::create([
                            'shared_safari_id' => $shareSafari->id,
                            'safari_type_id' => $type_id,
                        ]);
                    }
                } else {
                    
                    $shareSafari = ShareSafari::find($shared_safari_id);
                    if (!$shareSafari) return;

                    if ($request->title != $shareSafari->title) {

                        $baseSlug = Str::slug($request->title);
                        $slug = $baseSlug;
                        $counter = 1;

                        while (ShareSafari::where('slug', $slug)->exists()) {
                            $slug = $baseSlug . '-' . $counter++;
                        }
                    } else {
                        $slug = $shareSafari->slug;
                    }

                    $shareSafari->update([
                        'title' => $request->title,
                        'slug' => $slug,
                        'safari_park_id' => $request->park_id,
                        'day' => $request->day,
                        'night' => $request->night,
                        'no_of_safari' => $request->safari_count,
                        'organized_by' => $user->id,
                        'organized_type' => 'user',
                        'ip_address' => $IdAddress['ip_address'],
                        'browser' => $IdAddress['browser'],
                        'os' => $IdAddress['os'],
                        'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
                    ]);

                    SafariesType::where('shared_safari_id', $shareSafari->id)->delete();
                    foreach ($request->safari_type as $type_id) {
                        SafariesType::create([
                            'shared_safari_id' => $shareSafari->id,
                            'safari_type_id' => $type_id,
                        ]);
                    }
                }
                return response()->json(['status' => 200, 'message' => 'Details Added Successfully', 'data' => $shareSafari], 200);
            case 2:

                $validator = Validator::make($request->all(), [
                    'shared_safari_id' => 'required',
                    'visit_purpose_id' => 'required',
                    'stay_category_id' => 'required',
                    'price_min' => 'required|numeric',
                    'price_max' => 'required|numeric',
                    'total_seats' => 'required|numeric|min:1',
                    'share_seats' => 'required|numeric|min:1',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'message' => $validator->errors()->first(),
                        'data' => ""
                    ], 200);
                }


                if ($request->price_min > 0) {
                    $minAllowed = $request->price_min;
                    $maxAllowed = $request->price_min * 1.08;

                    if ($request->price_max < $minAllowed || $request->price_max > $maxAllowed) {
                        return response()->json(['message' => 'Max price must be greater than min price and less than 8%'], 400);
                    }
                }

                $shareSafari = ShareSafari::find($request->shared_safari_id);
                if (!$shareSafari) {
                    return response()->json(['message' => 'Safari not found'], 404);
                }


                $shareSafari->update([
                    'visit_purpose_id' => $request->visit_purpose_id,
                    'stay_category_id' => $request->stay_category_id,
                    'min_price_pp' => $request->price_min,
                    'max_price_pp' => $request->price_max,
                    'total_seats' => $request->total_seats,
                    'share_seats' => $request->share_seats,
                    'ip_address' => $IdAddress['ip_address'],
                    'browser' => $IdAddress['browser'],
                    'os' => $IdAddress['os'],
                    'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
                ]);

                return response()->json(['status' => 200, 'message' => 'Details Updated Successfully', 'data' => $shareSafari], 200);

            case 3:

                $validator = Validator::make($request->all(), [
                    'display_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,JPG,JPEG|max:5120',
                    'shared_safari_id' => 'required',
                ], [
                    'display_image.max' => 'The display image must not be greater than 5 MB.',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'message' => $validator->errors()->first(),
                        'data' => ""
                    ], 200);
                }

                $shareSafari = ShareSafari::find($request->shared_safari_id);
                if (!$shareSafari) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Safari not found',
                        'data' => ""
                    ], 200);
                }


                $path = 'uploads/sharesafarie';
                $avifPath = null;

                if ($request->hasFile('display_image')) {
                    $origPath = $request->file('display_image')->store($path, 'public_root');
                    $avifPath = ImageHelper::convertToAvif($origPath, $path);
                } else {
                    $avifPath = $request->previousImage;
                }

                $shareSafari->update([
                    'display_image' => $avifPath,
                    'ip_address' => $IdAddress['ip_address'],
                    'browser' => $IdAddress['browser'],
                    'os' => $IdAddress['os'],
                    'device' => $IdAddress['is_mobile'] ? 'Mobile' : 'Desktop',
                ]);

                return response()->json(['status' => 200, 'message' => 'Details Updated Successfully', 'data' => $shareSafari], 200);

            case 4:

                return response()->json(['message' => 'State 4 handled successfully'], 200);

            default:
                return response()->json(['message' => 'Invalid state'], 400);
        }
    }

    public function safariType(Request $request)
    {
        $user = Auth::guard('user_api')->user();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'User not authenticated.',
                'data' => null,
            ], 401);
        }

        $park_id = $request->get('park_id');
        if (empty($park_id)) {
            return response()->json([
                'status' => 400,
                'message' => 'Park ID is required.',
                'data' => null,
            ], 400);
        }

        $safariTypes = ParkSafariType::select('park_safari_type_id', 'safari_type_id', 'park_id')
            ->with('safari_type:safari_type_id,name')
            ->where('park_id', $park_id)
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->safari_type->safari_type_id,
                    'name' => $item->safari_type->name ?? null,
                ];
            });

        if ($safariTypes->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'No safari types found for this park.',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $safariTypes,
        ], 200);
    }

    public function createInclusion(Request $request)
    {
        $user = Auth::guard('user_api')->user();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'User not authenticated.',
                'data' => null,
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'shared_safari_id' => 'required',
            'type' => 'required',
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => ""
            ], 200);
        }

        $icon = '<i class="fas fa-info-circle" aria-hidden="true"></i>';
        foreach ($request->title as $items) {
            FeaturePackageSafari::create([
                'share_safari_id' => $request->shared_safari_id,
                'type'       => $request->type,
                'title'      => $items,
                'icon'       => $icon,
                'feature_id' => $request->feature_id,
            ]);
        }

        $characteristic = SharedShafariTabs::find($request->type);
        if ($characteristic) {
            $checkrecords =  SharedSafariDetailsTabs::where('shared_safari_tabs_id', $characteristic->id)->where('shared_safari_id', $request->shared_safari_id)->exists();
            if (!$checkrecords) {
                SharedSafariDetailsTabs::create([
                    'shared_safari_tabs_id' => $characteristic->id,
                    'shared_safari_id' => $request->shared_safari_id,
                    'title' => $characteristic->title,
                    'status' => true,
                ]);
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => "",
        ], 200);
    }

    public function InclusionExclusionList(Request $request)
    {
        $user = Auth::guard('user_api')->user();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'User not authenticated.',
                'data' => null,
            ], 401);
        }
        $sharedsafarId = $request->get('shared_safari_id');

        if (!$sharedsafarId) {
            return response()->json([
                'status' => 400,
                'message' => "Shared Safari Id is required",
                'data' => ""
            ], 200);
        }

        $safariTypes = FeaturePackageSafari::select('safari_inclusion_exclusions_id', 'share_safari_id', 'type', 'icon', 'title')->where('share_safari_id', $request->shared_safari_id)
            ->where('type', $request->type)
            ->get();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $safariTypes,
        ], 200);
    }

    public function InclusionExclusionDelete(Request $request)
    {
        $user = Auth::guard('user_api')->user();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'User not authenticated.',
                'data' => null,
                'code' => 401,
            ], 401);
        }

        $request->merge($request->all());

        $validator = Validator::make($request->all(), [
            'shared_safari_id' => 'required',
            'inclusion_exclusion_id' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 200);
        }

        $safari = FeaturePackageSafari::where('share_safari_id', $request->shared_safari_id)
            ->where('type', $request->type)
            ->where('safari_inclusion_exclusions_id', $request->inclusion_exclusion_id)
            ->first();

        if (!$safari) {
            return response()->json([
                'status' => 404,
                'message' => 'Resource not found',
                'data' => null,
            ], 200);
        }

        $safari->delete();
        $type = ($request->type == 1) ? "Inclusion" : "Exclusion";
        return response()->json([
            'status' => 200,
            'message' => $type . 'deleted successfully.',
            'data' => null,
        ], 200);
    }

    public function InclusionExclusionCommon(Request $request)
    {
        $user = Auth::guard('user_api')->user();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'User not authenticated.',
                'data' => null,
            ], 401);
        }
        $type  = $request->get('type');
        if (!$type) {
            return response()->json([
                'status' => 400,
                'message' => "Type is required",
                'data' => ""
            ], 200);
        }
        $featureOptions = Feature::where('type', $type)
            ->pluck('title', 'features_id')
            ->toArray();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $featureOptions,
        ], 200);
    }

    public function thingsToCarryCreate(Request $request)
    {
        $user = Auth::guard('user_api')->user();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'User not authenticated.',
                'data' => null,
            ], 401);
        }

        $sharedsafarId = $request->get('shared_safari_id');

        if (!$sharedsafarId) {
            return response()->json([
                'status' => 400,
                'message' => "Shared Safari Id is required",
                'data' => ""
            ], 200);
        }

        foreach ($request->thingstocarry_items as $item) {
            FeatureThingsToCarrySafari::create([
                'share_safari_id' => $request->shared_safari_id,
                'title'       => $item['title'],
                'description' => $item['description'],
            ]);
        }

        $featureType1 = FeaturePackageSafari::where('share_safari_id', $sharedsafarId)
            ->where('type', 1)
            ->exists();

        $featureType2 = FeaturePackageSafari::where('share_safari_id', $sharedsafarId)
            ->where('type', 2)
            ->exists();

        $thingsToCarry = FeatureThingsToCarrySafari::where('share_safari_id', $sharedsafarId)
            ->exists();

        if ($featureType1 && $featureType2 && $thingsToCarry) {

            $shareSafari = ShareSafari::find($request->shared_safari_id);
            $shareSafari->is_create_safari_complete = "completed";

            $publish_status = SettingHelper::get('publish_user_sharedsafari', '0');
            $publish_status_agent = SettingHelper::get('publish_agent_sharedsafari', '0');

            if ($publish_status && $user->user_type == 0) {
                $shareSafari->is_approved = 1;
            }
            if ($publish_status_agent && $user->user_type == 1) {
                $shareSafari->is_approved = 1;
            }
            $shareSafari->save();

            $characteristics = SharedShafariTabs::find([3, 5]);
            if ($characteristics) {
                $checkrecords =  SharedSafariDetailsTabs::whereIn('shared_safari_tabs_id', [3, 5])->where('shared_safari_id', $sharedsafarId)->exists();
                if (!$checkrecords) {
                    foreach ($characteristics as $characteristic) {
                        SharedSafariDetailsTabs::create([
                            'shared_safari_tabs_id' => $characteristic->id,
                            'shared_safari_id' => $sharedsafarId,
                            'title' => $characteristic->title,
                            'status' => true,
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => "",
        ], 200);
    }

    public function listingThingsToCarry(Request $request)
    {
        $user = Auth::guard('user_api')->user();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'User not authenticated.',
                'data' => null,
            ], 401);
        }

        $sharedsafarId = $request->get('shared_safari_id');

        if (!$sharedsafarId) {
            return response()->json([
                'status' => 400,
                'message' => "Shared Safari Id is required",
                'data' => ""
            ], 200);
        }

        $thingsToCarryList = FeatureThingsToCarrySafari::select('safari_things_to_carries_id', 'share_safari_id', 'title', 'description')->where('share_safari_id', $request->shared_safari_id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $thingsToCarryList,
        ], 200);
    }

    public function deleteThingsToCarry(Request $request)
    {
        $user = Auth::guard('user_api')->user();
        $request->merge($request->all());
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'User not authenticated.',
                'data' => null,
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'shared_safari_id' => 'required',
            'safari_things_to_carries_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 200);
        }

        $safari = FeatureThingsToCarrySafari::where('share_safari_id', $request->shared_safari_id)
            ->where('safari_things_to_carries_id', $request->safari_things_to_carries_id)
            ->first();

        if (!$safari) {
            return response()->json([
                'status' => 404,
                'message' => 'Resource not found',
                'data' => null,
            ], 404);
        }

        $safari->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Things To Carry deleted successfully.',
            'data' => null,
        ], 200);
    }

    public function commonThingsToCarry(Request $request)
    {
        $user = Auth::guard('user_api')->user();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'User not authenticated.',
                'data' => null,
            ], 401);
        }

        $featureOptions = ThingsToCarry::select('things_to_carry_id', 'title', 'short_description')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $featureOptions,
        ], 200);
    }
}
