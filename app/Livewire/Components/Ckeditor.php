<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Ckeditor extends Component
{
    public $textEditor;
    public function mount($editor_text = null){
        $this->textEditor = $editor_text;
    }
    public function render()
    {
        return view('livewire.components.ckeditor');
    }
}
