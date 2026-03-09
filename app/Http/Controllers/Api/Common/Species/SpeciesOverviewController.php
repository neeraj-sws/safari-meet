<?php

namespace App\Http\Controllers\Api\Common\Species;

<<<<<<< HEAD
use App\Helpers\UserHelper;
use App\Http\Controllers\Api\BaseController;
use App\Mail\DynamicMail;
use App\Models\AdaptationModel;
use App\Models\Admin;
use App\Models\DietModel;
use App\Models\Enquiry;
=======
use App\Http\Controllers\Api\BaseController;
use App\Models\AdaptationModel;
use App\Models\DietModel;
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
use App\Models\Species;
use App\Models\SpeciesDetailsDynamicTabs;
use App\Models\SpeciesInterestingFactsModel;
use App\Models\SpeciesLifestyleModel;
use App\Models\SpeciesOverviewModel;
use App\Models\SpeciesPhysicalAppereancesModel;
use App\Models\SpeciesThreatModel;
<<<<<<< HEAD
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Request;

class SpeciesOverviewController extends BaseController
{
    public function TopSpecies(Request $request)
    {
        $limit  = (int) $request->get('limit', 10);
        $search = $request->get('search');

        $query = Species::select(
            'species_id',
            'name',
            'slug',
            'display_image',
            'banner_image',
            'top_species',
            'meta_title',
            'meta_description',
            'meta_image'
        )->where('status', 1);

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $total = $query->count();

        $species = $query
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();

        $species->transform(function ($item) {
            if ($item->display_image && !filter_var($item->display_image, FILTER_VALIDATE_URL)) {
                $item->display_image = url($item->display_image);
            }

            if ($item->banner_image && !filter_var($item->banner_image, FILTER_VALIDATE_URL)) {
                $item->banner_image = url($item->banner_image);
            }

            return $item;
        });

        return response()->json([
            'success'  => true,
            'data'     => $species,
            'limit'    => $limit,
            'total'    => $total,
            'has_more' => $limit < $total,
=======

class SpeciesOverviewController extends BaseController
{
    public function TopSpecies()
    {
        $baseUrl = env('APP_URL');

        $species = Species::select('species_id','name','slug','display_image','banner_image')->where('status', 1)->get();

        foreach ($species as $item) {

            if (!empty($item->display_image) && filter_var($item->display_image, FILTER_VALIDATE_URL) === false) {
                $item->display_image = rtrim($baseUrl, '/') . '/' . ltrim($item->display_image, '/');
            }

            if (!empty($item->banner_image) && filter_var($item->banner_image, FILTER_VALIDATE_URL) === false) {
                $item->banner_image = rtrim($baseUrl, '/') . '/' . ltrim($item->banner_image, '/');
            }
        }

        return response()->json([
            'success' => true,
            'data' => $species,
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        ], 200);
    }

    public function speciesDetail($slug)
    {
        $baseUrl = env('APP_URL');

        $species = Species::select('species_id', 'name', 'slug', 'display_image', 'banner_image')
            ->with(['charactersticDetails' => function ($query) {
                $query->select('species_details_characterstic_id', 'species_id', 'species_characterstics', 'title')
<<<<<<< HEAD
                    ->where('status', 1);
=======
                      ->where('status', 1);
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            }])
            ->where('slug', $slug)
            ->first();

        if (!$species) {
            return response()->json([
                'success' => false,
                'message' => 'Species not found.',
                'data' => []
            ], 404);
        }


        if (!empty($species->display_image) && filter_var($species->display_image, FILTER_VALIDATE_URL) === false) {
            $species->display_image = rtrim($baseUrl, '/') . '/' . ltrim($species->display_image, '/');
        }


        if (!empty($species->banner_image) && filter_var($species->banner_image, FILTER_VALIDATE_URL) === false) {
            $species->banner_image = rtrim($baseUrl, '/') . '/' . ltrim($species->banner_image, '/');
        }

        return response()->json([
            'success' => true,
            'message' => 'Species found.',
            'data' => $species,
        ], 200);
    }

    public function speciesData($id)
    {
<<<<<<< HEAD
        $characterstic_id = request()->query(key: 'species_characterstics');
        $tab_id = request()->query('species_details_characterstic_id');
        $tabData = null;
        $responseData = $this->getSpeciesDataByTitle($characterstic_id, $id, $tab_id);
=======
        $characterstic_id = request()->query('species_characterstics');
        $tab_id = request()->query('species_details_characterstic_id');
        $tabData = null;
        $responseData = $this->getSpeciesDataByTitle($characterstic_id, $id,$tab_id);
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        if (!$responseData) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'No data found for the specified title.',
<<<<<<< HEAD
            ], 200);
=======
            ],200);
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        }
        $responseDataArray = is_array($responseData) ? $responseData : $responseData->toArray();
        $tabDataArray = $tabData ? $tabData->toArray() : null;

