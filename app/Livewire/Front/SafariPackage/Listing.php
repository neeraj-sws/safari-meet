<?php

namespace App\Livewire\Front\SafariPackage;

use Livewire\Component;
use App\Models\{
    Feature,
    Package,
    State,
    Park,
    Species,
    StayCategory,
    VisitPurpose,
    WeatherModel
};
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Cache;
use App\Helpers\UserHelper;

class Listing extends Component
{
    public $park_datas;
    public $stateSelect, $parkSelect, $speciesSelected;
    public $bttv_selected = [], $selectedStayCategories = [], $inclusion_select = [], $theme_select = [];
    public $minPrice, $maxPrice, $minday, $maxday, $minSafari, $maxSafari, $heroSecion = true, $allFiltersValue = [], $carousel;
    public $perPage = 12, $orderbyfilter, $page = 1;
    public $seoContents;

    protected $listeners = ['filtersUpdated' => 'applyFilters'];

    public function mount($carousel = null, $type = null, $species = null)
    {
        if ($carousel == 1) {
            $this->heroSecion = false;
        }

        if (!empty($species)) {
            if ($type == 1) {
                $this->speciesSelected = $species->id;
                $this->allFiltersValue['species'] = $species->name;
            } else if ($type == 2) {
                $this->parkSelect = $species->id;
                $this->allFiltersValue['park'] = $species->name;
            }
        }

        $this->park_datas = Park::select('park_id', 'name', 'slug', 'display_image')->take(12)->get();
        $this->page = 1;
        $this->seoContents = Cache::remember('safari-packages', 1440, function () {
            return UserHelper::SeoDetails('safari-packages');
        });
    }

    public function loadsafarisMore()
    {
        $this->page += 1;
    }

    #[Computed]
    public function packages()
    {
        $query = Package::select(
            'package_id',
            'title',
            'slug',
            'park_id',
            'display_image',
            'min_price_pp',
            'max_price_pp',
            'no_of_safari',
            'start_tour',
            'visit_purpose_id',
            'stay_category_id',
            'popular',
            'trending',
            'tour_highlights',
            'top_rated',
            'created_at'
        )
            ->with([
                'park:park_id,name,state_id',
                'park.state:state_id,name'
            ])
            ->where('status', 1)
            ->where('is_published', 1);

        if (empty($this->orderbyfilter)) {
            $query->orderBy('package_id', 'desc');
        }

        if ($this->stateSelect) {
            $query->whereHas('park.state', fn($q) => $q->where('state_id', $this->stateSelect));
        }

        if ($this->inclusion_select) {
            $query->whereHas('featuer_safaries', fn($q) => $q->whereIn('feature_id', $this->inclusion_select));
        }

        if ($this->parkSelect) {
            $query->where('park_id', $this->parkSelect);
        }

        if ($this->theme_select) {
            $query->whereIn('visit_purpose_id', $this->theme_select);
        }

        if ($this->bttv_selected) {
            $query->whereHas('park.parkBestTimes', function ($q) {
                $q->whereIn('weathers_id', $this->bttv_selected);
            });
        }

        if ($this->speciesSelected) {
            $parkIDs = Park::whereHas('ParkSpecies', fn($q) => $q->where('species_id', $this->speciesSelected))
                ->pluck('park_id');
            $query->whereIn('park_id', $parkIDs);
        }

        if ($this->selectedStayCategories) {
            $query->whereIn('stay_category_id', $this->selectedStayCategories);
        }

        if (is_numeric($this->minPrice) && is_numeric($this->maxPrice)) {
            $query->whereRaw('CAST(min_price_pp AS UNSIGNED) <= ?', [$this->maxPrice])
                ->whereRaw('CAST(max_price_pp AS UNSIGNED) >= ?', [$this->minPrice]);
        }

        if (is_numeric($this->minday) && is_numeric($this->maxday)) {
            $query->whereRaw('CAST(start_tour AS UNSIGNED) <= ?', [$this->maxday])
                ->whereRaw('CAST(start_tour AS UNSIGNED) >= ?', [$this->minday]);
        }

        if (is_numeric($this->minSafari) && is_numeric($this->maxSafari)) {
            $query->whereRaw('CAST(no_of_safari AS UNSIGNED) <= ?', [$this->maxSafari])
                ->whereRaw('CAST(no_of_safari AS UNSIGNED) >= ?', [$this->minSafari]);
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
            }
        }

