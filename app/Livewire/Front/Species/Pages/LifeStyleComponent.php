<?php

namespace App\Livewire\Front\Species\Pages;

use App\Models\DietModel;
use App\Models\SpeciesLifestyleModel;
use Livewire\Component;
use Livewire\Attributes\Layout;

class LifeStyleComponent extends Component
{
    public $species,$characterstic,$lifestyleData,$showFull = false,$showFullDiet= false,$showFullHabitat=false,$dietData,$traits;

    public function mount($species = null,$characterstic = null)
    {
        $this->species = $species;
        $this->characterstic = $characterstic;
        $this->lifestyleData = SpeciesLifestyleModel::where('species_id',$species->id)->where('species_details_characterstics_id',$characterstic->id)->first();
        $this->dietData = DietModel::with('details')->where('species_id',$species->id)->get();
        // dd($this->dietData);
        // $this->traits = json_decode($this->physicalData->trait ?? '{}', true);

        // dd($this->physicalData);
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.species.pages.life-style');
    }


}