        return response()->json([
            'success' => true,
            'data' => array_merge(['tab_data' => $tabDataArray], $responseDataArray),
        ], 200);
    }
<<<<<<< HEAD
    private function getSpeciesDataByTitle($characterstic_id, $id, $tab_id)
=======
    private function getSpeciesDataByTitle($characterstic_id, $id,$tab_id)
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    {
        switch ($characterstic_id) {

            case '1':
                return $this->getOverviewData($tab_id, $id);
            case '2':
                return $this->getPhysicalAppearanceData($tab_id, $id,);
            case '4':
<<<<<<< HEAD
                return $this->getThreatsData($tab_id, $id, $tab_id);
=======
                return $this->getThreatsData($tab_id, $id,$tab_id);
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            case '5':
                return $this->getInterestingFactsData($tab_id, $id);
            default:
                return $this->getDynamicData($tab_id, $id);
        }
    }
    private function getOverviewData($tab_id, $id)
    {
        $baseUrl = env('APP_URL');

        $overview = SpeciesOverviewModel::with(['category:species_category_id,name', 'family:species_family_id,name', 'genus:species_genus_id,name'])
            ->where('species_id', $id)
            ->where('species_details_characterstics_id', $tab_id)
            ->first();

        if ($overview && !empty($overview->about_image) && filter_var($overview->about_image, FILTER_VALIDATE_URL) === false) {
            $overview->about_image = rtrim($baseUrl, '/') . '/' . ltrim($overview->about_image, '/');
        }

        return $overview;
    }

    private function getPhysicalAppearanceData($tab_id, $id)
    {
        $baseUrl = rtrim(env('APP_URL'), '/');


        $adaptationData = AdaptationModel::where('species_id', $id)->get();

        $physicalData = SpeciesPhysicalAppereancesModel::where('species_id', $id)
            ->where('species_details_characterstics_id', $tab_id)
            ->first();


        $traits = json_decode($physicalData->trait ?? '{}', true);


        $lifestyleData = SpeciesLifestyleModel::where('species_id', $id)
            ->where('species_details_characterstics_id', $tab_id)
            ->first();


        $dietData = DietModel::where('species_id', $id)->get();

        $dietData->transform(function ($item) use ($baseUrl) {
            if (!empty($item->image) && filter_var($item->image, FILTER_VALIDATE_URL) === false) {
                $item->image = $baseUrl . '/' . ltrim($item->image, '/');
            }
            return $item;
        });

        return [
            'adaptation_data'   => $adaptationData,
            'physical_data'     => $physicalData,
            'traits'            => $traits,
            'lifestyle_data'    => $lifestyleData,
            'diet_data'         => $dietData,
        ];
    }

    private function getThreatsData($tab_id, $id)
    {
        $data = SpeciesThreatModel::where('species_id', $id)
            ->where('species_details_characterstics_id', $tab_id)
            ->first();

        if ($data && !empty($data->image) && filter_var($data->image, FILTER_VALIDATE_URL) === false) {
            $baseUrl = rtrim(env('APP_URL'), '/');
            $data->image = $baseUrl . '/' . ltrim($data->image, '/');
        }

        return $data;
    }

    private function getInterestingFactsData($tab_id, $id)
    {
        return SpeciesInterestingFactsModel::where('species_id', $id)->where('species_details_characterstics_id', $tab_id)->first();
    }
    private function getDynamicData($tab_id, $id)
    {
        return SpeciesDetailsDynamicTabs::where('species_id', $id)->where('species_details_characterstics_id', $tab_id)->first();
    }
<<<<<<< HEAD
=======
    
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
}
