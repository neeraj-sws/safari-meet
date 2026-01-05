<?php

namespace App\Livewire\Admin;

use App\Models\SpeciesFamilyModel as Model;
use App\Models\SpeciesOverviewModel;
use App\Models\SpeciesCategory;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithPagination};
use Illuminate\Validation\Rule;

#[Layout('components.layouts.admin-app')]
class SpeciesFamily extends Component
{
    use WithPagination;

    public $itemId, $categories, $category, $category_filter;
    public $name, $search = '';
    public $isEditing = false;
    public $pageTitle = 'Species Family';

    public $model = Model::class;
    public $view = 'livewire.admin.species-family';

    public function mount()
    {
        $this->categories = SpeciesCategory::where('status', 1)->orderBy('name', 'asc')->pluck('name', 'species_category_id');
        // dd( $this->categories);
    }

    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'name' => array_merge(
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
                    ? [Rule::unique($table, 'name')->ignore($this->itemId,'species_family_id')]
                    : [Rule::unique($table, 'name')]
            )
        ];
    }

    public function render()
    {

        $items = $this->model::with('category')
            ->when(
                $this->category_filter,
                fn($q) =>
                $q->where('category_id', $this->category_filter)
            )->where('name', 'like', "%{$this->search}%")->orderBy('updated_at', 'desc')
            ->latest()->paginate(10);
        return view($this->view, compact('items'));
    }



    public function store()
    {
        $this->validate($this->rules());

        $this->model::create([
            'name' => $this->name,
            'category_id' => $this->category,
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
        $this->category = $item->category_id;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate($this->rules());

        $this->model::findOrFail($this->itemId)->update([
            'name' => $this->name,
            'category_id' => $this->category,
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
         $exists = SpeciesOverviewModel::where('species_family_id', $this->itemId)->exists();

        if ($exists) {

            $this->dispatch('swal:toast', [
                'type' => 'warning',
                'title' => '',
                'message' => 'Cannot delete. Species use this data.'
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
        $this->reset(['name', 'itemId', 'isEditing', 'category']);
        $this->resetValidation();
    }

    public function toggleStatus($id)
    {
        $habitat = $this->model::findOrFail($id);
        $habitat->status = !$habitat->status;
        $habitat->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }
}
