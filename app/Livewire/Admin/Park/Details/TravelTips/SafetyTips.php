<?php

namespace App\Livewire\Admin\Park\Details\TravelTips;

use App\Models\ParkTraveltipsModel;
use Livewire\Component;

class SafetyTips extends Component
{
    public $park, $characterDetails, $travelTips, $safetyTips;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->travelTips =  ParkTraveltipsModel::where('park_id', $this->park->id)->first();
        if (!empty($this->travelTips)) {
            $this->safetyTips = $this->travelTips->safetyTips;
        }
        // $this->dispatch('initializeCKEditor');
    }

    public function render()
    {
        return view('livewire.admin.park.details.travel-tips.safety-tips');
    }

    public function storeTraveTip()
    {
        $this->validate([
            'safetyTips' => 'required',
        ]);

        if (empty($this->travelTips)) {

            ParkTraveltipsModel::create([
                'park_id' => $this->park->id,
                'safetyTips' => $this->safetyTips,
            ]);
        } else {
            $this->travelTips->safetyTips = $this->safetyTips;
            $this->travelTips->save();
        }
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Added Successfully']);
    }
}
