<?php

namespace App\Livewire\Admin\Enquiries;

use App\Models\EnquiryAccommodation;
use App\Models\Enquiry;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;


#[Layout('components.layouts.admin-app')]
class GeneralEnquiry extends Component
{

     use WithPagination;
     public  $pageTitle = 'Enquiries',  $filter_accommodation,
        $search = '',
        $filter_os = '',
        $filter_browser = '',$accommodations =[];


    public function mount()
    {
        $this->accommodations = EnquiryAccommodation::where('status', 1)->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function applyFilter()
    {
        $this->filter_accommodation;
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->reset([
            'filter_accommodation',
            'filter_os',
            'filter_browser',
            'search'
        ]);
        $this->resetPage();
    }

    public function render()
    {


         $query = Enquiry::with('accommodation');

       if (!empty($this->filter_accommodation)) {
            $query->whereHas('accommodation', function ($q) {
                $q->where('title', $this->filter_accommodation);
            });
        }

        if (!empty($this->filter_os)) {
            $query->where('os', $this->filter_os);
        }

        if (!empty($this->filter_browser)) {
            $query->where('browser', $this->filter_browser);
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('travellers', 'like', '%' . $this->search . '%')
                    ->orWhere('browser', 'like', '%' . $this->search . '%')
                    ->orWhere('os', 'like', '%' . $this->search . '%')
                    ->orWhere('source', 'like', '%' . $this->search . '%');
            });
        }

        $enquiries = $query->latest()->paginate(10);

        return view('livewire.admin.enquiries.general-enquiry', [
            'enquiries' => $enquiries,
        ]);
    }
}
