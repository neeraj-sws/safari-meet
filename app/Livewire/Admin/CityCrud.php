<?php

namespace App\Livewire\Admin;

use App\Models\City as model;
use App\Models\State;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class CityCrud extends Component
{
    use WithPagination;

    public $city_name, $state, $states, $cityId;

    public $isEditing = false, $deleteId;
    public  $pageTitle = 'City';
    public $search = '';
    public $filter_state, $filter_state_temp;

    public $model = model::class;
    public $view = 'livewire.admin.city-crud';

    public function resetFields()
    {
        $this->resetValidation();
        $this->reset([
            'city_name',
            'state',
            'cityId',
            'isEditing',
        ]);
    }
    public function mount()
    {
        $this->states = State::all()->pluck('name', 'id');
    }
    public function render()
    {
        $cities = $this->model::where('name', 'like', "%{$this->search}%");

        if (isset($this->filter_state) && !empty($this->filter_state)) {
            $cities->where('state_id', $this->filter_state);
        }

        $cities = $cities->latest()->paginate(10);

        return view($this->view, compact('cities'));
    }
    public function applyFilter()
    {
        $this->filter_state_temp = $this->filter_state;
    }
    public function resetFilter()
    {
        $this->reset(['search', 'filter_state', 'filter_state_temp']);
    }

    public function submit()
    {
        $stateKey = (new State)->getKeyName();

        $this->validate([
            'city_name' => 'required|string|max:50|unique:cities,name',
            'state' => 'required|exists:states,' . $stateKey,
        ]);

        $this->model::create([
            'name' => $this->city_name,
            'state_id' => $this->state,
        ]);

        $this->resetFields();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();
        $city = $this->model::findOrFail($id);
        $this->city_name = $city->name;
        $this->state = $city->state_id;

        $this->cityId = $city->id;
        $this->isEditing = true;
    }

    public function update()
    {
        $city = $this->model::findOrFail($this->cityId);
        $city->update([
            'name' => $this->city_name,
            'state_id' => $this->state,
        ]);
        $this->resetFields();
        $this->isEditing = false;
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
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
        $this->model::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }
    public function updating()
    {
        $this->resetPage();
    }
}
