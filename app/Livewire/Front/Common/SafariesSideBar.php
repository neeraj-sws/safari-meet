<?php

namespace App\Livewire\Front\Common;

use App\Models\{Feature, Package, Park, ParkSpecies, ShareSafari, State, StayCategory, VisitPurpose, WeatherModel};
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class SafariesSideBar extends Component
{
    protected $listeners = ['sidebarRemoveFilter' => 'removeFilterFromSidebar', 'sidebarClearAll' => 'clearAllFromSidebar'];


    public $states = [], $parks = [], $stayCategory = [], $bttv_list = [], $inclusions = [], $visitPurposes = [], $species = [];
    public $allFiltersValue = [];


    public $stateSelect, $speciesSelected, $parkSelect;
    public $bttv_selected = [], $selectedStayCategories = [], $inclusion_select = [], $theme_select = [];
    public $minPrice, $maxPrice, $minday, $maxday, $minSafari, $maxSafari;


    public $lowestPrice, $highestPrice, $lowestDay, $highestDay, $lowestSafari, $highestSafari;

    public function mount($type)
    {
        if ($type == 'package') {
            // Get min/max values directly from DB using aggregate functions
            $priceRange = Cache::remember('sidebar_package_price_range', 3600, function () {
                return Package::where('status', 1)
                    ->selectRaw('MIN(CAST(min_price_pp AS UNSIGNED)) as lowestPrice, MAX(CAST(max_price_pp AS UNSIGNED)) as highestPrice, MIN(CAST(start_tour AS UNSIGNED)) as lowestDay, MAX(CAST(start_tour AS UNSIGNED)) as highestDay, MIN(CAST(no_of_safari AS UNSIGNED)) as lowestSafari, MAX(CAST(no_of_safari AS UNSIGNED)) as highestSafari')
                    ->first();
            });

            $this->lowestPrice   = $priceRange->lowestPrice ?? 0;
            $this->highestPrice  = $priceRange->highestPrice ?? 0;
            $this->lowestDay     = $priceRange->lowestDay ?? 0;
            $this->highestDay    = $priceRange->highestDay ?? 0;
            $this->lowestSafari  = $priceRange->lowestSafari ?? 0;
            $this->highestSafari = $priceRange->highestSafari ?? 0;

            $this->minPrice  = $this->lowestPrice;
            $this->maxPrice  = $this->highestPrice;
            $this->minday    = $this->lowestDay;
            $this->maxday    = $this->highestDay;
            $this->minSafari = $this->lowestSafari;
            $this->maxSafari = $this->highestSafari;

            // Get IDs using distinct queries
            $parkIds = Cache::remember('sidebar_package_park_ids', 3600, function () {
                return Package::where('status', 1)->distinct()->pluck('park_id')->toArray();
            });

            $stateIds = Cache::remember('sidebar_package_state_ids', 3600, function () {
                return Park::whereIn('park_id', function ($query) {
                    $query->select('park_id')->from('packages')->where('status', 1)->distinct();
                })->pluck('state_id')->toArray();
            });

            $this->states        = State::select('state_id', 'name')->whereIn('state_id', $stateIds)->pluck('name', 'state_id');
            $this->parks         = Park::select('park_id', 'name')->whereIn('park_id', $parkIds)->pluck('name', 'park_id');
            $this->stayCategory  = Cache::remember('stay_categories_list', 86400, fn() => StayCategory::select('stay_category_id', 'name')->pluck('name', 'stay_category_id'));
            $this->bttv_list     = Cache::remember('weather_models_list', 86400, fn() => WeatherModel::where('status', 1)->select('park_weather_id', 'title')->get());
            $this->inclusions    = Cache::remember('features_list', 86400, fn() => Feature::where('type', 1)->select('features_id', 'title')->pluck('title', 'features_id'));
            $this->visitPurposes = Cache::remember('visit_purposes_list', 86400, fn() => VisitPurpose::select('visit_purpose_id', 'name')->pluck('name', 'visit_purpose_id'));
            $this->species       = Cache::remember('park_species_list', 3600, function () use ($parkIds) {
                return ParkSpecies::whereIn('park_id', $parkIds)
                    ->select('species_id', 'park_id')
                    ->with('speciesList:species_id,name')
                    ->get()
                    ->pluck('speciesList.name', 'speciesList.species_id')
                    ->unique();
            });
        } else if ($type == 'shared-safari') {
            // Get min/max values directly from DB
            $priceRange = Cache::remember('sidebar_shared_safari_price_range', 3600, function () {
                return ShareSafari::where('status', 1)
                    ->where('is_approved', 1)
                    ->selectRaw('MIN(CAST(min_price_pp AS UNSIGNED)) as lowestPrice, MAX(CAST(max_price_pp AS UNSIGNED)) as highestPrice, MIN(CAST(day AS DATE)) as lowestDay, MAX(CAST(day AS DATE)) as highestDay, MIN(CAST(no_of_safari AS UNSIGNED)) as lowestSafari, MAX(CAST(no_of_safari AS UNSIGNED)) as highestSafari')
                    ->first();
            });

            $this->lowestPrice   = $priceRange->lowestPrice ?? 0;
            $this->highestPrice  = $priceRange->highestPrice ?? 0;
            $this->lowestDay     = $priceRange->lowestDay ?? 0;
            $this->highestDay    = $priceRange->highestDay ?? 0;
            $this->lowestSafari  = $priceRange->lowestSafari ?? 0;
            $this->highestSafari = $priceRange->highestSafari ?? 0;

            $this->minPrice  = $this->lowestPrice;
            $this->maxPrice  = $this->highestPrice;
            $this->minday    = $this->lowestDay;
            $this->maxday    = $this->highestDay;
            $this->minSafari = $this->lowestSafari;
            $this->maxSafari = $this->highestSafari;

            // Get IDs using distinct queries
            $parkIds = Cache::remember('sidebar_shared_safari_park_ids', 3600, function () {
                return ShareSafari::where('status', 1)->where('is_approved', 1)->distinct()->pluck('safari_park_id')->toArray();
            });

            $stateIds = Cache::remember('sidebar_shared_safari_state_ids', 3600, function () {
                return Park::whereIn('park_id', function ($query) {
                    $query->select('park_id')->from('shared_safaris')->where('status', 1)->where('is_approved', 1)->distinct();
                })->pluck('state_id')->toArray();
            });

            $this->states = State::select('state_id', 'name')->whereIn('state_id', $stateIds)->pluck('name', 'state_id');
            $this->parks = Park::select('park_id', 'name')->whereIn('park_id', $parkIds)->pluck('name', 'park_id');
            $this->stayCategory = Cache::remember('stay_categories_list', 86400, fn() => StayCategory::select('stay_category_id', 'name')->pluck('name', 'stay_category_id'));
            $this->inclusions = Cache::remember('features_list', 86400, fn() => Feature::where('type', 1)->select('features_id', 'title')->pluck('title', 'features_id'));
            $this->visitPurposes = Cache::remember('visit_purposes_list', 86400, fn() => VisitPurpose::select('visit_purpose_id', 'name')->pluck('name', 'visit_purpose_id'));
            $this->species = Cache::remember('shared_safari_park_species_list', 3600, function () use ($parkIds) {
                return ParkSpecies::whereIn('park_id', $parkIds)
                    ->select('species_id', 'park_id')
                    ->with('speciesList:species_id,name')
                    ->get()
                    ->pluck('speciesList.name', 'speciesList.species_id')
                    ->unique();
            });
        }
    }

    public function updated($property)
    {

        $this->allFiltersValue = [
            'state'         => optional(State::find($this->stateSelect))->name,
            'species'       => optional(ParkSpecies::with('speciesList')->where('species_id', $this->speciesSelected)->first()?->speciesList)->name,
            'park'          => optional(Park::find($this->parkSelect))->name,
            'best_time'     => $this->getNames(WeatherModel::class, $this->bttv_selected, 'title', 'park_weather_id'),
            'stay_category' => $this->getNames(StayCategory::class, $this->selectedStayCategories, 'name', 'stay_category_id'),
            'inclusion'     => $this->getNames(Feature::class, $this->inclusion_select, 'title', 'features_id'),
            'visit_purpose' => $this->getNames(VisitPurpose::class, $this->theme_select, 'name', 'visit_purpose_id'),

            'price'  => ($this->minPrice != $this->lowestPrice || $this->maxPrice != $this->highestPrice)
                ? "₹{$this->minPrice} - ₹{$this->maxPrice}"
                : null,

            'days'   => ($this->minday != $this->lowestDay || $this->maxday != $this->highestDay)
                ? "{$this->minday} - {$this->maxday}"
                : null,

            'safari' => ($this->minSafari != $this->lowestSafari || $this->maxSafari != $this->highestSafari)
                ? "{$this->minSafari} - {$this->maxSafari}"
                : null,
        ];

        $this->allFiltersValue = array_filter($this->allFiltersValue);

        $this->dispatch('filtersUpdated', $this->allFiltersValue);
    }


    private function getNames($model, $ids, $column, $primaryKey = 'id')
    {
        return !empty($ids) ? $model::whereIn($primaryKey, $ids)->pluck($column)->toArray() : null;
    }

    public function clearAll()
    {
        $this->reset([
            'stateSelect',
            'speciesSelected',
            'parkSelect',
            'bttv_selected',
            'selectedStayCategories',
            'theme_select',
            'inclusion_select'
        ]);

        $this->minPrice  = $this->lowestPrice;
        $this->maxPrice  = $this->highestPrice;
        $this->minday    = $this->lowestDay;
        $this->maxday    = $this->highestDay;
        $this->minSafari = $this->lowestSafari;
        $this->maxSafari = $this->highestSafari;

        $this->allFiltersValue = [];
        $this->dispatch('filtersUpdated', $this->allFiltersValue);
    }

    public function removeFilter($key)
    {
        $map = [
            'state'        => 'stateSelect',
            'species'      => 'speciesSelected',
            'park'         => 'parkSelect',
            'best_time'    => 'bttv_selected',
            'stay_category' => 'selectedStayCategories',
            'visit_purpose' => 'theme_select',
            'inclusion'    => 'inclusion_select',
        ];

        if (isset($map[$key])) {
            $this->reset($map[$key]);
        } elseif ($key === 'price') {
            $this->minPrice = $this->lowestPrice;
            $this->maxPrice = $this->highestPrice;
        } elseif ($key === 'days') {
            $this->minday = $this->lowestDay;
            $this->maxday = $this->highestDay;
        } elseif ($key === 'safari') {
            $this->minSafari = $this->lowestSafari;
            $this->maxSafari = $this->highestSafari;
        }

        unset($this->allFiltersValue[$key]);
        $this->dispatch('filtersUpdated', $this->allFiltersValue);
    }

    public function removeFilterFromSidebar($key, $value = null)
    {
        // dd($key, $value);
        if ($value !== null && isset($this->allFiltersValue[$key]) && is_array($this->allFiltersValue[$key])) {
            $this->allFiltersValue[$key] = array_filter(
                $this->allFiltersValue[$key],
                fn($item) => trim($item) !== trim($value)
            );

            if (empty($this->allFiltersValue[$key])) {
                $this->removeFilter($key);
            }

            if (empty($this->allFiltersValue[$key])) {
                unset($this->allFiltersValue[$key]);
            }

            if ($key === 'stay_category') {
                $this->selectedStayCategories = [];
                if (!empty($this->allFiltersValue[$key])) {
                    $this->selectedStayCategories = StayCategory::whereIn('name', $this->allFiltersValue[$key])
                        ->pluck('stay_category_id')->toArray();
                }
            } else if ($key == 'inclusion') {
                $this->inclusion_select = [];
                if (!empty($this->allFiltersValue[$key])) {
                    $this->inclusion_select = Feature::whereIn('title', $this->allFiltersValue[$key])->pluck('features_id')->toArray();
                }
            } else if ($key == 'visit_purpose') {
                $this->theme_select = [];
                if (!empty($this->allFiltersValue[$key])) {
                    $this->theme_select = VisitPurpose::whereIn('name', $this->allFiltersValue[$key])->pluck('visit_purpose_id')->toArray();
                }
            } else if ($key === "best_time") {
                $this->bttv_selected = [];
                if (!empty($this->allFiltersValue[$key])) {
                    $this->bttv_selected = WeatherModel::whereIn('title', $this->allFiltersValue[$key])->pluck('park_weather_id')->toArray();
                }
            }
        } else {
            $this->removeFilter($key);
        }

        $this->dispatch('filtersUpdated', $this->allFiltersValue);
    }


    public function clearAllFromSidebar()
    {
        $this->clearAll();
    }


    public function render()
    {
        return view('livewire.front.common.safaries-side-bar');
    }
}
