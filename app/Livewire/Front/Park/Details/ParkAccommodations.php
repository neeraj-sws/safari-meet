<?php

namespace App\Livewire\Front\Park\Details;

use App\Models\ParkAccommodation;
use Livewire\Component;

class ParkAccommodations extends Component
{
    public $parkdetails, $characteristic;
    public $perPage = 9;

    public function mount($parkdetails = null, $characteristic = null)
    {
        $this->parkdetails = $parkdetails;
        $this->characteristic = $characteristic;
    }

    public function loadMore()
    {
        $this->perPage += 6;
    }

    public function render()
    {
         $Park_accommodation = ParkAccommodation::with(['accommodationList','accommodationList.image','accommodationList.cuntry','accommodationList.state','accommodationList.city'])
            ->where('park_id', $this->parkdetails->id)
            ->take($this->perPage)
            ->get();

        $totalCount = ParkAccommodation::where('park_id', $this->parkdetails->id)->count();

        return view('livewire.front.park.details.park-accommodations', [
            'park_accommodations' => $Park_accommodation,
            'totalCount' => $totalCount
        ]);
    }
}
