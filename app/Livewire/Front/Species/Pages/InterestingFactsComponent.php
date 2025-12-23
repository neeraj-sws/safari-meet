<?php

namespace App\Livewire\Front\Species\Pages;

use App\Models\SpeciesInterestingFactsModel;
use Livewire\Component;
use Livewire\Attributes\Layout;

class InterestingFactsComponent extends Component
{
    public $species,$characterstic,$factData;

    public function mount($species = null,$characterstic = null)
    {
        $this->species = $species;
        $this->characterstic = $characterstic;
        $this->factData = SpeciesInterestingFactsModel::where('species_id',$species->id)->where('species_details_characterstics_id',$characterstic->id)->first();

    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.species.pages.interesting-facts');
    }


}
