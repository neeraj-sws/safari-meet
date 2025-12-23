<?php

namespace App\Livewire\Admin\Species\Details;

use App\Models\Species;
use App\Models\SpeciesDetailsCharactersticModel as DetailsCharactersticModel;
use App\Helpers\ImageHelper;
use App\Models\SpeciesCharacterstic;
use App\Models\SpeciesFamilyModel;
use App\Models\SpeciesGenusModel;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class SpeciesDetails extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $editId, $deleteId, $previousImage, $display_image, $isEditing = false, $textEditor;
    public $modalTitle = 'Add', $pageTitle = 'Species Details';
    public $search = '', $name, $characterstics = [];
    public $currentStep = 1, $character_id, $species_Data;
    public $about, $categories = [], $species_family = [], $species_genus = [], $overview_category, $overview_family, $length, $height, $mass, $speed, $life_span, $overview_genus;
    public $adaptations_short_discription;
    public $overview_image, $showOverview, $selectedIds = [];
    public $characterDetailsData = [];
    public $detailsMap = [], $showNavTab, $hasActiveData;


    public function mount($uuid = null)
    {
        // $this->species_Data  = Species::find(39);
        $this->species_Data = Species::where('uuid', $uuid)->first();
        $this->characterstics = SpeciesCharacterstic::where('status', 1)->get();

        if (!$this->species_Data || count($this->characterstics) == 0) {
            $this->characterDetailsData = collect();
            $this->detailsMap = [];
            $this->showNavTab = null;
            $this->hasActiveData = null;
            return;
        }
        $this->pageTitle = $this->species_Data->name;
        $this->characterDetailsData = DetailsCharactersticModel::where('species_id', $this->species_Data->id)->get();
        if (count($this->characterDetailsData) == 0) {
            $firstCharacteristic = $this->characterstics->first();
            $newEntry = DetailsCharactersticModel::create([
                'species_characterstics' => $firstCharacteristic->id,
                'species_id' => $this->species_Data->id,
                'title' => $firstCharacteristic->title,
                'status' => false,
            ]);
            $this->characterDetailsData = collect([$newEntry]);
        }
        $this->detailsMap = $this->characterDetailsData->keyBy('species_characterstics')->toArray();
        $activeTabName = request()->query('tab');

        if (!empty($activeTabName)) {
            $this->showNavTab = $this->characterstics->first(function ($item) use ($activeTabName) {
                return Str::slug($item->title, '_') === $activeTabName;
            }) ?? $this->characterstics->first();
        } else {
            $this->showNavTab = $this->characterstics->first() ?? null;
        }
        if ($this->showNavTab && isset($this->detailsMap[$this->showNavTab->id])) {
            $this->hasActiveData = $this->detailsMap[$this->showNavTab->id];
        } else {
            $this->hasActiveData = null;
        }
    }

    public function render()
    {
        return view('livewire.admin.species.details.species-details');
    }

    public function toggleStatus($id)
    {
        $this->showNavTab = $this->characterstics->where('species_characterstic_id', $id)->first() ?? null;

        $characteristic = SpeciesCharacterstic::find($id);
        if (!array_key_exists($id, $this->detailsMap)) {

            if ($characteristic) {
                $newEntry = DetailsCharactersticModel::create([
                    'species_characterstics' => $characteristic->id,
                    'species_id' => $this->species_Data->id,
                    'title' => $characteristic->title,
                    'status' => false,
                ]);

                $this->detailsMap[$id] = $newEntry->toArray();
                $this->hasActiveData = $this->detailsMap[$id];
            } else {

                $this->hasActiveData = null;
            }
        } else {
            $existingEntry = DetailsCharactersticModel::where('species_characterstics', $id)
                ->where('species_id', $this->species_Data->id)
                ->first();

            if ($existingEntry && $characteristic) {
                if ($existingEntry->title !== $characteristic->title) {
                    $existingEntry->title = $characteristic->title;
                    $existingEntry->save();
                    $this->detailsMap[$id] = $existingEntry->toArray();
                }
            }

            $this->hasActiveData = $this->detailsMap[$id];
        }
    }

    #[On('species-status-updated')]
    public function refreshStatus($id)
    {
        $updatedDetail = DetailsCharactersticModel::find($id);
        if ($updatedDetail) {
            $this->detailsMap[$updatedDetail->species_characterstics] = $updatedDetail->toArray();
            $this->characterDetailsData = DetailsCharactersticModel::where('species_id', $this->species_Data->id)->get();
        }
    }
}
