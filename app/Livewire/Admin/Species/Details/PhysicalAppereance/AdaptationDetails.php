<?php

namespace App\Livewire\Admin\Species\Details\PhysicalAppereance;

use App\Models\AdaptationModel;
use Livewire\Component;

class AdaptationDetails extends Component
{
    public $showActivityModal = false, $species, $characterDetails;
    public $modalTitle;
    public $heading;
    public $speciesId, $adaptationData = [], $adaptationId, $description;

    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->characterDetails = $characterstic;
        $this->speciesId = $this->species->id;
    }

    public function render()
    {
        $this->adaptationData = AdaptationModel::where('species_id', $this->speciesId)->get();

        return view('livewire.admin.species.details.physical-appereance.adaptation-details');
    }

    public function addModel()
    {
        $this->resetValidation();
        $this->reset(['heading', 'description', 'adaptationId']);
        $this->modalTitle = "Add Adaptation";
        $this->showActivityModal = true;
        // $this->dispatch('initializeCKEditor');
    }

    public function hideAdaptation()
    {
        $this->resetValidation();
        $this->reset(['heading', 'description', 'adaptationId']);
        $this->showActivityModal = false;
    }

    public function deleteAdaptation($adaptationId)
    {
        AdaptationModel::findOrFail($adaptationId)->delete();
        $this->refreshAdaptationData();
    }

    public function addActivityToAdaptation($adaptationId)
    {
        $adaptation = AdaptationModel::findOrFail($adaptationId);

        $this->resetValidation();
        $this->reset(['heading', 'description']);
        $this->modalTitle = "Edit Adaptation";
        $this->showActivityModal = true;
        // $this->dispatch('initializeCKEditor');

        $this->adaptationId = $adaptation->id;
        $this->heading = $adaptation->title;
        $this->description = $adaptation->short_description;
    }

    public function storeActivity()
    {
        $this->validate(
            [
                'heading' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    function ($attribute, $value, $fail) {
                        if (trim($value) !== $value) {
                            $fail('Heading cannot have leading or trailing spaces.');
                        }
                    },
                ],
                'description' => 'required',
            ],
            [
                'heading.required'    => 'Heading is required.',
                'heading.string'      => 'Heading must be a valid string.',
                'heading.min'         => 'Heading must be at least 3 characters.',
                'heading.max'         => 'Heading may not be greater than 100 characters.',
                'heading.regex'       => 'Heading can only contain letters and single spaces between words.',
                'description.required' => 'The Adaptation field is required.',
            ]
        );

        if ($this->adaptationId) {
            $adaptation = AdaptationModel::find($this->adaptationId);
            $adaptation->title = ucwords($this->heading);
            $adaptation->short_description = $this->description;
            $adaptation->save();
        } else {
            AdaptationModel::create([
                'species_id' => $this->speciesId,
                'title' => $this->heading,
                'short_description' => $this->description,
            ]);
        }

        $this->reset(['heading', 'description', 'showActivityModal', 'adaptationId']);
        $this->refreshAdaptationData();
    }

    private function refreshAdaptationData()
    {
        $this->adaptationData = AdaptationModel::where('species_id', $this->speciesId)->get();
    }
}
