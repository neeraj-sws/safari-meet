<?php

namespace App\Livewire\Admin\Common;

use App\Models\SafariRatingHeading;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class RateingHeadings extends Component
{
    use WithPagination;

    public $type, $id;
    public $showFormSection = false, $deleteId = false;
    public $FormList = [];

    protected $paginationTheme = 'bootstrap';

    public function mount($type, $id)
    {
        abort_if(empty($type) || empty($id), 404);

        $this->type = $type;
        $this->id = $id;

        $this->FormList[] = ['short_heading' => ''];
    }

    public function render()
    {
        $columnName = ($this->type == 1) ? 'share_safari_id' : 'package_id';
        $reatingHeadings = SafariRatingHeading::where($columnName, $this->id)
            ->latest()
            ->paginate(10);

        return view('livewire.admin.common.rateing-headings', compact('reatingHeadings'));
    }

    public function showForm()
    {
        $this->showFormSection = true;
        $this->resetErrorBag();
        $this->FormList = [['short_heading' => '']];
    }

    public function hideForm()
    {
        $this->showFormSection = false;
    }

    public function AddBlankFormList()
    {
        $this->FormList[] = ['short_heading' => ''];
    }

    public function removeFormList($index)
    {
        unset($this->FormList[$index]);
        $this->FormList = array_values($this->FormList);
    }

    public function store()
    {
        $this->validate([
            'FormList.*.short_heading' => [
                'required',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Short Heading cannot have leading or trailing spaces.');
                    }
                },
            ],
        ], [
            'FormList.*.short_heading.required' => 'Short Heading is required.',
            'FormList.*.short_heading.max' => 'Short Heading may not be greater than 100 characters.',
        ]);

        foreach ($this->FormList as $item) {
            SafariRatingHeading::create([
                ($this->type == 1 ? 'share_safari_id' : 'package_id') => $this->id,
                'heading_label' => $item['short_heading'],
            ]);
        }

        $this->reset(['FormList', 'showFormSection']);
        $this->FormList[] = ['short_heading' => ''];

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Headings added successfully!',
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
            'cancelButtonText' => 'Cancel',
            'action' => 'delete'
        ]);
    }

    #[On('delete')]
    public function delete()
    {
        $heading = SafariRatingHeading::find($this->deleteId);

        if ($heading) {
            $heading->delete();

            $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => '',
                'message' => 'Heading deleted successfully!',
            ]);
        } else {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => 'Heading not found.',
            ]);
        }

    }
}
