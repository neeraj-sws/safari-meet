<?php

namespace App\Livewire\Front\Park\Details;

use App\Models\ParkFaq as ModelsParkFaq;
use Livewire\Component;

class ParkFaq extends Component
{
    public $parkdetails, $characteristic, $faqs;

    public function mount($parkdetails = null, $characteristic = null)
    {
        $this->parkdetails = $parkdetails;
        $this->characteristic = $characteristic;
        $this->faqs = ModelsParkFaq::where('park_id', $this->parkdetails->id)->get();
    }

    public function render()
    {
        return view('livewire.front.park.details.park-faq');
    }
}
