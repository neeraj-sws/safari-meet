<?php

namespace App\Livewire\Front\SharedSafari;

use App\Helpers\SettingHelper;
use Livewire\Component;
use App\Models\{
    Feature,
    JoinSharedSafari,
    ShareSafari,
    State,
    Species,
    Park,
    ParkSpecies,
    StayCategory,
    VisitPurpose,
    SafariConversation,
    WeatherModel
};
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Helpers\UserHelper;

#[Layout('components.layouts.guest')]
class Listing extends Component
{
    public $states = [],
    $parks = [],
    $theme_select = [],
    $inclusion_select = [],
    $parkSelect,
    $stateSelect,
    $park_datas,
    $stayCategory = [],
    $selectedStayCategories = [],
    $heroSecion = true,
    $species = [];

    public $perPage = 12,
    $allFiltersValue = [],
    $speciesSelected,
    $page = 1;

    public $lowestPrice, $highestPrice, $lowestDay, $highestDay, $lowestSafari, $highestSafari;
    public $minPrice, $maxPrice, $minday, $maxday, $minSafari, $maxSafari, $orderbyfilter, $showBookedSafari;
    protected $listeners = ['filtersUpdated' => 'applyFilters'];
    public $seoContents;

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
        $this->showBookedSafari = SettingHelper::get('publish_show_booked_shared_safari', 0);
        $this->page = 1;

