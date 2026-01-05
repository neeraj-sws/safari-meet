<?php

namespace App\Livewire\Front\Park\Details;

use App\Models\ParkSpecies;
use Livewire\Component;

class WildlifeYouMaySeeComponent extends Component
{
    public $parkdetails, $characteristic;
    public $perPage = 9;

    public function mount($parkdetails = null, $characteristic = null)
    {
        $this->parkdetails = $parkdetails;
        $this->characteristic = $characteristic;
    }

    public function loadMore()
    {
        $this->perPage += 6;
    }

    public function render()
    {
        $parkSpecies = ParkSpecies::with('speciesList')
            ->where('park_id', $this->parkdetails->id)
            ->take($this->perPage)
            ->get();

        $totalCount = ParkSpecies::where('park_id', $this->parkdetails->id)->count();

        return view('livewire.front.park.details.wildlife-you-may-see-component', [
            'parkSpecies' => $parkSpecies,
            'totalCount' => $totalCount
        ]);
    }
}
