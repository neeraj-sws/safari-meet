<?php

namespace App\Livewire\Admin\Jobs;

use App\Models\FailedJob;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;


#[Layout('components.layouts.admin-app')]
class FailedJobComponent  extends Component
{

    use WithPagination;

    public  $pageTitle = 'Failed Jobs';
    public $search = '';
    public $selectedJob = null;

    public function retryJob($id)
    {
        $job = FailedJob::find($id);
        if ($job) {

            Artisan::call('queue:retry', [$job->uuid]);
            session()->flash('message', "Job #{$id} retried successfully.");
        }
    }

    public function render()
    {
        $failedJobs = FailedJob::query()
            ->when(
                $this->search,
                fn($q) =>
                $q->where('exception', 'like', "%{$this->search}%")
            )
            ->orderByDesc('failed_at')
            ->paginate(10);

        return view('livewire.admin.jobs.failed-job-component', [
            'failedJobs' => $failedJobs,
        ]);
    }

    public function toggleJob($id)
    {
        if ($this->selectedJob && $this->selectedJob->id == $id) {
            $this->selectedJob = null; // close if same clicked again
        } else {
            $this->selectedJob = FailedJob::find($id);
        }
    }
    
      public function updating()
    {
        $this->resetPage();
    }
}
