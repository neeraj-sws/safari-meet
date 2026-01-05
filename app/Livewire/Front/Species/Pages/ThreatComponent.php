<?php

namespace App\Livewire\Front\Species\Pages;

use App\Models\SpeciesThreatModel;
use Livewire\Component;
use Livewire\Attributes\Layout;

class ThreatComponent extends Component
{
    public $species,$characterstic,$threatData,$showFull = false,$showFullConservation= false,$dietData,$traits;

    public function mount($species = null,$characterstic = null)
    {
        $this->species = $species;
        $this->characterstic = $characterstic;
        $this->threatData = SpeciesThreatModel::where('species_id',$species->id)->where('species_details_characterstics_id',$characterstic->id)->first();
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.species.pages.threat');
    }


}
