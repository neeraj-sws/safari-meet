<?php

namespace App\Livewire\Admin\Activity;

use App\Models\ActivityLog as ModelsActivityLog;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class ActivityLog extends Component
{
    use WithPagination;

    public $pageTitle = 'Activity Logs';
    public $search = '';
    public $selectedLog = null;

    public function render()
    {
        $logs = ModelsActivityLog::query()
            ->when($this->search, function ($q) {
                $q->where('actor_identifier', 'like', "%{$this->search}%")
                    ->orWhere('message', 'like', "%{$this->search}%")
                    ->orWhere('action', 'like', "%{$this->search}%")
                    ->orWhere('category', 'like', "%{$this->search}%");
            })
            ->orderByDesc('happened_at')
            ->paginate(10);

        return view('livewire.admin.activity.activity-log', [
            'logs' => $logs,
        ]);
    }

    public function toggleLog($id)
    {
        if ($this->selectedLog && $this->selectedLog->id == $id) {
            $this->selectedLog = null;
        } else {
            $this->selectedLog = ModelsActivityLog::find($id);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
