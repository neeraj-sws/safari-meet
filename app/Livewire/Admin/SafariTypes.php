<?php

namespace App\Livewire\Admin;

use App\Models\SafariType as Model;
use App\Models\ParkSafariType;
use App\Models\SafariesType;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithPagination};
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

#[Layout('components.layouts.admin-app')]
class SafariTypes extends Component
{
    use WithPagination;

    public $itemId;
    public $name, $search = '';
    public $isEditing = false;
    public $pageTitle = 'Safari Types';

    public $model = Model::class;
    public $view = 'livewire.admin.safari-types';



    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'name' => array_merge(
                [
                    'required',
                    'string',
                    'max:100',
                    function ($attribute, $value, $fail) {
                        if (trim($value) !== $value) {
                            $fail('Title cannot have leading or trailing spaces.');
                        }
                    }
                ],
                $this->isEditing
                    ? [Rule::unique($table, 'name')->ignore($this->itemId,'safari_type_id')]
                    : [Rule::unique($table, 'name')]
            )
        ];
    }

    public function render()
    {
        $items = $this->model::where('name', 'like', "%{$this->search}%")->orderBy('updated_at', 'desc')
            ->latest()->paginate(10);

        return view($this->view, compact('items'));
    }



    public function store()
    {
        $this->validate($this->rules());

        $this->model::create([
            'name' => $this->name,
            'status' => true,
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
        $this->name = $item->name;

        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate($this->rules());

        $this->model::findOrFail($this->itemId)->update([
            'name' => $this->name,
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

        $usedInParkSafariType = ParkSafariType::where('safari_type_id', $this->itemId)->exists();
        $usedInSafariesType = SafariesType::where('safari_type_id', $this->itemId)->exists();

        if ($usedInParkSafariType || $usedInSafariesType) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => 'Cannot delete. This Safari Type is in use in either Park Safari or Safaries.'
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
        $this->reset(['name', 'itemId', 'isEditing']);
        $this->resetValidation();
    }

    public function toggleStatus($id)
    {
        $habitat = $this->model::findOrFail($id);
        $habitat->status = !$habitat->status;
        $habitat->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
    
      public function updating()
    {
        $this->resetPage();
    }
}
