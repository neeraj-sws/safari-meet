<?php

namespace App\Livewire\Front\Park\Details;

use App\Models\ParkKeyInfoModel;
use Livewire\Component;

class KeyInfoComponent extends Component
{
    public $parkdetails, $characteristic,$keyInfo;

    public function mount($parkdetails = null, $characteristic = null)
    {
        $this->parkdetails = $parkdetails;
        $this->characteristic = $characteristic;
        $this->keyInfo = ParkKeyInfoModel::where('park_id',$this->parkdetails->id)->first();
    }
    public function render()
    {
        return view('livewire.front.park.details.key-info-component');
    }
}
