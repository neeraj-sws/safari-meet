<?php

namespace App\Livewire\Admin\Park\Details\TravelTips;

use App\Models\ParkTraveltipsModel;
use Livewire\Component;

class WeatherInfo extends Component
{
    public $park, $characterDetails;
    public $travelTips, $weatherInfo;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->travelTips =  ParkTraveltipsModel::where('park_id', $this->park->id)->first();
        if (!empty($this->travelTips)) {
            $this->weatherInfo = $this->travelTips->weather;
        }
        $this->dispatch('initializeCKEditor');
    }
    public function render()
    {
        return view('livewire.admin.park.details.travel-tips.weather-info');
    }

    public function storeTraveTip()
    {
        $this->validate([
            'weatherInfo' => 'required',
        ]);
        if (empty($this->travelTips)) {

            ParkTraveltipsModel::create([
                'park_id' => $this->park->id,
                'weather' => $this->weatherInfo,
            ]);
        } else {
            $this->travelTips->weather = $this->weatherInfo;
            $this->travelTips->save();
        }
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Added Successfully']);
    }
}
