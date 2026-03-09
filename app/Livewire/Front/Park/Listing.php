<?php

namespace App\Livewire\Front\Park;

use App\Helpers\UserHelper;
use App\Models\Park;
use App\Models\ParkBestTimeModel;
use App\Models\ParkSpecies;
use App\Models\State;
use App\Models\ShareSafari;
use App\Models\StayCategory;
use App\Models\WeatherModel;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Listing  extends Component
{

    public $parks, $states, $species, $stayCategory, $park_datas, $shareSafaris, $BestTimesVisits;
    public $stateSelect = null, $speciesSelect = null, $parkSelect = null, $stayCategorySelect = null, $bestTimeSelect = [], $allFiltersValue = [];
    public $perPage = 6, $seoContents, $orderbyfilter, $totalCount = 0;

    public function mount()
    {
        $parks = Park::with('state:state_id,name,state_id')
            ->where('status', true)
            ->get(['park_id', 'name', 'state_id']);

        $stateIds = $parks->pluck('state_id')->unique()->values();

        $this->states = State::whereIn('state_id', $stateIds)->pluck('name', 'state_id');

        $parkSpecies = ParkSpecies::with('speciesList:species_id,name')
            ->whereIn('park_id', $parks->pluck('park_id'))
            ->get();

        $this->species = $parkSpecies
            ->filter(fn($item) => $item->speciesList)
            ->mapWithKeys(fn($item) => [$item->speciesList->id => $item->speciesList->name])
            ->unique()
            ->toArray();

        $this->BestTimesVisits = WeatherModel::where('status', 1)->get();

        $this->stayCategory = StayCategory::pluck('name', 'stay_category_id');

        $this->park_datas = $parks->pluck('name', 'park_id');

        $this->seoContents  = UserHelper::SeoDetails('park');
    }

    public function loadMore()
    {
        $this->perPage += 3;
    }


    #[Layout('components.layouts.guest')]
    public function render()
    {
        $query = Park::with(['state', 'parkBestTimes.weather', 'wildlife.species', 'parkSafariTypes.safari_type', 'parkspecies'])
            ->where('status', true);

        if ($this->stateSelect) {
            $query->where('state_id', $this->stateSelect);
        }

        if ($this->speciesSelect) {
            $query->whereHas('parkspecies', function ($q) {
                $q->where('species_id', $this->speciesSelect);
            });
        }

        if ($this->parkSelect) {
            $query->where('park_id', $this->parkSelect);
        }

        if ($this->stayCategorySelect) {
            $query->where('stay_category_id', $this->stayCategorySelect);
        }

        if (!empty($this->bestTimeSelect)) {
            $query->whereHas('parkBestTimes', function ($q) {
                $q->whereIn('weathers_id', $this->bestTimeSelect);
            });
        }

        if (!empty($this->orderbyfilter)) {
            switch ($this->orderbyfilter) {
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
                case 'orderby':
                    $this->orderbyfilter = null;
                    break;
            }
        }

        $this->totalCount = $query->count();
        $this->parks = $query->take($this->perPage)->get();

        return view('livewire.front.park.list')->layoutData([
            'seoContents' => $this->seoContents,
        ]);
    }

    public function firstTimeLoading(){
        
    }

    public function updatedStateSelect()
    {
        $states = State::select('state_id', 'name')->find($this->stateSelect);
        if ($states) {
            $this->allFiltersValue['state'] = $states->name;
        }
    }

    public function updatedSpeciesSelect()
    {

        $species = ParkSpecies::with('speciesList')->where('species_id', $this->speciesSelect)->first();
        if ($species && $species->speciesList) {
            $this->allFiltersValue['species'] = $species->speciesList->name;
        }
    }

    public function updatedParkSelect()
    {
        $park = Park::select('park_id', 'name')->find($this->parkSelect);
        if ($park) {
            $this->allFiltersValue['park'] = $park->name;
        }
    }

    public function updatedBestTimeSelect()
    {
        $BestTimesVisits = WeatherModel::whereIn('park_weather_id', $this->bestTimeSelect)->get();
        $titles = $BestTimesVisits->pluck('title')->unique()->toArray();
        $this->allFiltersValue['best_time'] = $titles;
    }


    public function clearAll()
    {
        $this->reset([
            'stateSelect',
            'speciesSelect',
            'parkSelect',
            'stayCategorySelect',
            'bestTimeSelect',
            'allFiltersValue',
            'orderbyfilter',
        ]);

        // $this->dispatch('filtersCleared');
    }

    public function removeFilter($filterKey)
    {
        switch ($filterKey) {
            case 'state':
                $this->reset('stateSelect');
                break;
            case 'species':
                $this->reset('speciesSelect');
                break;
            case 'park':
                $this->reset('parkSelect');
                break;
            case 'best_time':
                $this->reset('bestTimeSelect');
                break;
            case 'orderby':
                $this->orderbyfilter = null;
                break;
        }

        unset($this->allFiltersValue[$filterKey]);
    }

    public function removeFilterValue($filterKey, $value)
    {
        if ($filterKey === 'best_time') {
            $this->allFiltersValue['best_time'] = array_filter(
                $this->allFiltersValue['best_time'],
                fn($item) => $item !== $value
            );

            $weather = WeatherModel::where('title', $value)->first();
            if ($weather) {
                $this->bestTimeSelect = array_diff($this->bestTimeSelect, [$weather->id]);
            }

            if (empty($this->allFiltersValue['best_time'])) {
                unset($this->allFiltersValue['best_time']);
            }
        }
    }

    public function updatedOrderbyfilter()
    {

        switch ($this->orderbyfilter) {
            case 'popular':
                $this->allFiltersValue['orderby'] = 'Popular';
                break;
            case 'latest':
                $this->allFiltersValue['orderby'] = 'Latest';
                break;
            case 'trending':
                $this->allFiltersValue['orderby'] = 'Trending';
                break;
            case 'top':
                $this->allFiltersValue['orderby'] = 'Top Rated';
                break;
            default:
                $this->allFiltersValue['orderby'] = 'All';
                $this->orderbyfilter = null;
                break;
            case 'orderby':
                $this->orderbyfilter = null;
                break;
        }
    }
}
