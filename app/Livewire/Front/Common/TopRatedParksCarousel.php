<?php

namespace App\Livewire\Front\Common;

use App\Models\Park;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class TopRatedParksCarousel extends Component
{
    public  $topParks = [];

    public function mount()
    {
        $this->loadTopParks();
    }

    protected function loadTopParks()
    {
        // Cache::forget('topParks');
        $this->topParks = Cache::remember('topParks', 1440, function () {
            return Park::where('status', 1)
                ->orderByDesc('top_rated')
                ->take(10)
                ->get();
        });
    }

    public function render()
    {
        return view('livewire.front.common.top-rated-parks-carousel');
    }
}
