<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Component;
use Livewire\Attributes\{Layout, On};
#[Layout('components.layouts.admin-app')]
class RefundPolicy extends Component
{
    public $pageTitle = "Refund Policy";
    public $editorText, $error;
    public function mount()
    {
        $this->editorText = Page::getValue('refund_policy');
    }
    public function render()
    {
        return view('livewire.admin.pages.refund-policy');
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

        Page::updateOrCreate(['key' => 'refund_policy'], ['value' => $this->editorText]);
         $this->editorText = Page::getValue('refund_policy');

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' updated Successfully']);
    }
}
