<?php

namespace App\Livewire\Admin\Common;

use App\Models\FactsModel;
use Livewire\Component;

class FactsComponent extends Component
{
    public $showActivityModal = false;
    public $modalTitle = 'Add Fact';
    public $activities = [];
    public $speciesId;
    public $facts = [];

    public function mount($id = null)
    {
        $this->speciesId = $id;
    }

    public function render()
    {
        $this->facts = FactsModel::where('species_id', $this->speciesId)->get();
        return view('livewire.admin.common.facts');
    }

    public function addModel()
    {
        $this->resetValidation();
        $this->reset(['activities']);
        $this->showActivityModal = true;
        $this->modalTitle = "Add Fact";
        $this->addActivity();
    }

    public function addActivity()
    {
        $this->activities[] = [
            'title' => '',
            'short_description' => '',
        ];
    }

    public function removeActivity($index)
    {
        unset($this->activities[$index]);
        $this->activities = array_values($this->activities);
    }

    public function deleteFact($factId)
    {
        FactsModel::findOrFail($factId)->delete();
        $this->facts = FactsModel::where('species_id', $this->speciesId)->get();
    }

    public function storeActivity()
    {
        $this->validate([
            'activities.*.title' => 'required|string|max:255',
            'activities.*.short_description' => 'required|string|max:1000',
        ]);

        foreach ($this->activities as $item) {
            FactsModel::create([
                'species_id' => $this->speciesId,
                'title' => $item['title'],
                'short_description' => $item['short_description'],
            ]);
        }

        $this->reset(['activities', 'showActivityModal']);
    }
}
