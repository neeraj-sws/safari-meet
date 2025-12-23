<?php

namespace App\Livewire\Admin\Park;

use App\Models\ParkTabs;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class ParkTabsComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    // public $model = model::class;
    public $view = 'livewire.admin.park.park-tabs-component';


    public $isEditing = false, $editId, $deleteId,  $characterstics_name;
    public $pageTitle = 'Park Information';
    public $search = '';
    public $name;
    public function render()
    {
        $parkCharacterstic = ParkTabs::where('title', 'like', "%{$this->search}%")->orderBy('updated_at', 'desc')
            ->latest()->paginate(10);

        return view($this->view, compact('parkCharacterstic'));
    }

    public function resetFilter()
    {
        $this->reset(['search']);
    }

    public function store()
    {
        $this->validate([
            'characterstics_name' => [
                'required',
                'string',
                'min:3',
                'max:60',
                'regex:/^[A-Za-z]+(?: [A-Za-z]+)*$/',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        return $fail('Characteristic name cannot have leading or trailing spaces.');
                    }
                },
            ],
        ], [
            'characterstics_name.required' => 'The characteristic name is required.',
            'characterstics_name.string' => 'The characteristic name must be a valid string.',
            'characterstics_name.min' => 'The characteristic name must be at least 3 characters long.',
            'characterstics_name.max' => 'The characteristic name may not be greater than 60 characters.',
            'characterstics_name.regex' => 'The characteristic name may only contain letters and spaces between words.',
        ]);

        ParkTabs::create([
            'title' => $this->characterstics_name,
            'status' => true,
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);

        $this->resetFields();
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();
        $park = ParkTabs::findOrFail($id);
        $this->characterstics_name = $park->title;
        $this->editId = $park->id;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate([
            'characterstics_name' => [
                'required',
                'string',
                'min:3',
                'max:60',
                'regex:/^[A-Za-z]+(?: [A-Za-z]+)*$/',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        return $fail('Characteristic name cannot have leading or trailing spaces.');
                    }
                },
            ],
        ], [
            'characterstics_name.required' => 'The characteristic name is required.',
            'characterstics_name.string' => 'The characteristic name must be a valid string.',
            'characterstics_name.min' => 'The characteristic name must be at least 3 characters long.',
            'characterstics_name.max' => 'The characteristic name may not be greater than 60 characters.',
            'characterstics_name.regex' => 'The characteristic name may only contain letters and spaces between words.',
        ]);
        $park = ParkTabs::findOrFail($this->editId);

        $park->update([
            'title' => $this->characterstics_name,
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
        $this->isEditing = false;
        $this->resetFields();
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
        $protectedIds = [1, 2, 3, 4, 5, 6, 7, 9,11];

        if (in_array($this->deleteId, $protectedIds)) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => 'Action Blocked!',
                'message' => 'This item is protected and cannot be deleted.'
            ]);
            return;
        }

        ParkTabs::destroy($this->deleteId);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' deleted successfully!'
        ]);
    }

    public function resetFields()
    {
        $this->reset(
            'characterstics_name',
            'editId',
            'deleteId',
            'isEditing'
        );
    }
    public function toggleStatus($id)
    {
        $park = ParkTabs::findOrFail($id);
        $park->status = !$park->status;
        $park->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
    public function updating()
    {
        $this->resetPage();
    }
}
