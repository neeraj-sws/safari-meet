<?php

namespace App\Livewire\Front;

use Livewire\Attributes\Layout;
use Livewire\Component;

   #[Layout('components.layouts.guest')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.front.dashboard')->layoutData([
            'seoContents' =>'',
        ]);
    }
}
