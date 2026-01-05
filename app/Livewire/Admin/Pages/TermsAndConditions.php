<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Component;
use Livewire\Attributes\{Layout, On};
#[Layout('components.layouts.admin-app')]
class TermsAndConditions extends Component
{
    public $pageTitle = "Terms And Conditions";
    public $editorText, $error;
    public function mount()
    {
        $this->editorText = Page::getValue('terms_and_conditions');
    }
    public function render()
    {
        return view('livewire.admin.pages.terms-and-conditions');
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

        Page::updateOrCreate(['key' => 'terms_and_conditions'], ['value' => $this->editorText]);
        
        $this->editorText = Page::getValue('terms_and_conditions');

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' updated Successfully']);
    }
}
