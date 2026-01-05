<?php

namespace App\Livewire\Front\Pages;

use App\Helpers\UserHelper;
use App\Models\Page;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TermsConditions extends Component
{
    public $seoContents,$terms_and_conditions;

    public function mount()
    {
        $this->seoContents  = UserHelper::SeoDetails('terms-conditions');
        $this->terms_and_conditions = Page::getValue('terms_and_conditions');
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.pages.terms-conditions')->layoutData([
            'seoContents' =>$this->seoContents,
        ]);
    }
}
