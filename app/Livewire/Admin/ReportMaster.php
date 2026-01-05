<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Report;

#[Layout('components.layouts.admin-app')]
class ReportMaster extends Component
{
    use WithPagination;

    public $pageTitle = 'Reports';
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
       $query = Report::with(['reportReason', 'sharedSafari', 'package', 'discussion', 'mediaPost']);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('report_type', 'like', "%{$this->search}%")
                    ->orWhere('details', 'like', "%{$this->search}%")
                    ->orWhereHas('sharedSafari', fn($sq) => $sq->where('title', 'like', "%{$this->search}%"))
                    ->orWhereHas('package', fn($pq) => $pq->where('title', 'like', "%{$this->search}%"))
                    ->orWhereHas('discussion', fn($dq) => $dq->where('content', 'like', "%{$this->search}%"));
            });
        }

        $reports = $query->latest()->paginate(10);

        return view('livewire.admin.report-master', [
            'reports' => $reports,
        ]);
    }
}
