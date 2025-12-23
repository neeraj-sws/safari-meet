<?php

namespace App\Livewire\Front\Species\Pages;

use App\Livewire\Admin\Comman\Adaptations;
use App\Models\AdaptationModel;
use App\Models\DietModel;
use App\Models\SpeciesLifestyleModel;
use App\Models\SpeciesPhysicalAppereancesModel;
use Livewire\Component;
use Livewire\Attributes\Layout;


class PhysicalAppereanceComponent extends Component
{
    public $species, $characterstic, $physicalData, $showFull = false, $adaptationData;
    public $lifestyleData,$dietData=[],$showFullDiet= false,$showFullHabitat=false,$traits;

    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->characterstic = $characterstic;
        $this->physicalData = SpeciesPhysicalAppereancesModel::where('species_id', $species->id)->where('species_details_characterstics_id', $characterstic->id)->first();
        $this->adaptationData = AdaptationModel::where('species_id', $species->id)->get();
        $this->traits = json_decode($this->physicalData->trait ?? '{}', true);
        $this->lifestyleData = SpeciesLifestyleModel::where('species_id', $species->id)->where('species_details_characterstics_id', $characterstic->id)->first();
        $this->dietData = DietModel::where('species_id', $species->id)->get();

        // dd($this->physicalData);
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.species.pages.physical-appereance');
    }
}
