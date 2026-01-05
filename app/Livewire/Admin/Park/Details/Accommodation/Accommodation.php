<?php

namespace App\Livewire\Admin\Park\Details\Accommodation;

use App\Models\Accommodation as AccommodationModel;
use App\Models\ParkAccommodation;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Accommodation extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $park, $pageTitle = "Park Accommodation";
    public $accommodationOptions = [], $accommodationNames = [], $search, $selectedAccommodations = [], $activeTab;
    public $deleteId;

    public function mount($model = null)
    {
        $this->park = $model;
        $this->accommodationOptions = AccommodationModel::where('city_id', $this->park->city_id)->get();
        $this->activeTab = 'accommodation';
    }

    public function render()
    {
        $query = ParkAccommodation::with('accommodationList')
            ->whereHas('accommodationList', fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->where('park_id', $this->park->id);

        $accommodationLists = $query->latest()->paginate(10);

        return view('livewire.admin.park.details.accommodation.accommodation', compact('accommodationLists'));
    }

    public function updatedSelectedAccommodations()
    {
        $this->accommodationNames = AccommodationModel::whereIn('accommodation_id', $this->selectedAccommodations)
            ->pluck('title');
    }

    public function storeAccommodations()
    {
        $this->validate([
            'selectedAccommodations' => 'required|array|min:1',
        ], [
            'selectedAccommodations.required' => 'Please select at least one accommodation.',
        ]);

        $alreadyAdded = [];

        foreach ($this->selectedAccommodations as $accommodationId) {
            $exists = ParkAccommodation::where('park_id', $this->park->id)
                ->where('accommodation_id', $accommodationId)
                ->exists();

            if (!$exists) {
                ParkAccommodation::create([
                    'park_id' => $this->park->id,
                    'accommodation_id' => $accommodationId,
                ]);
            } else {
                $alreadyAdded[] = $accommodationId;
            }
        }

        $this->reset(['selectedAccommodations', 'accommodationNames']);

        if ($alreadyAdded) {
            $names = AccommodationModel::whereIn('accommodation_id', $alreadyAdded)->pluck('title')->toArray();
            $message = implode(', ', $names) . " already added.";
            $this->dispatch('swal:toast', [
                'type' => 'warning',
                'message' => $message,
            ]);
        } else {
            $this->dispatch('swal:toast', [
                'type' => 'success',
                'message' => 'Accommodations Added Successfully',
            ]);
        }
    }


    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This will permanently delete the accommodation.',
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
        $accommodation = ParkAccommodation::find($this->deleteId);
        if ($accommodation) {
            $accommodation->delete();
            $this->dispatch('swal:toast', [
                'type' => 'success',
                'message' => 'Accommodation deleted successfully!',
            ]);
        } else {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => 'Accommodation not found.',
            ]);
        }
    }

    public function changeTab($value)
    {
        $this->activeTab = $value;
    }
}
