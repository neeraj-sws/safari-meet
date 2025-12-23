<?php

namespace App\Livewire\Front\Pages;

use App\Helpers\UserHelper;
use App\Models\Page;
use Livewire\Attributes\Layout;
use Livewire\Component;

class PrivacyPolicy extends Component
{
    public $seoContents,$privacy_policy;

    public function mount()
    {
        $this->seoContents  = UserHelper::SeoDetails('privacy-policy');
        $this->privacy_policy = Page::getValue('privacy_policy');
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.pages.privacy-policy')->layoutData([
            'seoContents' =>$this->seoContents,
        ]);
    }
}
