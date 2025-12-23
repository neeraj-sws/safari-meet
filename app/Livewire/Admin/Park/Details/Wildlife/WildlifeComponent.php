<?php

namespace App\Livewire\Admin\Park\Details\Wildlife;

use App\Models\ParkDetailsTabs;
use App\Models\ParkSpecies;
use App\Models\Species;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class WildlifeComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $park, $pageTitle = "Wildlife Species";
    public $characterDetails, $speciesData, $wildlifeSpecies = [], $wildelifeNames = [], $search, $activeTabe;
    public $deleteId = null;


    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->speciesData = Species::where('status', true)->get();
        $this->activeTabe = 'species';
    }

    public function render()
    {
        $query = ParkSpecies::with('speciesList')
            ->whereHas('speciesList', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->where('park_id', $this->park->id);

        $speciesLists = $query->latest()->paginate(10);

        return view('livewire.admin.park.details.wildlife.wildlife-component', compact('speciesLists'));
    }

    public function updatedWildlifeSpecies()
    {
        $this->wildelifeNames = Species::whereIn('species_id', $this->wildlifeSpecies)->pluck('name');
    }

    public function storeSpecies()
    {
        $this->validate([
            'wildlifeSpecies' => 'required|array|min:1',
        ], [
            'wildlifeSpecies.required' => 'Please select at least one species.',
        ]);

        $alreadyAdded = [];

        foreach ($this->wildlifeSpecies as $speciesId) {
            $exists = ParkSpecies::where('park_id', $this->park->id)
                ->where('species_id', $speciesId)
                ->exists();

            if (!$exists) {
                ParkSpecies::create([
                    'park_id' => $this->park->id,
                    'species_id' => $speciesId,
                ]);
            } else {
                $alreadyAdded[] = $speciesId;
            }
        }

        $this->reset(['wildlifeSpecies', 'wildelifeNames']);

        if ($alreadyAdded) {
            $names = Species::whereIn('species_id', $alreadyAdded)->pluck('name')->toArray();
            $message = implode(', ', $names) . " already added.";
            $this->dispatch('swal:toast', ['type' => 'warning', 'message' => $message]);
        } else {
            $this->dispatch('swal:toast', ['type' => 'success', 'message' => $this->pageTitle . ' Added Successfully']);
        }
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This will permanently delete this species.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'deleteConfirmed',
        ]);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $species = ParkSpecies::find($this->deleteId);
        if ($species) {
            $species->delete();
            $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Species deleted successfully.']);
        } else {
            $this->dispatch('swal:toast', ['type' => 'error', 'message' => 'Species not found.']);
        }

        $this->deleteId = null;
    }

    public function changeTab($value)
    {
        $this->activeTabe = $value;
    }

    public function toggleStatus($id)
    {
        $detailTabs = ParkDetailsTabs::findOrFail($id);
        $detailTabs->status = !$detailTabs->status;
        $detailTabs->save();
        $this->dispatch('status-updated', id: $detailTabs->id);
        $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Status Changed Successfully']);
    }
}
