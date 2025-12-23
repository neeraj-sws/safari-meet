<?php

namespace App\Livewire\Admin;

use App\Models\SystemFaq;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class SystemFaqCrud extends Component
{
    use WithPagination;
    public $showModal = false, $isEditing = false, $editId, $deleteId;
    public $modalTitle = 'Add', $pageTitle = 'System Faq'; 
    public $search = '';
    #[Validate('required|string|max:255')] public $question;
    #[Validate('required|string')] public $answer;
    public function render()
    {
          $system_faq = SystemFaq::where('question', 'like', "%{$this->search}%")
            ->orderBy('updated_at', 'desc')->latest()
            ->paginate(10);

        return view('livewire.admin.system-faq', [
            'systemFaqs' => $system_faq
        ]);
    }

     public function store()
    {
        $this->validate();

        SystemFaq::create([
            'question' => $this->question,
            'answer' => $this->answer,
        ]);

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'System FAQ Added Successfully']);

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
        SystemFaq::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->resetFields();
        $system_faq = SystemFaq::findOrFail($id);

        $this->question = $system_faq->question;
        $this->answer = $system_faq->answer;

        $this->editId = $system_faq->id;
        $this->isEditing = true;
        $this->modalTitle = 'Edit ' . $this->pageTitle;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();
        $system_faq = SystemFaq::findOrFail($this->editId);
        $system_faq->update([
            'question' => $this->question,
            'answer' => $this->answer,
        ]);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'System FAQ Updated Successfully']);
        $this->isEditing = false;
        $this->showModal = false;
        $this->resetFields();
    }


    public function openModal()
    {
        $this->resetFields();
        $this->resetValidation();
        $this->modalTitle = 'Add ' . $this->pageTitle;
        $this->showModal = true;
    }
    public function resetFields()
    {
        $this->reset('question', 'answer','editId', 'deleteId');
    }
}
