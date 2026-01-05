<?php

namespace App\Livewire\Admin\Species\Details\Lifestyle;

use App\Models\SpeciesLifestyleModel;
use Livewire\Component;

class Habitat extends Component
{
    public $species, $characterDetails, $pageTitle = "Habitat";
    public $adaptations_short_discription, $physicalAppereanceData;
    public $lifestyleData, $habitatt_short_description;

    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->characterDetails = $characterstic;
        $this->lifestyleData = SpeciesLifestyleModel::where('species_id', $this->species->id)->where('species_details_characterstics_id', $this->characterDetails['species_details_characterstic_id'])->first();
        if (!empty($this->lifestyleData)) {
            $this->habitatt_short_description = $this->lifestyleData->habitatt_short_description;
        }
        // $this->dispatch('initializeCKEditor');
    }

    public function render()
    {
        return view('livewire.admin.species.details.lifestyle.habitat');
    }

    public function store()
    {


        $this->validate([
            'habitatt_short_description' => 'required',
        ], [
            'habitatt_short_description.required' => 'The Habitat Short Description  field is required.',
        ]);

        if (!empty($this->lifestyleData)) {
            $this->lifestyleData->habitatt_short_description = $this->habitatt_short_description;
            $this->lifestyleData->save();
        } else {
            $this->lifestyleData = SpeciesLifestyleModel::create([
                'species_id' => $this->species->id,
                'species_details_characterstics_id' => $this->characterDetails['species_details_characterstic_id'],
                'habitatt_short_description' => $this->habitatt_short_description,
            ]);
        }
        $this->resetValidation();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }
}
