<?php

namespace App\Livewire\Admin\Amenity;

use App\Models\Amenity  as Model;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component,WithPagination};

#[Layout('components.layouts.admin-app')]
class TestingIcon extends Component
{
    use WithPagination;

    public $itemId;
    public $title, $icon, $search = '';
    public $isEditing = false;

    public $pageTitle = 'Amenities';
    public $model = Model::class;
    public $view = 'livewire.admin.amenity.testing';

    public function mount(){
         $this->dispatch('initializeIconPicker');
    }

    public function render()
    {
        $items = $this->model::orderBy('updated_at', 'desc')
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->paginate(10);


        return view($this->view, compact('items'));
    }

    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'title' => $this->isEditing
                ? 'required|string|max:255|unique:' . $table . ',title,' . $this->itemId
                : 'required|string|max:255|unique:' . $table . ',title',
            'icon' => 'required|string|max:100',
        ];
    }


    #[On('icon-selected')]
    public function updateIcon($data)
    {
        $this->{$data['field']} = $data['value'];
    }

    public function store()
    {
       $this->validate($this->rules());

        $this->model::create([
            'title' => $this->title,
            'icon' => $this->icon,
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
        $this->title = $item->title;
        $this->icon = $item->icon;
        $this->isEditing = true;

        $this->dispatch('initializeIconPicker');
    }

    public function update()
    {
       $this->validate($this->rules());

        $this->model::findOrFail($this->itemId)->update([
            'title' => $this->title,
            'icon' => $this->icon,
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
        $this->reset(['title', 'icon', 'itemId', 'isEditing']);
        $this->resetValidation();
    }
}
