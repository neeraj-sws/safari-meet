<?php

namespace App\Livewire\Front\Species\Pages;

use App\Models\SpeciesOverviewModel;
use Livewire\Component;
use Livewire\Attributes\Layout;

class OverViewComponent extends Component
{
    public $species,$characterstic,$overViewData,$showFull = false;

    public function mount($species = null,$characterstic = null)
    {
        $this->species = $species;
        $this->characterstic = $characterstic;
        $this->overViewData = SpeciesOverviewModel::with(['category','family','genus'])->where('species_id',$species->id)->where('species_details_characterstics_id',$characterstic->id)->first();
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.species.pages.over-view');
    }


}
