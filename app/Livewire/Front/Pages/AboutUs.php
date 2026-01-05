<?php

namespace App\Livewire\Front\Pages;

use App\Helpers\UserHelper;
use App\Models\Page;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AboutUs extends Component
{
    public $seoContents,$about_us;

    public function mount()
    {
        $this->seoContents  = UserHelper::SeoDetails('about-us');
         $this->about_us = Page::getValue('about_us');
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.pages.about-us')->layoutData([
            'seoContents' =>$this->seoContents,
        ]);
    }
}
