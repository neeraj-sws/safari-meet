<?php

namespace App\Livewire\Admin\Amenity;

use App\Models\Amenity  as Model;
use App\Models\AccommodationAmenity;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithPagination};
use Illuminate\Validation\Rule;

#[Layout('components.layouts.admin-app')]
class Amenities extends Component
{
    use WithPagination;

    public $itemId;
    public $title, $icon, $search = '';
    public $isEditing = false;

    public $pageTitle = 'Amenities';
    public $model = Model::class;
    public $view = 'livewire.admin.amenity.amenities';

    public function mount()
    {
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
            'title' => array_merge(
                [
                    'required',
                    'string',
                    'max:50',
                    function ($attribute, $value, $fail) {
                        if (trim($value) !== $value) {
                            $fail('Title cannot have leading or trailing spaces.');
                        }
                    }
                ],
                $this->isEditing
                    ? [Rule::unique($table, 'title')->ignore($this->itemId)]
                    : [Rule::unique($table, 'title')]
            ),

            'icon' => ['required', 'string', 'max:100'],
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
        $this->dispatch('iconPicker:reset');
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
        $this->dispatch('iconPicker:update', value: $this->icon);
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate($this->rules());

        $this->model::findOrFail($this->itemId)->update([
            'title' => $this->title,
            'icon' => $this->icon,
        ]);

        $this->resetForm();
        $this->dispatch('iconPicker:reset');
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

        $isInUse = AccommodationAmenity::where('amenity_id', $this->itemId)->exists();

        if ($isInUse) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => 'Cannot delete. This amenity is currently used in Accommodation Amenities.'
            ]);
            return;
        }

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
    
      public function updating()
    {
        $this->resetPage();
    }
}
