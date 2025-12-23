<?php

namespace App\Livewire\Front\Park\Details;

use App\Models\ParkInformationModel;
use App\Models\ParkKeyInfoModel;
use App\Models\ParkSafariTime;
use App\Models\ParkZoneModel;
use Livewire\Component;

class SafariInformationComponent extends Component
{
    public $parkdetails, $characteristic, $safariInformation, $parkZone = [], $parkTimings = [];

    public function mount($parkdetails = null, $characteristic = null)
    {
        $this->parkdetails = $parkdetails;
        $this->characteristic = $characteristic;
        $this->safariInformation = ParkInformationModel::where('park_id', $this->parkdetails->id)->first();
        $this->parkZone = ParkZoneModel::where('park_id', $this->parkdetails->id)->get();
        $this->parkTimings = ParkSafariTime::with(['details','weather'])->where('park_id', $this->parkdetails->id)->get();
        // dd($this->parkTimings->toArray());
    }

    public function render()
    {
        return view('livewire.front.park.details.safari-information-component');
    }
}
