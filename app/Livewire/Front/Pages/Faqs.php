<?php

namespace App\Livewire\Front\Pages;

use App\Helpers\UserHelper;
use App\Models\Faq;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Faqs extends Component
{
    public $seoContents, $faqs = [];

    public function mount()
    {
        $this->seoContents  = UserHelper::SeoDetails('faqs');
        $this->faqs = Faq::where('category_id', 1)->get();
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.pages.faqs')->layoutData([
            'seoContents' => $this->seoContents,
        ]);
    }
}
