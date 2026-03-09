<?php

namespace App\Livewire\Admin;

use App\Models\State as ModelsCategory;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithPagination};
use Illuminate\Support\Str;
use App\Models\Country;

#[Layout('components.layouts.admin-app')]
class States extends Component
{
    use WithPagination;

    public $itemId;
    public $state_name, $country, $countries, $filter_country, $search = '';
    public $isEditing = false;
    public $pageTitle = 'States';

    public $model = ModelsCategory::class;
    public $view = 'livewire.admin.state';



    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'state_name' => $this->isEditing
                ? 'required|string|max:50|unique:' . $table . ',name,' . $this->itemId . ',state_id'
                : 'required|string|max:50|unique:' . $table . ',name',

            'country' => 'required|exists:countries,country_id',
        ];
    }



    public function mount()
    {
        $this->countries = Country::pluck('name', 'country_id');
    }

    public function render()
    {
        $items = $this->model::query()
            ->when(
                $this->search,
                fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
            )
            ->when(
                $this->filter_country,
                fn($q) =>
                $q->where('country_id', $this->filter_country)
            )
            ->orderBy('updated_at', 'desc')
            ->paginate(10);


        return view($this->view, compact('items'));
    }



    public function store()
    {
        $this->validate($this->rules());

        $this->model::create([
            'name' => $this->state_name,
            'country_id' => $this->country,
        ]);

        $this->resetForm();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' Added Successfully'
        ]);
    }

    public function edit($id)
    {

        $this->resetForm();
        $item = $this->model::findOrFail($id);

        $this->itemId = $item->id;
        $this->state_name = $item->name;
        $this->country = $item->country_id;
        $this->isEditing = true;

        $this->dispatch('initializeIconPicker');
    }

    public function update()
    {
        $this->validate($this->rules());

        $this->model::findOrFail($this->itemId)->update([
            'name' => $this->state_name,
            'country_id' => $this->country,
        ]);

        $this->resetForm();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' Updated Successfully'
        ]);
    }

    public function confirmDelete($id)
    {
        $this->itemId = $id;

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
        $this->model::destroy($this->itemId);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' deleted successfully!'
        ]);
    }

    public function resetForm()
    {
        $this->reset(['state_name', 'country', 'itemId', 'isEditing']);
        $this->resetValidation();
    }

      public function updating()
    {
        $this->resetPage();
    }
}
