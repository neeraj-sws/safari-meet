<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ReportResion as Model;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.admin-app')]
class ReportResion extends Component
{
    use WithPagination;

    public $itemId;
    public $title, $status = true, $search = '';
    public $isEditing = false;

    public $pageTitle = 'Report Reasons';
    public $model = Model::class;
    public $view = 'livewire.admin.report-resion';

    public function render()
    {
        $items = $this->model::orderBy('updated_at', 'desc')
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->paginate(10);

        return view($this->view, compact('items'));
    }

    public function rules()
    {
        $table = (new $this->model)->getTable();

        return [
            'title' => array_merge(
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
                    ? [Rule::unique($table, 'title')->ignore($this->itemId, 'report_resion_id')]
                    : [Rule::unique($table, 'title')]
            ),
            'status' => ['boolean'],
        ];
    }

    public function store()
    {
        $this->validate();

        $this->model::create([
            'title' => $this->title,
        ]);

        $this->resetForm();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' added successfully!',
        ]);
    }

    public function edit($id)
    {
        $this->resetForm();
        $item = $this->model::findOrFail($id);

        $this->itemId = $item->report_resion_id;
        $this->title = $item->title;
        $this->status = $item->status;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        $this->model::findOrFail($this->itemId)->update([
            'title' => $this->title,
        ]);

        $this->resetForm();
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' updated successfully!',
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
            'action' => 'delete',
        ]);
    }

    #[On('delete')]
    public function delete()
    {
        $this->model::destroy($this->itemId);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' deleted successfully!',
        ]);
    }

    public function resetForm()
    {
        $this->reset(['title', 'status', 'itemId', 'isEditing']);
        $this->resetValidation();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $resion = $this->model::find($id);
        $resion->status = $resion->status == '1' ? '0' : '1';
        $resion->save();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Status changed successfully!'
        ]);
    }
}
