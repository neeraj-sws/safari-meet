<?php

namespace App\Livewire\Front\Pages;

use App\Helpers\UserHelper;
use App\Models\Page;
use Livewire\Attributes\Layout;
use Livewire\Component;

 #[Layout('components.layouts.guest')]
class WhyVerifyProfile extends Component
{

    public $seoContents, $about_us;

    public function mount()
    {
        $this->seoContents  = UserHelper::SeoDetails('about-us');
        $this->about_us = Page::getValue('why_verify_profile');
    }


    public function render()
    {
        return view('livewire.front.pages.why-verify-profile');
    }
}
