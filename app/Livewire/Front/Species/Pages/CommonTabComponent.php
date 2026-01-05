<?php

namespace App\Livewire\Front\Species\Pages;

use App\Models\SpeciesDetailsDynamicTabs;
use Livewire\Component;
use Livewire\Attributes\Layout;

class CommonTabComponent extends Component
{
    public $species = '',$characterstic = '',$tabData = '';

    public function mount($species = null,$characterstic = null)
    {

        $this->species = $species;
        $this->characterstic = $characterstic;
       if(!empty($species) && !empty($characterstic)){
           $this->tabData = SpeciesDetailsDynamicTabs::where('species_id',$species->id)->where('species_details_characterstics_id',$characterstic->id)->first();
       }

    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.species.pages.common-tab');
    }


}
