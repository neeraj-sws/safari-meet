<?php

namespace App\Livewire\Admin\Common;

use App\Models\AdaptationDetailsModel;
use App\Models\AdaptationModel;
use App\Models\AppearanceModel;
use Livewire\Component;

class Appearance extends Component
{
    public $showActivityModal = false;
    public $modalTitle;
    public $heading;
    public $activity = [];
    public $speciesId, $appearanceData = [], $adaptationId;

    public function mount($id = null)
    {
        $this->speciesId = $id;
    }

    public function render()
    {
        $this->appearanceData = AppearanceModel::where('species_id', $this->speciesId)
            ->get();

        return view('livewire.admin.common.appearance');
    }

    public function addModel()
    {
        $this->resetValidation();
        $this->reset(['heading', 'activity', 'adaptationId']);
        $this->showActivityModal = true;
        $this->modalTitle = "Add Appearance";
        $this->addActivity();
    }

    public function addActivity()
    {
        $this->activity[] = [
            'title' => '',
            'short_distription' => '',
        ];
    }

    public function removeActivity($index)
    {
        unset($this->activity[$index]);
        $this->activity = array_values($this->activity);
    }


    public function deleteActivityFromAdaptation($activityId)
    {
        AppearanceModel::findOrFail($activityId)->delete();
        $this->appearanceData = AppearanceModel::where('species_id', $this->speciesId)
            ->get();
    }

    public function storeActivity()
    {

        $this->validate(
            [
                'activity.*.title' => 'required|string|max:255',
                'activity.*.short_distription' => 'required|string|max:1000',
            ],
            [
                'activity.*.title.required' => 'The activity title field is required.',
                'activity.*.short_distription.required' => 'The activity short description field is required.',
            ]
        );

        foreach ($this->activity as $item) {
            AppearanceModel::create([
                'species_id' => $this->speciesId,
                'title' => $item['title'],
                'short_distription' => $item['short_distription'],
            ]);
        }
        $this->reset(['heading', 'activity', 'showActivityModal', 'adaptationId']);
    }
}