        $this->seoContents = Cache::remember('join-shared-safari', 1440, function () {
            return UserHelper::SeoDetails('join-shared-safari');
        });
    }

    public function loadMore()
    {
        $this->page += 1;
        $this->dispatch('scrollToTop');
    }

    public function updatedPage()
    {
        $this->dispatch('scrollToTop');
    }

    #[Computed]
    public function shareSafaris()
    {
        $query = ShareSafari::select(
            'shared_safari_id',
            'title',
            'slug',
            'safari_park_id',
            'display_image',
            'min_price_pp',
            'max_price_pp',
            'no_of_safari',
            'share_seats',
            'day',
            'visit_purpose_id',
            'stay_category_id',
            'is_seat_full',
            'popular',
            'trending',
            'top_rated',
            'created_at',
            'organized_by',
            'organized_type'
        )
            ->with([
                'park:park_id,name,state_id',
                'park.state:state_id,name',
                'organizer:user_id,name'
            ])
            ->where('status', 1)
            ->where('is_approved', 1)
            ->whereDate('day', '>', Carbon::today());

        if (empty($this->orderbyfilter)) {
            $query->orderBy('shared_safari_id', 'desc');
        }

        if (!$this->showBookedSafari) {
            $query->where('is_seat_full', 0);
        }

        if ($this->stateSelect) {
            $query->whereHas('park.state', fn($q) => $q->where('state_id', $this->stateSelect));
        }

        if ($this->speciesSelected) {
            $parkID = Park::whereHas(
                'ParkSpecies',
                fn($q) => $q->where('species_id', $this->speciesSelected)
            )->pluck('park_id');
            $query->whereHas('park', fn($q) => $q->whereIn('park_id', $parkID));
        }

        if ($this->inclusion_select) {
            $query->whereHas('featuer_safaries', fn($q) => $q->whereIn('feature_id', $this->inclusion_select));
        }

        if ($this->parkSelect) {
            $query->where('safari_park_id', $this->parkSelect);
        }

        if ($this->theme_select) {
            $query->whereIn('visit_purpose_id', $this->theme_select);
        }

        if (is_numeric($this->minPrice) && is_numeric($this->maxPrice)) {
            $query->whereRaw('CAST(min_price_pp AS UNSIGNED) <= ?', [$this->maxPrice])
                ->whereRaw('CAST(max_price_pp AS UNSIGNED) >= ?', [$this->minPrice]);
        }

        if (is_numeric($this->minSafari) && is_numeric($this->maxSafari)) {
            $query->whereRaw('CAST(no_of_safari AS UNSIGNED) <= ?', [$this->maxSafari])
                ->whereRaw('CAST(no_of_safari AS UNSIGNED) >= ?', [$this->minSafari]);
        }

        if (!empty($this->selectedStayCategories)) {
            $query->whereIn('stay_category_id', $this->selectedStayCategories);
        }

        if (is_numeric($this->minday) && is_numeric($this->maxday)) {
            $query->whereBetween('day', [Carbon::today()->addDays($this->minday), Carbon::today()->addDays($this->maxday)]);
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

    public function render()
    {
        return view('livewire.front.shared-safari.list', [
            'shareSafaris' => $this->shareSafaris,
        ])->layoutData([
                    'seoContents' => $this->seoContents,
                ]);
    }

    public function firstTimeLoader()
    {
        // empty bhi reh sakta hai
    }

    public function applyFilters($filters)
    {
        $this->resetFilters();
        $this->allFiltersValue = [];
        $this->page = 1; // Reset to page 1 when filters are applied

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
            'stay_category' => function ($val) {
                $name = array_map('trim', $val);
                $this->selectedStayCategories = StayCategory::whereIn('name', $name)->pluck('stay_category_id')->toArray();
                $this->allFiltersValue['stay_category'] = $name;
            },
            'inclusion' => function ($val) {
                $title = array_map('trim', $val);
                $this->inclusion_select = Feature::whereIn('title', $title)->pluck('features_id')->toArray();
                $this->allFiltersValue['inclusion'] = $title;
            },
            'visit_purpose' => function ($val) {
                $name = array_map('trim', $val);
                $this->theme_select = VisitPurpose::whereIn('name', $name)->pluck('visit_purpose_id')->toArray();
                $this->allFiltersValue['visit_purpose'] = $val;
            },
            'price' => function ($val) {
                $this->setRange($val, '₹(\d+)\s-\s₹(\d+)', 'minPrice', 'maxPrice');
                if ($this->minPrice < $this->maxPrice) {
                    $this->allFiltersValue['price'] = "₹{$this->minPrice} - ₹{$this->maxPrice}";
                }
            },
            'days' => function ($val) {
                $this->setRange($val, '(\d+)\s-\s(\d+)', 'minday', 'maxday');
                if ($this->minday < $this->maxday) {
                    $this->allFiltersValue['days'] = "{$this->minday} - {$this->maxday}";
                }
            },
            'safari' => function ($val) {
                $this->setRange($val, '(\d+)\s-\s(\d+)', 'minSafari', 'maxSafari');
                if ($this->minSafari < $this->maxSafari) {
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
        $this->page = 1;

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
        $this->page = 1; // Reset to page 1 when filter value is removed

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
            }
        }

        $this->dispatch('sidebarRemoveFilter', $key, $value);
    }

    public function clearAll()
    {
        $this->resetFilters();
        $this->allFiltersValue = [];
        $this->page = 1;
        $this->dispatch('sidebarClearAll');
    }

    private function resetFilters()
    {
        $this->reset([
            'stateSelect',
            'parkSelect',
            'speciesSelected',
            'theme_select',
            'inclusion_select',
            'selectedStayCategories',
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
            case 'orderby':
                $this->orderbyfilter = null;
                break;
        }
    }

    public function joinsafari($id)
    {
        $safari = ShareSafari::find($id);
        if (!empty($safari)) {
            $sharedSafari = JoinSharedSafari::firstOrCreate([
                'user_id' => Auth::guard('web')->id(),
                'share_safari_id' => $safari->id,
            ]);

            $conversation = SafariConversation::where('share_safari_id', $safari->id)
                ->where(function ($q) use ($safari) {
                    $q->where('creator_id', $safari->organized_by)
                        ->where('participant_id', Auth::guard('web')->id());
                })
                ->first();

            if (!$conversation) {
                $conversation = SafariConversation::create([
                    'share_safari_id' => $safari->id,
                    'creator_id' => $safari->organized_by,
                    'participant_id' => Auth::guard('web')->id(),
                    'organized_type' => $safari->organized_type,
                ]);
            }

            $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => "Shared Safari Join Successfully",
            ]);
        } else {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => "Something went wrong",
            ]);
        }
    }

    public function deletejoinsafari($id)
    {
        $join_safari = JoinSharedSafari::find($id);
        if (!empty($join_safari)) {
            $join_safari->delete();
            $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => "Leave Shared Safari  Successfully",
            ]);
        } else {
            return $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => "Something went wrong",
            ]);
        }
    }
}
