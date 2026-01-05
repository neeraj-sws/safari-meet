<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class DatepickerComponent extends Component
{
    #[Modelable]
    public $modelValue;
    public $fieldId;

    public function render()
    {
        return view('livewire.components.datepicker');
    }
}
