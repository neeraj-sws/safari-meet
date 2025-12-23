<?php

namespace App\Livewire\Front\Pages;

use App\Helpers\UserHelper;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RefundPolicy extends Component
{
    public $seoContents;

    public function mount()
    {
        $this->seoContents  = UserHelper::SeoDetails('privacy-policy');
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.pages.refund-policy')->layoutData([
            'seoContents' =>$this->seoContents,
        ]);
    }
}
