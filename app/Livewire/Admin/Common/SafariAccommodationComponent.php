<?php

namespace App\Livewire\Admin\Common;

use App\Models\Accommodation;
use App\Models\Feature;
use App\Models\FeaturePackageSafari;
use App\Models\SafariAccommodation;
use Livewire\Attributes\On;
use Livewire\Component;

class SafariAccommodationComponent extends Component
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


    public $featureOptions = [];
    public $featureId, $table, $column, $accommodation;
    public $items = [];
    public $data = [];


    public function mount($model, $table = 'package')
    {
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
        return view('livewire.admin.common.safari-accommodation-component');
    }


    private function loadData()
    {
        $this->data = SafariAccommodation::with(['accommodation.amenity.amenity', 'accommodation.image', 'accommodation.category'])->where($this->column, $this->model->id)
            ->first();
        // dd($this->data->toArray());
    }

    private function resetInput()
    {
        $this->accommodation = [];
    }

    public function store()
    {

        $this->validate([
            'accommodation' => 'required',
        ]);

        SafariAccommodation::updateOrCreate(
            [
                $this->column => $this->model->id,
            ],
            [
                $this->column => $this->model->id,
                'accommodation_id' => $this->accommodation,
            ]
        );

        $this->showModal = false;
        $this->resetInput();
        $this->loadData();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => 'saved successfully.',
        ]);
    }

    public function deleteItem($id)
    {
        FeaturePackageSafari::find($id)?->delete();
        $this->loadData();
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Delete ' . $this->featureTypes[$this->type] . ' Item Successfully']);
    }

    public function updatedShowForm($value)
    {
        if ($value) {
            $this->featureOptions = Accommodation::where('city_id', $this->model->park->city_id)->pluck('title', 'accommodation_id')->toArray();
        }
    }
}
