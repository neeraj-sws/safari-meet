<?php

namespace App\Livewire\Admin;

use App\Models\Country as Model;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithPagination};
use Illuminate\Support\Str;

#[Layout('components.layouts.admin-app')]
class Countries extends Component
{
    use WithPagination;

    public $itemId;
    public $country_name, $country_code, $phone_code, $search = '';
    public $isEditing = false;
    public $pageTitle = 'Countries';

    public $model = Model::class;
    public $view = 'livewire.admin.country';



    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'country_name' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Country Name cannot have leading or trailing spaces.');
                    }
                },
                'unique:' . $table . ',name' . ($this->isEditing ? ',' . $this->itemId . ',country_id' : ''),
            ],

            'country_code' => [
                'required',
                'string',
                'max:3',
                'alpha',
                'unique:' . $table . ',sortname' . ($this->isEditing ? ',' . $this->itemId . ',country_id' : ''),
            ],

            'phone_code' => [
                'required',
                'numeric',
                'digits_between:1,5',
                'unique:' . $table . ',phonecode' . ($this->isEditing ? ',' . $this->itemId . ',country_id' : ''),
            ],
        ];
    }


    public function render()
    {
        $items = $this->model::where(function ($query) {
            $query->where('name', 'like', "%{$this->search}%")
                ->orWhere('phonecode', 'like', "%{$this->search}%")
                ->orWhere('sortname', 'like', "%{$this->search}%");
        })->orderBy('updated_at', 'desc')
            ->latest()->paginate(10);

        return view($this->view, compact('items'));
    }



    public function store()
    {
        $this->validate($this->rules());

        $this->model::create([
            'sortname' => $this->country_code,
            'name' => $this->country_name,
            'phonecode' => $this->phone_code,
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
        $this->country_name = $item->name;
        $this->country_code = $item->sortname;
        $this->phone_code = $item->phonecode;
        $this->isEditing = true;

        $this->dispatch('initializeIconPicker');
    }

    public function update()
    {
        $this->validate($this->rules());

        $this->model::findOrFail($this->itemId)->update([
            'sortname' => $this->country_code,
            'name' => $this->country_name,
            'phonecode' => $this->phone_code,
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
        $this->reset(['country_name', 'country_code', 'phone_code', 'itemId', 'isEditing']);
        $this->resetValidation();
    }
    
      public function updating()
    {
        $this->resetPage();
    }
}
