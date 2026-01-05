<?php

namespace App\Livewire\Admin\Species\Details\Overview;

use App\Models\SpeciesCategory;
use App\Models\SpeciesFamilyModel;
use App\Models\SpeciesGenusModel;
use App\Models\SpeciesOverviewModel;
use Livewire\Component;

class ZoologicalIdentity extends Component
{
    public $species, $characterDetails, $pageTitle = 'About';
    public $overViewData, $categories = [];
    public $species_family = [], $species_genus = [], $overview_category, $overview_family, $overview_genus, $life_span, $speed, $mass, $height, $length;


    public function mount($species = null, $characterstic = null)
    {
        $this->species = $species;
        $this->characterDetails = $characterstic;
        $this->categories = SpeciesCategory::where('status', 1)->orderBy('name', 'asc')->pluck('name', 'species_category_id');
        $this->overViewData = SpeciesOverviewModel::where('species_id', $this->species->id)->first();
        if (!empty($this->overViewData)) {
            $this->overview_category = $this->overViewData->species_category_id;
            $this->overview_family = $this->overViewData->species_family_id;
            $this->overview_genus = $this->overViewData->species_genus_id;
            $this->life_span = $this->overViewData->life_span;
            $this->speed = $this->overViewData->speed;
            $this->mass = $this->overViewData->mass;
            $this->height = $this->overViewData->height;
            $this->length = $this->overViewData->length;
            $this->updatedOverviewCategory($this->overview_category);
            $this->updatedOverviewFamily($this->overview_family);
        }
    }

    public function render()
    {
        return view('livewire.admin.species.details.overview.zoological-identity');
    }

    public function updatedOverviewCategory($value)
    {
        $this->species_family = SpeciesFamilyModel::where('category_id', $value)->where('status', 1)->orderBy('name', 'asc')->pluck('name', 'species_family_id');
    }

    public function updatedOverviewFamily($value)
    {
        $this->species_genus = SpeciesGenusModel::where('status', 1)->where('species_family_id', $value)->orderBy('name', 'asc')->pluck('name', 'species_genus_id');
    }

    public function store()
    {
        $this->validate([
            'overview_category' => 'required|integer',
            'overview_family' => 'required|integer',
            'overview_genus' => 'required|integer',
            'life_span' => 'required|string|min:3|max:15',
            'speed' => 'required|string|min:3|max:15',
            'mass' => 'required|string|min:3|max:15',
            'height' => 'required|string|min:3|max:15',
            'length' => 'required|string|min:3|max:15',
        ]);


        if (!empty($this->overViewData)) {
            $this->overViewData->species_category_id = $this->overview_category;
            $this->overViewData->species_family_id = $this->overview_family;
            $this->overViewData->species_genus_id = $this->overview_genus;
            $this->overViewData->life_span = $this->life_span;
            $this->overViewData->speed = $this->speed;
            $this->overViewData->mass = $this->mass;
            $this->overViewData->height = $this->height;
            $this->overViewData->length = $this->length;
            $this->overViewData->save();
        } else {
            $this->overViewData =  SpeciesOverviewModel::create([
                'species_id' => $this->species->id,
                'species_details_characterstics_id' => $this->characterDetails['species_details_characterstic_id'],
                'life_span' => $this->life_span,
                'speed' => $this->speed,
                'mass' => $this->mass,
                'height' => $this->height,
                'length' => $this->length,
                'species_category_id' => $this->overview_category,
                'species_family_id' => $this->overview_family,
                'species_genus_id' => $this->overview_genus,
            ]);
        }

        $this->overViewData = SpeciesOverviewModel::where('species_id', $this->species->id)
            ->where('species_details_characterstics_id', $this->characterDetails['species_details_characterstic_id'])
            ->first();
        if (!empty($this->overViewData)) {
            $this->overview_category = $this->overViewData->species_category_id;
            $this->overview_family = $this->overViewData->species_family_id;
            $this->overview_genus = $this->overViewData->species_genus_id;
            $this->life_span = $this->overViewData->life_span;
            $this->speed = $this->overViewData->speed;
            $this->mass = $this->overViewData->mass;
            $this->height = $this->overViewData->height;
            $this->length = $this->overViewData->length;
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }
}
