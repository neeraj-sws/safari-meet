<?php

namespace App\Livewire\Admin\Common;

use App\Models\ThreatModel;
use Livewire\Component;

class ThreatsCommanComponent extends Component
{
    public $showActivityModal = false;
    public $modalTitle = 'Add Threat';
    public $activities = [];
    public $speciesId;
    public $threats = [];

    public function mount($id = null)
    {
        $this->speciesId = $id;
    }

    public function render()
    {
        $this->threats = ThreatModel::where('species_id', $this->speciesId)->get();
        return view('livewire.admin.comman.threat');
    }

    public function addModel()
    {
        $this->resetValidation();
        $this->reset(['activities']);
        $this->showActivityModal = true;
        $this->modalTitle = "Add Threat";
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

    public function deleteThreat($threatId)
    {
        ThreatModel::findOrFail($threatId)->delete();
        $this->threats = ThreatModel::where('species_id', $this->speciesId)->get();
    }

    public function storeActivity()
    {
        $this->validate([
            'activities.*.title' => 'required|string|max:255',
            'activities.*.short_description' => 'required|string|max:1000',
        ]);

        foreach ($this->activities as $item) {
            ThreatModel::create([
                'species_id' => $this->speciesId,
                'title' => $item['title'],
                'short_distription' => $item['short_description'],
            ]);
        }

        $this->reset(['activities', 'showActivityModal']);
    }
}
