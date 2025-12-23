<?php

namespace App\Livewire\Admin\Common;

use App\Models\ConservationModel;
use App\Models\ConservationDetailsModel;
use Livewire\Component;

class ConservationComponent extends Component
{
    public $showActivityModal = false;
    public $modalTitle;
    public $heading;
    public $activities = [];
    public $speciesId;
    public $conservation;

    public function mount($id = null)
    {
        $this->speciesId = $id;
        $this->loadConservation();
    }

    public function render()
    {
        $this->loadConservation(); // Ensure fresh data
        return view('livewire.admin.common.conservation');
    }

    protected function loadConservation()
    {
        $this->conservation = ConservationModel::with('details')
            ->where('species_id', $this->speciesId)
            ->first();

        $this->heading = $this->conservation?->name;
    }

    public function addModel()
    {
        $this->resetValidation();
        $this->reset(['activities']);
        $this->showActivityModal = true;
        $this->modalTitle = $this->conservation ? 'Update Conservation' : 'Add Conservation';
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

    public function deleteConservationDetail($detailId)
    {
        ConservationDetailsModel::findOrFail($detailId)->delete();
        $this->loadConservation();
    }

    public function storeActivity()
    {
        $this->validate([
            'heading' => 'required|string|max:255',
            'activities.*.title' => 'required|string|max:255',
            'activities.*.short_description' => 'required|string|max:1000',
        ]);

        $conservation = ConservationModel::updateOrCreate(
            ['species_id' => $this->speciesId],
            ['name' => $this->heading]
        );

        foreach ($this->activities as $item) {
            ConservationDetailsModel::create([
                'conservation_id' => $conservation->id,
                'title' => $item['title'],
                'short_description' => $item['short_description'],
            ]);
        }

        $this->reset(['activities', 'showActivityModal']);
        $this->loadConservation();
    }
}
