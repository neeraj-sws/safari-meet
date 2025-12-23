<?php

namespace App\Livewire\Admin\Park\Details\TravelTips;

use App\Models\ParkBestTimeVistModel;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class BestTimeToVisity extends Component
{
    use WithPagination;

    public $park, $characterDetails;
    public $showBestTimeForm = false, $BestTimeFormList = [],$deleteId;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
    }

    public function render()
    {
        $bestTimeToVisitList = ParkBestTimeVistModel::where('park_id', $this->park->id)->latest()->paginate(10);
        return view('livewire.admin.park.details.travel-tips.best-time-to-visity', compact('bestTimeToVisitList'));
    }

    public function showBestTime()
    {
        $this->showBestTimeForm = true;
        if (empty($this->BestTimeFormList)) {
            $this->addBestTime();
        }
    }

    public function hideBestTime()
    {
        $this->showBestTimeForm = false;
        $this->reset(['BestTimeFormList']);
    }

    public function addBestTime()
    {

        $this->BestTimeFormList[] = [
            'heading' => '',
            'description' => ''
        ];
        $this->resetValidation();
        $this->dispatch('initializeCKEditor');
    }

    public function removeBestTime($index)
    {
        unset($this->BestTimeFormList[$index]);
        $this->BestTimeFormList = array_values($this->BestTimeFormList);
    }

    public function storeBestTime()
    {

        $this->validate(
            [
                'BestTimeFormList.*.heading' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    function ($attribute, $value, $fail) {
                        if (trim($value) !== $value) {
                            $fail('The heading cannot have leading or trailing spaces.');
                        }
                    },
                ],
                'BestTimeFormList.*.description' => [
                    'required',
                    'string',
                ],
            ],
            [
                'BestTimeFormList.*.heading.required' => 'The heading field is required.',
                'BestTimeFormList.*.heading.string' => 'The heading must be a string.',
                'BestTimeFormList.*.heading.min' => 'The heading must be at least 3 characters.',
                'BestTimeFormList.*.heading.max' => 'The heading must not be more than 100 characters.',
                'BestTimeFormList.*.heading.regex' => 'The heading must only contain letters and spaces.',
                'BestTimeFormList.*.description.required' => 'The description field is required.',
                'BestTimeFormList.*.description.string' => 'The description must be a string.',
            ],
            [
                'BestTimeFormList.*.heading' => 'Heading',
                'BestTimeFormList.*.description' => 'Description',
            ]
        );

        foreach ($this->BestTimeFormList as $item) {
            ParkBestTimeVistModel::create([
                'park_id' => $this->park->id,
                'heading' => $item['heading'],
                'description' => $item['description'],
            ]);
        }
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Best Time To Visit Added Successfully'
        ]);
        $this->reset(['BestTimeFormList', 'showBestTimeForm']);
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
            'action' => 'deleteConfirmed',
        ]);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $item = ParkBestTimeVistModel::find($this->deleteId);
        if ($item) {
            $item->delete();
            $this->dispatch('swal:toast', [
                'type' => 'success',
                'message' => 'Item deleted successfully!',
            ]);
        } else {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => 'Item not found!',
            ]);
        }
        $this->deleteId = null;
    }
}
