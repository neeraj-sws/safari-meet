<?php

namespace App\Livewire\Admin;

use App\Models\FaqCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class FaqCategoryManager extends Component
{
    use WithPagination;
    public $showModal = false, $isEditing = false, $editId, $deleteId;
    public $modalTitle = 'Add', $pageTitle = 'FAQ Category';

    #[Validate('required|string|max:255')] public $name;

    public $search = '';
    public function render()
    {
        $faqCategories = FaqCategory::where('name', 'like', "%{$this->search}%")
            ->latest()->paginate(10);
        return view('livewire.admin.faq-category-manager', compact('faqCategories'));
    }
    public function resetFilter()
    {
        $this->reset(['search']);
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->modalTitle = 'Add ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        FaqCategory::create([
            'name' => $this->name,
            'status' => true,
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);

        $this->showModal = false;
        $this->resetFields();
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();
        $faqCategory = FaqCategory::findOrFail($id);

        $this->name = $faqCategory->name;

        $this->editId = $faqCategory->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();
        $faqCategory = FaqCategory::findOrFail($this->editId);
        $faqCategory->update([
            'name' => $this->name,
        ]);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Updated Successfully']);
        $this->showModal = false;
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
        if (in_array($this->deleteId, [1, 2])) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => 'This item cannot be deleted!'
            ]);
            return;
        }
        FaqCategory::destroy($this->deleteId);
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->pageTitle . ' deleted successfully!'
        ]);
    }

    public function resetFields()
    {
        $this->reset('name', 'editId', 'deleteId');
    }
    public function toggleStatus($id)
    {
        $faqCategory = FaqCategory::findOrFail($id);
        $faqCategory->status = !$faqCategory->status;
        $faqCategory->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
    public function updating()
    {
        $this->resetPage();
    }
}
