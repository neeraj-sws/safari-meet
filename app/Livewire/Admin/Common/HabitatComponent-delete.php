<?php

namespace App\Livewire\Admin\Common;

use App\Models\Habitat;
use App\Models\HabitatDetailsModel;
use Livewire\Component;

class HabitatComponent extends Component
{
    public $showActivityModal = false;
    public $modalTitle;
    public $heading;
    public $activities = [];
    public $speciesId;
    public $habitat, $habitatId;

    public function mount($id = null)
    {
        $this->speciesId = $id;
        $this->habitat = Habitat::with('details')->where('species_id', $this->speciesId)->first();
        if ($this->habitat) {
            $this->heading = $this->habitat->name;
        }
    }

    public function render()
    {
        $this->habitat = Habitat::with('details')->where('species_id', $this->speciesId)->first();
        return view('livewire.admin.common.habitat');
    }

    public function addModel()
    {
        $this->resetValidation();
        $this->reset(['activities']);
        $this->showActivityModal = true;
        $this->modalTitle = $this->habitat ? "Update Habitat" : "Add Habitat";
        $this->addActivity();
    }

    public function addActivity()
    {
        $this->activities[] = ['title' => '', 'short_description' => ''];
    }

    public function removeActivity($index)
    {
        unset($this->activities[$index]);
        $this->activities = array_values($this->activities);
    }

    public function deleteActivityFromHabitat($activityId)
    {
        HabitatDetailsModel::findOrFail($activityId)->delete();
        $this->habitat = Habitat::with('details')->where('species_id', $this->speciesId)->first();
    }

    public function storeActivity()
    {
        $this->validate([
            'heading' => 'required|string|max:255',
            'activities.*.title' => 'required|string|max:255',
            'activities.*.short_description' => 'required|string|max:1000',
        ]);

        // Create or update habitat
        $habitat = Habitat::updateOrCreate(
            ['species_id' => $this->speciesId],
            ['name' => $this->heading]
        );

        // Store details
        foreach ($this->activities as $item) {
            HabitatDetailsModel::create([
                'habitat_id' => $habitat->id,
                'title' => $item['title'],
                'short_description' => $item['short_description'],
            ]);
        }

        $this->reset(['activities', 'showActivityModal']);
        $this->heading = $habitat->name;
        $this->habitat = $habitat->load('details');
    }
}
