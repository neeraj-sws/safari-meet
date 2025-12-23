<?php

namespace App\Livewire\Front\Park\Details;

use App\Models\ParkAboutSection;
use Livewire\Component;

class AboutParkComponent extends Component
{
    public $parkdetails, $characteristic,$aboutPark = [];

    public function mount($parkdetails = null, $characteristic = null)
    {
        $this->parkdetails = $parkdetails;
        $this->characteristic = $characteristic;
        $this->aboutPark = ParkAboutSection::where('park_id', $this->parkdetails->id)->get();
    }

    public function render()
    {
        return view('livewire.front.park.details.about-park-component');
    }
}
