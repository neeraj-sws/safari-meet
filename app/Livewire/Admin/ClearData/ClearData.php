<?php

namespace App\Livewire\Admin\ClearData;

use App\Models\SpeciesFamilyModel as Model;
use App\Models\{
    AdaptationModel,
    DietModel,
    FeaturePackageSafari,
    FeatureThingsToCarrySafari,
    ItineraryPackage,
    JoinSharedSafari,
    Package,
    PackageBanner,
    PackageDetailsTabs,
    Park,
    ParkAboutSection,
    ParkBestTimeModel,
    ParkBestTimeVistModel,
    ParkDetailsDynamicTabs,
    ParkDetailsTabs,
    ParkInformationModel,
    ParkKeyInfoModel,
    ParkReachability,
    ParkReachabilityDistance,
    ParkSafariTime,
    ParkSafariTimeDetail,
    ParkSafariType,
    ParkSpecies,
    ParkTraveltipsModel,
    ParkWhatToCarryModel,
    ParkWildlifeFoundModel,
    ParkZoneModel,
    SafariAccommodation,
    SafariDetailsDynamicTabs,
    Species,
    SpeciesDetailsCharactersticModel,
    SpeciesDetailsDynamicTabs,
    SpeciesInterestingFactsModel,
    SpeciesLifestyleModel,
    SpeciesOverviewModel,
    SpeciesPhysicalAppereancesModel,
    SpeciesThreatModel,
    SafariDiscussion,
    SafariFaq,
    SafariRating,
    SafariRatingHeading,
    SharedSafariDetailsTabs,
    SafariAllottedSeat,
    ShareSafari
};
use Livewire\Attributes\{Layout, On};
use Livewire\Component;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.admin-app')]
class ClearData extends Component
{
    public $pageTitle = 'Clear Data';

    public function render()
    {
        return view('livewire.admin.clear-data.clear-data');
    }

    public function confirmDelete($id)
    {
        $actions = [
            1 => 'deletespecies',
            2 => 'deletepark',
            3 => 'deletePackage',
            4 => 'deleteSharedSafari',
        ];

        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => $actions[$id] ?? null,
        ]);
    }

    #[On('deletespecies')]
    public function deletespecies()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        SpeciesDetailsDynamicTabs::truncate();
        SpeciesInterestingFactsModel::truncate();

        SpeciesThreatModel::each(function ($item) {
            if (!empty($item->image) && file_exists(public_path($item->image))) {
                @unlink(public_path($item->image));
            }
        });
        SpeciesThreatModel::truncate();

        SpeciesLifestyleModel::truncate();

        DietModel::each(function ($item) {
            if (!empty($item->image) && file_exists(public_path($item->image))) {
                @unlink(public_path($item->image));
            }
        });
        DietModel::truncate();

        SpeciesPhysicalAppereancesModel::truncate();
        AdaptationModel::truncate();

        SpeciesOverviewModel::each(function ($item) {
            if (!empty($item->about_image) && file_exists(public_path($item->about_image))) {
                @unlink(public_path($item->about_image));
            }
        });
        SpeciesOverviewModel::truncate();

        SpeciesDetailsCharactersticModel::truncate();

        Species::each(function ($item) {
            if (!empty($item->display_image) && file_exists(public_path($item->display_image))) {
                @unlink(public_path($item->display_image));
            }
            if (!empty($item->banner_image) && file_exists(public_path($item->banner_image))) {
                @unlink(public_path($item->banner_image));
            }
        });
        Species::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Species Data Cleared Successfully'
        ]);
    }

    #[On('deletepark')]
    public function deletepark()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        ParkDetailsDynamicTabs::truncate();
        ParkBestTimeVistModel::truncate();

        ParkWhatToCarryModel::each(function ($item) {
            if (!empty($item->image) && file_exists(public_path($item->image))) {
                @unlink(public_path($item->image));
            }
        });
        ParkWhatToCarryModel::truncate();

        ParkTraveltipsModel::truncate();
        ParkReachabilityDistance::truncate();
        ParkReachability::truncate();
        ParkSpecies::truncate();
        ParkSafariTimeDetail::truncate();
        ParkSafariTime::truncate();
        ParkZoneModel::truncate();

        ParkInformationModel::each(function ($item) {
            foreach (['donts_image', 'dos_image'] as $img) {
                if (!empty($item->$img) && file_exists(public_path($item->$img))) {
                    @unlink(public_path($item->$img));
                }
            }
        });
        ParkInformationModel::truncate();

        ParkAboutSection::each(function ($item) {
            if (!empty($item->image) && file_exists(public_path($item->image))) {
                @unlink(public_path($item->image));
            }
        });
        ParkAboutSection::truncate();

        ParkKeyInfoModel::each(function ($item) {
            foreach (['timing_cost_image', 'travel_info_image', 'overview_image'] as $img) {
                if (!empty($item->$img) && file_exists(public_path($item->$img))) {
                    @unlink(public_path($item->$img));
                }
            }
        });
        ParkKeyInfoModel::truncate();

        Park::each(function ($item) {
            foreach (['banner_image', 'display_image'] as $img) {
                if (!empty($item->$img) && file_exists(public_path($item->$img))) {
                    @unlink(public_path($item->$img));
                }
            }
        });
        Park::truncate();

        ParkSafariType::truncate();
        ParkWildlifeFoundModel::truncate();
        ParkBestTimeModel::truncate();
        ParkDetailsTabs::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Park Data Cleared Successfully'
        ]);
    }

    #[On('deletePackage')]
    public function deletePackage()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        SafariDetailsDynamicTabs::whereNotNull('package_id')->delete();
        SafariDiscussion::whereNotNull('package_id')->delete();
        // SafariFaq::whereNotNull('package_id')->delete();
        FeatureThingsToCarrySafari::whereNotNull('package_id')->delete();
        SafariRating::whereNotNull('package_id')->delete();
        SafariRatingHeading::whereNotNull('package_id')->delete();
        SafariAccommodation::whereNotNull('package_id')->delete();
        FeaturePackageSafari::whereNotNull('package_id')->delete();
        PackageDetailsTabs::whereNotNull('package_id')->delete();

        ItineraryPackage::whereNotNull('package_id')->each(function ($package) {
            $package->packageActivities()->delete();
            $package->delete();
        });

        PackageBanner::each(function ($item) {
            if (!empty($item->image) && file_exists(public_path($item->image))) {
                @unlink(public_path($item->image));
            }
        });
        PackageBanner::truncate();

        Package::each(function ($item) {
            if (!empty($item->display_image) && file_exists(public_path($item->display_image))) {
                @unlink(public_path($item->display_image));
            }
            $item->detailsTabs()->delete();
        });
        Package::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Package Safari Data Cleared Successfully'
        ]);
    }

    #[On('deleteSharedSafari')]
    public function deleteSharedSafari()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        SafariDetailsDynamicTabs::whereNotNull('shared_safari_id')->delete();
        SafariDiscussion::whereNotNull('share_safari_id')->delete();
        // SafariFaq::whereNotNull('share_safari_id')->delete();
        FeatureThingsToCarrySafari::whereNotNull('share_safari_id')->delete();
        FeaturePackageSafari::whereNotNull('share_safari_id')->delete();
        SharedSafariDetailsTabs::truncate();
        SafariAllottedSeat::truncate();
        JoinSharedSafari::truncate();

        ShareSafari::each(function ($item) {
            if (!empty($item->display_image) && file_exists(public_path($item->display_image))) {
                @unlink(public_path($item->display_image));
            }
        });
        ShareSafari::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Shared Safari Data Cleared Successfully'
        ]);
    }
}
