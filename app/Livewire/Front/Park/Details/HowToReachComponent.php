<?php

namespace App\Livewire\Front\Park\Details;

use App\Models\ParkReachability;
use Livewire\Component;

class HowToReachComponent extends Component
{
    public $parkdetails, $characteristic, $howToReach = [];

    public function mount($parkdetails = null, $characteristic = null)
    {
        $this->parkdetails = $parkdetails;
        $this->characteristic = $characteristic;

        $this->howToReach = ParkReachability::with(['reachabilityDistance.cityData','reachability'])->where('park_id', $this->parkdetails->id)->get();
        // dd($this->howToReach->toArray());
    }

    public function render()
    {
        return view('livewire.front.park.details.how-to-reach-component');
    }
}
