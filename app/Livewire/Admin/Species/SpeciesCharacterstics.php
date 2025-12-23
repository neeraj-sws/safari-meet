<?php

namespace App\Livewire\Admin\Species;

use App\Models\SpeciesCharacterstic;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class SpeciesCharacterstics extends Component
{
    use WithFileUploads;
    use WithPagination;

    // public $model = model::class;
    public $view = 'livewire.admin.species.species-characterstics';


    public $isEditing = false, $editId, $deleteId,  $characterstics_name;
    public $pageTitle = 'Species Characterstics';
    public $search = '';
    public $name;
    public function render()
    {
        $Speciescharacterstic = SpeciesCharacterstic::where('title', 'like', "%{$this->search}%")->orderBy('updated_at', 'desc')
            ->latest()->paginate(10);

        return view($this->view, compact('Speciescharacterstic'));
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


        SpeciesCharacterstic::create([
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
        $species = SpeciesCharacterstic::findOrFail($id);

        $this->characterstics_name = $species->title;

        $this->editId = $species->id;
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

        $species = SpeciesCharacterstic::findOrFail($this->editId);

        $species->update([
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
        $protectedIds = [1, 2, 3, 4, 5, 6, 7, 9];

        if (in_array($this->deleteId, $protectedIds)) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => 'Action Blocked!',
                'message' => 'This item is protected and cannot be deleted.'
            ]);
            return;
        }

        SpeciesCharacterstic::destroy($this->deleteId);

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
            'deleteId'
        );
    }
    public function toggleStatus($id)
    {
        $species = SpeciesCharacterstic::findOrFail($id);
        $species->status = !$species->status;
        $species->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
    public function updating()
    {
        $this->resetPage();
    }
}
