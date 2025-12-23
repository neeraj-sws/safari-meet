<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Attributes\{Layout, On};
use Livewire\Component;

#[Layout('components.layouts.admin-app')]
class WhyVerifyProfile extends Component
{
    public $pageTitle = "Why Verify Profile";
    public $editorText, $error;

    public function mount()
    {
        $this->editorText = Page::getValue('why_verify_profile');
    }

    public function render()
    {
        return view('livewire.admin.pages.why-verify-profile');
    }


    #[On("editorTextChange")]
    public function textEditor($value = "")
    {
        $this->editorText = $value;
    }

    public function save()
    {

        if (empty($this->editorText)) {
            $this->error = "The above field is required.";
            return;
        }

        Page::updateOrCreate(['key' => 'why_verify_profile'], ['value' => $this->editorText]);
         $this->editorText = Page::getValue('why_verify_profile');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' updated Successfully']);
    }

}
