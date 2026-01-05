<?php

namespace App\Livewire\Admin\Park\Details\Information;

use App\Models\ParkInformationModel;
use Livewire\Component;

class Information extends Component
{
    public $pageTitle = "Safari Information", $park, $characterDetails, $information, $informationData;
    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->informationData =  ParkInformationModel::where('park_id', $this->park->id)->first();
        if (!empty($this->informationData)) {
            $this->information = $this->informationData->information;
        }
         $this->dispatch('initializeCKEditor');
    }
    public function render()
    {
        return view('livewire.admin.park.details.information.information');
    }

    public function store()
    {
        $this->validate([
            'information' => 'required',
        ]);

        if (empty($this->informationData)) {
            ParkInformationModel::create([
                'park_id' => $this->park->id,
                'information' => $this->information,
            ]);
        } else {
            $this->informationData->information = $this->information;
            $this->informationData->save();
        }
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }
}
