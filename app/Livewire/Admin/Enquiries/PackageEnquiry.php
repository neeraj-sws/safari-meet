<?php

namespace App\Livewire\Admin\Enquiries;

use App\Models\SafariEnquiry;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class PackageEnquiry extends Component
{
    use WithPagination;

    public $pageTitle = 'Safari Enquiries';
    public $search = '';
    public $filter_os = '';
    public $filter_browser = '';
    

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterOs()
    {
        $this->resetPage();
    }

    public function updatingFilterBrowser()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->reset([
            'search',
            'filter_os',
            'filter_browser',
        ]);
        $this->resetPage();
    }

    public function render()
    {
        $query = SafariEnquiry::with('packagesafari');

        // Apply filters
        if (!empty($this->filter_os)) {
            $query->where('os', 'like', '%' . $this->filter_os . '%');
        }

        if (!empty($this->filter_browser)) {
            $query->where('browser', 'like', '%' . $this->filter_browser . '%');
        }

        // Search
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('country', 'like', '%' . $this->search . '%')
                    ->orWhere('mobile_number', 'like', '%' . $this->search . '%')
                    ->orWhere('ip_address', 'like', '%' . $this->search . '%')
                    ->orWhere('browser', 'like', '%' . $this->search . '%')
                    ->orWhere('os', 'like', '%' . $this->search . '%');
            });
        }

        $enquiries = $query->latest()->paginate(10);

        return view('livewire.admin.enquiries.package-enquiry', [
            'enquiries' => $enquiries,
        ]);
    }
}
