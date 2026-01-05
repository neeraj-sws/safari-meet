<?php

namespace App\Livewire\Admin\Species\Details\IntrestingFacts;

use App\Models\SpeciesDetailsCharactersticModel;
use App\Models\SpeciesInterestingFactsModel;
use Livewire\Component;

class IntrestingFactsComponent extends Component
{
    public $short_description;
    public $species, $characterDetails;
    public $pageTitle = 'Interesting Facts';
    public $existingFact, $activeTabe;

    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->characterDetails = $characterstic;
        $this->activeTabe = 'interesting-facts';
        $this->existingFact = SpeciesInterestingFactsModel::where([
            'species_id' => $this->species->id,
            'species_details_characterstics_id' => $this->characterDetails['species_details_characterstic_id'],
        ])->first();

        if ($this->existingFact) {
            $this->short_description = $this->existingFact->short_description;
        }
        $subActiveTabName = request()->query('subtab');
        if (!empty($subActiveTabName)) {
            $this->activeTabe = $subActiveTabName;
        }
        // $this->dispatch('initializeCKEditor');
    }

    public function render()
    {
        return view('livewire.admin.species.details.intresting-facts.intresting-facts-component');
    }

    public function store()
    {
        $this->validate([
            'short_description' => 'required',
        ], [
            'short_description.required' => 'The Intresting Facts Short Description field is required.',
        ]);

        if ($this->existingFact) {
            $this->existingFact->update([
                'short_description' => $this->short_description,
            ]);
        } else {
            $this->existingFact = SpeciesInterestingFactsModel::create([
                'species_id' => $this->species->id,
                'species_details_characterstics_id' => $this->characterDetails['species_details_characterstic_id'],
                'short_description' => $this->short_description,
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