        return $query->paginate($this->perPage, ['*'], 'page', $this->page);
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        // dd($this->packages);
        return view('livewire.front.safari-package.list', [
            'packages' => $this->packages,
        ])->layoutData([
                    'seoContents' => $this->seoContents,
                ]);
    }

    public function loadPackages()
    {
        // empty bhi reh sakta hai
    }


    public function applyFilters($filters)
    {
        // dd($filters);
        $this->resetFilters();
        $this->allFiltersValue = [];

        $map = [
            'state' => function ($val) {
                $this->stateSelect = State::where('name', $val)->value('state_id');
                $this->allFiltersValue['state'] = $val;
            },
            'park' => function ($val) {
                $this->parkSelect = Park::where('name', $val)->value('park_id');
                $this->allFiltersValue['park'] = $val;
            },
            'species' => function ($val) {
                $this->speciesSelected = Species::where('name', $val)->value('species_id');
                $this->allFiltersValue['species'] = $val;
            },
            'best_time' => function ($val) {
                $titles = array_map('trim', $val);
                $this->bttv_selected = WeatherModel::whereIn('title', $titles)->pluck('park_weather_id')->toArray();
                $this->allFiltersValue['best_time'] = $val;
            },
            'stay_category' => function ($val) {
                $name = array_map('trim', $val);
                $this->selectedStayCategories = StayCategory::whereIn('name', $name)->pluck('stay_category_id')->toArray();
                $this->allFiltersValue['stay_category'] = $val;
            },
            'inclusion' => function ($val) {
                $title = array_map('trim', $val);
                $this->inclusion_select = Feature::whereIn('title', $title)->pluck('features_id')->toArray();
                $this->allFiltersValue['inclusion'] = $val;
            },
            'visit_purpose' => function ($val) {
                $name = array_map('trim', $val);
                $this->theme_select = VisitPurpose::whereIn('name', $name)->pluck('visit_purpose_id')->toArray();
                $this->allFiltersValue['visit_purpose'] = $val;
            },
            'price' => function ($val) {
                $this->setRange($val, '₹(\d+)\s-\s₹(\d+)', 'minPrice', 'maxPrice');
                if (is_numeric($this->minPrice) && is_numeric($this->maxPrice) && $this->minPrice < $this->maxPrice) {
                    $this->allFiltersValue['price'] = "₹{$this->minPrice} - ₹{$this->maxPrice}";
                }
            },
            'days' => function ($val) {
                $this->setRange($val, '(\d+)\s-\s(\d+)', 'minday', 'maxday');
                if (is_numeric($this->minday) && is_numeric($this->maxday) && $this->minday < $this->maxday) {
                    $this->allFiltersValue['days'] = "{$this->minday} - {$this->maxday}";
                }
            },
            'safari' => function ($val) {
                $this->setRange($val, '(\d+)\s-\s(\d+)', 'minSafari', 'maxSafari');
                if (is_numeric($this->minSafari) && is_numeric($this->maxSafari) && $this->minSafari < $this->maxSafari) {
                    $this->allFiltersValue['safari'] = "{$this->minSafari} - {$this->maxSafari}";
                }
            },

        ];

        foreach ($filters as $key => $val) {
            if (!empty($val) && isset($map[$key])) {
                $map[$key]($val);
            }
        }
    }

    public function removeFilter($key)
    {
        unset($this->allFiltersValue[$key]);

        switch ($key) {
            case 'state':
                $this->stateSelect = null;
                break;
            case 'park':
                $this->parkSelect = null;
                break;
            case 'species':
                $this->speciesSelected = null;
                break;
            case 'best_time':
                $this->bttv_selected = [];
                break;
            case 'stay_category':
                $this->selectedStayCategories = [];
                break;
            case 'inclusion':
                $this->inclusion_select = [];
                break;
            case 'visit_purpose':
                $this->theme_select = [];
                break;
            case 'price':
                $this->minPrice = $this->maxPrice = null;
                break;
            case 'days':
                $this->minday = $this->maxday = null;
                break;
            case 'safari':
                $this->minSafari = $this->maxSafari = null;
                break;
            case 'orderby':
                $this->orderbyfilter = null;
                break;
        }

        $this->dispatch('sidebarRemoveFilter', $key);
    }

    public function removeFilterValue($key, $value)
    {
        // dd($key, $value);
        if (isset($this->allFiltersValue[$key]) && is_array($this->allFiltersValue[$key])) {
            $this->allFiltersValue[$key] = array_filter(
                $this->allFiltersValue[$key],
                fn($item) => trim($item) !== trim($value)
            );

            if (empty($this->allFiltersValue[$key])) {
                unset($this->allFiltersValue[$key]);
            }

            if ($key === 'stay_category') {
                $this->selectedStayCategories = [];
                if (!empty($this->allFiltersValue[$key])) {
                    $this->selectedStayCategories = StayCategory::whereIn('name', $this->allFiltersValue[$key])
                        ->pluck('stay_category_id')->toArray();
                }
            } else if ($key === 'inclusion') {
                $this->inclusion_select = [];
                if (!empty($this->allFiltersValue[$key])) {
                    $this->inclusion_select = Feature::whereIn('title', $this->allFiltersValue[$key])->pluck('features_id')->toArray();
                }
            } else if ($key === 'visit_purpose') {
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
        }

        $this->dispatch('sidebarRemoveFilter', $key, $value);
    }

    public function clearAll()
    {
        $this->resetFilters();
        $this->allFiltersValue = [];
        $this->dispatch('sidebarClearAll');
    }

    private function resetFilters()
    {
        $this->reset([
            'stateSelect',
            'parkSelect',
            'speciesSelected',
            'bttv_selected',
            'selectedStayCategories',
            'inclusion_select',
            'theme_select',
            'minPrice',
            'maxPrice',
            'minday',
            'maxday',
            'minSafari',
            'maxSafari',
            'orderbyfilter',
        ]);
    }

    private function setRange($val, $pattern, $minProp, $maxProp)
    {
        if (preg_match("/$pattern/", $val, $m)) {
            $this->$minProp = $m[1];
            $this->$maxProp = $m[2];
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
        }
    }
}
