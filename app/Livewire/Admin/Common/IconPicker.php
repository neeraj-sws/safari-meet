<?php

namespace App\Livewire\Admin\Common;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class IconPicker extends Component
{
    public $icon;
    public $field;
    public $title = '',$pageid='';


    public function mount($icon = '', $field = '', $title = '', $pageid='')
    {
        // dd($icon,$field,$title,$pageid);
        $this->icon = $icon;
        $this->field = $field;
        $this->title = $title;
        $this->pageid = $pageid;
    }

    public function render()
    {
        return view('livewire.admin.common.icon-picker');
    }
}
