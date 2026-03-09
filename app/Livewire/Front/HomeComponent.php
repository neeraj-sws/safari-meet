<?php

namespace App\Livewire\Front;

use App\Helpers\UserHelper;
use App\Models\HomePageBannerModel;
use App\Models\Species;
use App\Models\ShareSafari;
use App\Models\Park;
use App\Models\ParkSpecies;
use App\Models\State;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Cache;

class HomeComponent extends Component
{
    public $species, $shareSafaris, $parks, $perPage = 3, $homePageBanner, $stateLists = [], $parkLists = [], $parkSearchPage = false;
    public $destination, $park, $selectspecies, $speciesList = [];
    public $seoContents;


    public function mount()
    {
        // Cache::forget('homePageBanner');
        // Cache::forget('stateLists');
        // Cache::forget('speciesListHome');
        // Cache::forget('parkListHome');
        // Cache::forget('homeSeo');

        $this->homePageBanner = Cache::remember('homePageBanner', 1440, function () {
            return HomePageBannerModel::where('status', true)->first();
        });

        $this->stateLists = Cache::remember('stateLists', 1440, function () {
            return State::has('parkState')->with('parkState')->get();
        });

        $this->species = Cache::remember('speciesListHome', 1440, function () {
            return Species::where('status', 1)->where('top_species', 1)->inRandomOrder()->limit(6)->get();
        });

        $this->parks = Cache::remember('parkListHome', 1440, function () {
            return Park::with('state')->where('status', 1)->orderBy('top_rated', 'DESC')->select('park_id', 'name', 'state_id', 'display_image', 'slug')->take(10)->get();
        });

        $this->shareSafaris = ShareSafari::with(['park.state', 'organizer'])
            ->where('status', 1)
            ->where('is_approved', 1)
            ->latest()
            ->take(3)
            ->get();

        $this->seoContents = Cache::remember('homeSeo', 1440, function () {
            return UserHelper::SeoDetails('home');
        });
    }



    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.home-component')->layoutData([
            'seoContents' => $this->seoContents,
        ]);
    }

    public function updatedDestination()
    {
        $this->parkLists = Park::where('state_id', $this->destination)->get();
    }

    public function updatedPark()
    {
        $this->speciesList = ParkSpecies::has('speciesList')
            ->with('speciesList')
            ->where('park_id', $this->park)
            ->get();
    }

    public function SeachList()
    {
        if (($this->destination != null) && ($this->park != null)) {
            $park =   Park::find($this->park);
            return redirect()->route('park.detail', $park->slug);
        } else {
            return redirect()->route('search-result', base64_encode($this->destination));
        }
    }
}
