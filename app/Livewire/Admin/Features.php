<?php

namespace App\Livewire\Admin;

use App\Models\Feature as Model;
use App\Models\FeaturePackageSafari;
use Livewire\Attributes\{Layout, On, Validate};
use Livewire\{Component, WithPagination};
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

#[Layout('components.layouts.admin-app')]
class Features extends Component
{
    use WithPagination;

    public $itemId;
    public $title, $type, $icon, $search = '';
    public $isEditing = false;
    public $pageTitle = 'Inclusion-Exclusion';

    public $model = Model::class;
    public $view = 'livewire.admin.features';

    public function mount()
    {
        $this->dispatch('initializeIconPicker');
    }

    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'title' => array_merge(
                [
                    'required',
                    'string',
                    'max:255',
                    function ($attribute, $value, $fail) {
                        if (trim($value) !== $value) {
                            $fail('Title cannot have leading or trailing spaces.');
                        }
                    }
                ],
                $this->isEditing
                    ? [Rule::unique($table, 'title')->ignore($this->itemId,'features_id')]
                    : [Rule::unique($table, 'title')]
            ),
            'type' => 'required',
            'icon' => 'required'
        ];
    }

    public function render()
    {
        $items = $this->model::where('title', 'like', "%{$this->search}%")->orderBy('updated_at', 'desc')
            ->latest()->paginate(10);

        return view($this->view, compact('items'));
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
            'icon' => $this->icon,
            'title' => $this->title,
            'type' => $this->type,
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
        $this->type = $item->type;
        $this->dispatch('iconPicker:update', value: $this->icon);
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate($this->rules());

        $this->model::findOrFail($this->itemId)->update([
            'icon' => $this->icon,
            'title' => $this->title,
            'type' => $this->type,
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

        $isReferenced = FeaturePackageSafari::where('feature_id', $this->itemId)->exists();

        if ($isReferenced) {

            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => 'Cannot delete. This item is linked to a safari.'
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
        $this->reset(['title', 'type', 'icon', 'itemId', 'isEditing']);
        $this->resetValidation();
    }
    
      public function updating()
    {
        $this->resetPage();
    }
}
