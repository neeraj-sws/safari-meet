<?php

namespace App\Livewire\Admin\Common;

use App\Models\FeatureThingsToCarrySafari;
use App\Models\Package;
use App\Models\ShareSafari;
use App\Models\ThingsToCarry as ModelsThingsToCarry;
use Livewire\Component;
use Livewire\Attributes\On;

class ThingsToCarry extends Component
{
    public $modelTable, $type;
    public $thingsToCarries = [], $thingsToCarryList = [], $formItems = [], $featurethingstocarry, $deleteId;
    public $showForm = false;

    public function mount($type = null, $id = null)
    {
        $this->modelTable = $type == 1
            ? ShareSafari::findOrFail($id)
            : Package::findOrFail($id);

        $this->type = $type;
        $this->thingsToCarries = ModelsThingsToCarry::pluck('title', 'things_to_carry_id')->toArray();
    }

    public function render()
    {
        $this->thingsToCarryList = FeatureThingsToCarrySafari::when($this->type == 1, function ($q) {
            $q->where('share_safari_id', $this->modelTable->id);
        }, function ($q) {
            $q->where('package_id', $this->modelTable->id);
        })->get();

        return view('livewire.admin.common.things-to-carry');
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if ($this->showForm) $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['formItems', 'featurethingstocarry', 'deleteId']);
        $this->resetValidation();
    }

    public function updatedFeaturethingstocarry($id)
    {
        if (!$id) return;

        $data = ModelsThingsToCarry::find($id);
        if (!$data) return;
        $this->formItems[] = [
            'title'       => $data->title,
            'description' => $data->short_description,
        ];
        $this->featurethingstocarry = null;
    }


    public function addFormItem()
    {
        $this->formItems[] = ['title' => '', 'description' => ''];
    }

    public function removeFormItem($i)
    {
        unset($this->formItems[$i]);
        $this->formItems = array_values($this->formItems);
    }

    public function store()
    {

        if (empty($this->formItems)) {
            $this->validate([
                'featurethingstocarry' => 'required|exists:things_to_carries,id',
            ], [
                'featurethingstocarry.required' => 'Please select a "Thing to Carry".',
            ]);

        } else {

            $this->validate([
                'formItems.*.title'       => 'required|string',
                'formItems.*.description' => 'required|string',
            ], [
                'formItems.*.title.required'       => 'Title is required.',
                'formItems.*.description.required' => 'Description is required.',
            ]);
        }

        // Save items
        foreach ($this->formItems as $item) {
            FeatureThingsToCarrySafari::create([
                $this->type == 1 ? 'share_safari_id' : 'package_id' => $this->modelTable->id,
                'title'       => $item['title'],
                'description' => $item['description'],
            ]);
        }

        $this->toggleForm();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Things to carry saved successfully.'
        ]);
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
            'action' => 'deleteConfirmed'
        ]);
    }

    #[On('deleteConfirmed')]
    public function delete()
    {
        FeatureThingsToCarrySafari::destroy($this->deleteId);
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Deleted successfully.'
        ]);
    }
}
