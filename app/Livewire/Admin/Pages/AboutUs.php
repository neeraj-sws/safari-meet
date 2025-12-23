<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Page;
use Livewire\Attributes\{Layout, On};
use Livewire\Component;

#[Layout('components.layouts.admin-app')]
class AboutUs extends Component
{
    public $pageTitle = "About Us";
    public $editorText, $error;
    public function mount()
    {
        $this->editorText = Page::getValue('about_us');
    }
    public function render()
    {
        return view('livewire.admin.pages.about-us');
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

        Page::updateOrCreate(['key' => 'about_us'], ['value' => $this->editorText]);
         $this->editorText = Page::getValue('about_us');
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' updated Successfully']);
    }
}
