<?php

namespace App\Livewire\Admin\Common;

use App\Models\Feature;
use App\Models\FeaturePackageSafari;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class InclusionExclusionsComponent extends Component
{

    private $featureTypes = [
        1 => 'Inclusion',
        2 => 'Exclusion',
    ];

    public $type;
    public $model;

    public $modalTitle;
    public $isEditing = false;
    public $showModal = false;
    public $showForm = false;
    public $deleteId = false;


    public $featureOptions = [];
    public $featureId, $table, $column;
    public $items = [];
    public $data = [];


    public function mount($type, $model, $table = 'package')
    {
        $this->type = $type;
        $this->model = $model;
        $this->table = $table;
        if ($this->table == 'package') {
            $this->column = 'package_id';
        } else {
            $this->column = 'share_safari_id';
        }

        $this->loadData();
    }

    public function render()
    {
        return view('livewire.admin.common.inclusion-exclusions-component');
    }


    private function loadData()
    {
        $this->data = FeaturePackageSafari::where($this->column, $this->model->id)
            ->where('type', $this->type)
            ->get()
            ->toArray();
    }

    private function resetInput()
    {
        $this->featureId = null;
        $this->items = [];
    }

    public function updatedFeatureId($id)
    {
        if (!$id) {
            return;
        }

        $feature = Feature::find($id);
        if (!$feature) {
            return;
        }

        $iconClass = $feature->icon;

        if (str_contains($iconClass, 'class=')) {
            preg_match('/class=["\']([^"\']+)["\']/', $iconClass, $matches);
            $iconClass = $matches[1] ?? $iconClass;
        }

        $exists = collect($this->items)->contains(
            fn($item) =>
            isset($item['title']) && $item['title'] === $feature->title
        );

        if (!$exists) {
            $this->items[] = [
                'icon'  => $iconClass,
                'title' => $feature->title,
                'id' => $feature->id,
            ];
        }

        $this->featureId = null;
        $this->dispatch('initializeIconPicker');
    }


    public function addRow()
    {
        $this->items[] = ['icon' => '', 'title' => '', 'id' => ''];
        $this->dispatch('initializeIconPicker');
    }

    public function removeRow($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    #[On('icon-selected')]
    public function updateIcon($data)
    {
        data_set($this, $data['field'], $data['value']);
    }

    public function store()
    {
        $allEmpty = collect($this->items)->every(
            fn($i) =>
            empty(trim($i['icon'])) && empty(trim($i['title']))
        );

        $rules = [
            'items.*.title' => [
                'required',
                'string',
                'min:3',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Each title cannot have leading or trailing spaces.');
                    }
                },
            ],
            'items.*.icon' => [
                'required',
                'string',
            ],
        ];

        $messages = [
            'items.*.title.required' => 'Each title is required.',
            'items.*.title.string' => 'Each title must be a string.',
            'items.*.title.min' => 'Each title must be at least 3 characters.',
            'items.*.title.max' => 'Each title may not be greater than 100 characters.',

            'items.*.icon.required' => 'Each icon is required.',
            'items.*.icon.string' => 'Each icon must be a string.',
        ];

        if ($allEmpty) {
            $rules['featureId'] = 'required';
            $messages['featureId.required'] = $this->featureTypes[$this->type] . ' is required when no rows added.';
        }

        $this->validate($rules, $messages);

        foreach ($this->items as $item) {
            if (empty(trim($item['title'])) && empty(trim($item['icon']))) continue;

            $icon = trim($item['icon']);
            if (!str_contains($icon, '<i')) {
                $icon = '<i class="' . e($icon) . '" aria-hidden="true"></i>';
            }

            FeaturePackageSafari::create([
                $this->column => $this->model->id,
                'type'       => $this->type,
                'title'      => $item['title'],
                'icon'       => $icon,
                'feature_id' => !empty($item['id']) ? (int) $item['id'] : null,
            ]);
        }


        $this->showModal = false;
        $this->resetInput();
        $this->loadData();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => $this->featureTypes[$this->type] . 's saved successfully.',
        ]);
    }

    public function deleteItem($id)
    {
        FeaturePackageSafari::find($id)?->delete();
        $this->loadData();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Delete ' . $this->featureTypes[$this->type] . ' Item Successfully']);
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
        FeaturePackageSafari::find($this->deleteId)?->delete();
        $this->loadData();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Delete ' . $this->featureTypes[$this->type] . ' Item Successfully']);
    }

    public function updatedShowForm($value)
    {
        if ($value) {
            $this->featureOptions = Feature::where('type', $this->type)
                ->pluck('title', 'features_id')
                ->toArray();
        }
    }
}
