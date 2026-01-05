<?php

namespace App\Livewire\Admin;

use App\Models\Faq;
use App\Models\FaqCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class FaqManager extends Component
{
    use WithPagination;
    public $showModal = false, $isEditing = false, $editId, $deleteId;
    public $modalTitle = 'Add', $pageTitle = 'FAQ';

    #[Validate('required|string|max:255')] public $question;
    #[Validate('required|string')] public $answer;
    #[Validate('required|exists:faq_categories,faq_categoryid')] public $category_id;
    public $search = '';
    public $categories, $filter_category, $filter_category_temp;
    public function mount()
    {
        $this->categories = FaqCategory::whereStatus(1)->pluck('name', 'faq_categoryid');
    }
    public function render()
    {
        $faqs = Faq::where('question', 'like', "%{$this->search}%");
        if (isset($this->filter_category_temp) && !empty($this->filter_category_temp)) {
            $faqs->where('category_id', $this->filter_category_temp);
        }
        $faqs = $faqs->latest()->paginate(10);
        return view('livewire.admin.faq-manager', compact('faqs'));
    }

    public function applyFilter()
    {
        $this->filter_category_temp = $this->filter_category;
    }
    public function resetFilter()
    {
        $this->reset(['search', 'filter_category', 'filter_category_temp']);
    }


    public function openModal()
    {
        $this->resetFields();
        $this->resetValidation();
        $this->modalTitle = 'Add ' . $this->pageTitle;
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        Faq::create([
            'question' => $this->question,
            'answer' => $this->answer,
            'category_id' => $this->category_id,
            'status' => true,
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'FAQ Added Successfully']);

        $this->showModal = false;
        $this->resetFields();
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();
        $faq = Faq::findOrFail($id);

        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->category_id = $faq->category_id;

        $this->editId = $faq->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();
        $faq = Faq::findOrFail($this->editId);
        $faq->update([
            'question' => $this->question,
            'answer' => $this->answer,
            'category_id' => $this->category_id,
        ]);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'FAQ Updated Successfully']);
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
        Faq::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }

    public function resetFields()
    {
        $this->reset('question', 'answer', 'category_id', 'editId', 'deleteId');
    }
    public function toggleStatus($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->status = !$faq->status;
        $faq->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
    public function updating()
    {
        $this->resetPage();
    }
}

