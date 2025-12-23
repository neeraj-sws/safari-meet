<?php

namespace App\Livewire\Admin\Common;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class CkeditorComponent extends Component
{
    #[Modelable]
    public $value = '';
    public $model;
    public $editorId;

    public function mount($model, $value = '', $editorId = null)
    {
        $this->value = $value;
        $this->model = $model;
        $this->editorId = $editorId ?? 'editor-' .uniqid();
        $this->dispatch('init-tinymce');
    }

    public function render()
    {
        return view('livewire.admin.common.ckeditor-component');
    }
}
