<?php

namespace App\Livewire\Admin\Species\Details\DynamicTab;

use App\Models\SpeciesDetailsCharactersticModel;
use App\Models\SpeciesDetailsDynamicTabs;
use Livewire\Component;

class DynamicTabComponent extends Component
{
    public $short_description;
    public $species, $characterDetails, $character;
    public $pageTitle = '';
    public $existingFact, $activeTabe;

    public function mount($species = null, $characterstic = null, $character = null)
    {
        $this->species = $species;
        $this->characterDetails = $characterstic;
        $this->character = $character;
        $this->activeTabe = 'InterestingFacts';
        $this->pageTitle = $this->characterDetails['title'];

        $this->existingFact = SpeciesDetailsDynamicTabs::where([
            'species_id' => $this->species->id,
            'species_details_characterstics_id' => $this->characterDetails['species_details_characterstic_id'],
        ])->first();

        if ($this->existingFact) {
            $this->short_description = $this->existingFact->short_description;
        }
        // $this->dispatch('initializeCKEditor');
    }
    public function render()
    {
        return view('livewire.admin.species.details.dynamic-tab.dynamic-tab-component');
    }

    public function store()
    {
        $this->validate([
            'short_description' => 'required',
        ], [
            'short_description.required' => 'The ' .$this->pageTitle .' Short Description field is required.',
        ]);

        if ($this->existingFact) {
            $this->existingFact->update([
                'short_description' => $this->short_description,
            ]);
        } else {
            $this->existingFact = SpeciesDetailsDynamicTabs::create([
                'species_id' => $this->species->id,
                'species_details_characterstics_id' => $this->characterDetails['species_details_characterstic_id'],
                'short_description' => $this->short_description,
                'key' =>  $this->species->slug,
            ]);
        }

        $this->resetValidation();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' saved successfully.'
        ]);
    }

    public function changeTab($value)
    {
        $this->activeTabe = $value;
    }

    public function toggleStatus($id)
    {
        $detailTabs = SpeciesDetailsCharactersticModel::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('species-status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
