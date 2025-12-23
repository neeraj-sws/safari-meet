<?php

namespace App\Livewire\Front\Park\Details;

use App\Models\ParkDetailsDynamicTabs;
use Livewire\Component;

class DynamicTabComponent extends Component
{
    public $parkdetails, $characteristic, $tabData;

    public function mount($parkdetails = null, $characteristic = null)
    {
        $this->parkdetails = $parkdetails;
        $this->characteristic = $characteristic;
        $this->tabData = ParkDetailsDynamicTabs::where('park_id', $this->parkdetails->id)->where('park_details_characterstics_id',$this->characteristic->id)->first();
    }

    public function render()
    {
        return view('livewire.front.park.details.dynamic-tab-component');
    }
}
