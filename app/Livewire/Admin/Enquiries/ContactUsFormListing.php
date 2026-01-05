<?php

namespace App\Livewire\Admin\Enquiries;

use App\Models\ContactUsForm;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin-app')]
class ContactUsFormListing extends Component
{
    use WithPagination;

    public $pageTitle = 'Contact Us Submissions';
    public $search = '';
    public $selectedMessage = null, $showModal = false;


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $forms = ContactUsForm::with(['park', 'safariType'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%")
                    ->orWhere('message', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.enquiries.contact-us-form-listing', [
            'forms' => $forms,
        ]);
    }


    public function viewMessage($message)
    {
        $this->selectedMessage = $message;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedMessage = null;
    }
}
