<?php

namespace App\Livewire\Front\Park\Details;

use App\Models\ParkBestTimeVistModel;
use App\Models\ParkTraveltipsModel;
use App\Models\ParkWhatToCarryModel;
use Livewire\Component;

class TravelTipsComponent extends Component
{
    public $parkdetails, $characteristic;
    public $BestTimeToVisit = [], $travelTips, $whatToCarry = [];

    public function mount($parkdetails = null, $characteristic = null)
    {
        $this->parkdetails = $parkdetails;
        $this->characteristic = $characteristic;

        $this->BestTimeToVisit = ParkBestTimeVistModel::where('park_id', $this->parkdetails->id)->get();
        $this->travelTips = ParkTraveltipsModel::where('park_id', $this->parkdetails->id)->first();
        $this->whatToCarry = ParkWhatToCarryModel::where('park_id', $this->parkdetails->id)->get();
    }

    public function render()
    {

        return view('livewire.front.park.details.travel-tips-component');
    }
}
