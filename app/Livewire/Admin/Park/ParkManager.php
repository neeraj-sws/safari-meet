<?php

namespace App\Livewire\Admin\Park;

use App\Models\City;
use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{
    Park,
};
use App\Models\State;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin-app')]
class ParkManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $modalTitle = 'Add', $pageTitle = 'Park', $submenus = ['Park'];

    public $name, $short_description, $description,
        $city_id, $state_id, $country_id, $train, $airport, $safari_session,
        $wildlife_found, $safari_cost, $safari_mode, $closed_months, $park_id;
    public $showModal = false, $isEditing = false, $deleteId;

    public $search = '';
    public $countries = [], $states = [], $cities = [], $wildlives;
    public $filter_country, $filter_state, $filter_city, $filter_wildlife;
    public $filter_countries = [], $filter_states = [], $filter_cities = [];
    public $filter_country_temp, $filter_wildlife_temp, $filter_state_temp, $filter_city_temp, $previousImage, $data_image, $editId, $area, $established, $famous_for, $best_time, $parkDetailPage = 0, $parkIDForDetails;


    public function mount()
    {
        $countries = Country::orderByRaw("CASE WHEN name = 'India' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->pluck('name', 'country_id');

        $this->filter_countries = $this->countries = $countries;
    }
    public function render()
    {
        $parks = Park::where('name', 'like', "%{$this->search}%")->orderBy('updated_at', 'desc');
        if (isset($this->filter_country_temp) && !empty($this->filter_country_temp)) {
            $parks->where('country_id', $this->filter_country_temp);
        }
        if (isset($this->filter_wildlife_temp) && !empty($this->filter_wildlife_temp)) {
            $parks->where('wildlife_found', $this->filter_wildlife_temp);
        }
        if (isset($this->filter_state_temp) && !empty($this->filter_state_temp)) {
            $parks->where('state_id', $this->filter_state_temp);
        }
        if (isset($this->filter_city_temp) && !empty($this->filter_city_temp)) {
            $parks->where('city_id', $this->filter_city_temp);
        }
        $parks = $parks->latest()->paginate(10);
        return view('livewire.admin.park-manager', compact('parks'));
    }

    public function toggleStatus($id)
    {
        $park = Park::findOrFail($id);
        $park->status = !$park->status;
        $park->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function toggleStatusPopular($id)
    {
        $park = Park::findOrFail($id);
        $park->popular = !$park->popular;
        $park->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function toggleStatusTrending($id)
    {
        $park = Park::findOrFail($id);
        $park->trending = !$park->trending;
        $park->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function toggleStatusToRated($id)
    {
        $park = Park::findOrFail($id);
        $park->top_rated = !$park->top_rated;
        $park->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }


    public function toggleStatusToSafari($id)
    {
        $park = Park::findOrFail($id);
        $park->top_safari = !$park->top_safari;
        $park->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }


    public function applyFilter()
    {
        $this->filter_country_temp = $this->filter_country;
        $this->filter_wildlife_temp = $this->filter_wildlife;
        $this->filter_state_temp = $this->filter_state;
        $this->filter_city_temp = $this->filter_city;
    }
    public function resetFilter()
    {
        $this->reset(['search', 'filter_country', 'filter_state', 'filter_city', 'filter_wildlife', 'filter_country_temp', 'filter_wildlife_temp', 'filter_state_temp', 'filter_city_temp']);
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'delete'
        ]);
    }

    #[On('delete')]
    public function delete()
    {
        $parkId = $this->deleteId;
        Park::destroy($parkId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }
    public function updating()
    {
        $this->resetPage();
    }

    public function updatedFilterCountry($value)
    {
        $this->filter_states = State::where('country_id', $value)->pluck('name', 'state_id');
        $this->filter_state = '';
        $this->filter_cities = [];
        $this->filter_city = '';
    }

    public function updatedFilterState($value)
    {
        $this->filter_cities = City::where('state_id', $value)->pluck('name', 'city_id');
        $this->filter_city = '';
    }
}
