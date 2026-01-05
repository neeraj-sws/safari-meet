<?php

namespace App\Livewire\Admin\Species\Details\PhysicalAppereance;

use App\Models\SpeciesPhysicalAppereancesModel;
use Livewire\Component;

class Adaptations extends Component
{
    public $species, $characterDetails,$pageTitle ="Adaptations";
    public $adaptations_short_discription, $physicalAppereanceData;

    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->characterDetails = $characterstic;
        $this->physicalAppereanceData = SpeciesPhysicalAppereancesModel::where('species_id', $this->species->id)->where('species_details_characterstics_id', $this->characterDetails['species_details_characterstic_id'])->first();
        if (!empty($this->physicalAppereanceData)) {
            $this->adaptations_short_discription = $this->physicalAppereanceData->adaptation_description;
        }
        $this->dispatch('initializeCKEditor');
    }
    public function render()
    {
        return view('livewire.admin.species.details.physical-appereance.adaptations');
    }

    public function store()
    {

        $rules = [
            'adaptations_short_discription' => 'required|string',
        ];

        $messages = [
            'adaptations_short_discription.required' => 'The Adaptations  is required.',
            'adaptations_short_discription.string'   => 'The Adaptations  must be a string.',
        ];

        $this->validate($rules, $messages);

        if (!empty($this->physicalAppereanceData)) {
            $this->physicalAppereanceData->adaptation_description = $this->adaptations_short_discription;
            $this->physicalAppereanceData->save();
        } else {
            $this->physicalAppereanceData =  SpeciesPhysicalAppereancesModel::create([
                'species_id' => $this->species->id,
                'species_details_characterstics_id' => $this->characterDetails['species_details_characterstic_id'],
                'adaptation_description' => $this->adaptations_short_discription,
            ]);
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }
}
