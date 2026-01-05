<?php

namespace App\Livewire\Front\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;

 #[Layout('components.layouts.guest')]
class Tankyou extends Component
{
    public function render()
    {
        return view('livewire.front.auth.tankyou');
    }
}
