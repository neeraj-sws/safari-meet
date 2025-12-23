<?php

namespace App\Livewire\Admin\Park\Details\Information;

use App\Models\ParkInformationModel;
use Livewire\Component;

class SafariBookingProcess extends Component
{
    public $pageTitle = "Safari Booking Process", $park, $characterDetails, $bookingProcess, $informationData;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->informationData =  ParkInformationModel::where('park_id', $this->park->id)->first();
        if (!empty($this->informationData)) {
            $this->bookingProcess = $this->informationData->booking_process;
        }
        $this->dispatch('initializeCKEditor');
    }

    public function render()
    {
        return view('livewire.admin.park.details.information.safari-booking-process');
    }

    public function store()
    {
        $this->validate([
            'bookingProcess' => 'required',
        ]);

        if (empty($this->informationData)) {
            ParkInformationModel::create([
                'park_id' => $this->park->id,
                'booking_process' => $this->bookingProcess,
            ]);
        } else {
            $this->informationData->booking_process = $this->bookingProcess;
            $this->informationData->save();
        }
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' Added Successfully']);
    }
}
