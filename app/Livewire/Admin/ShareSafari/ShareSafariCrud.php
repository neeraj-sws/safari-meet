<?php

namespace App\Livewire\Admin\ShareSafari;

use App\Helpers\ImageHelper;
use App\Models\{JoinSharedSafari, SpeciesCategory, Park, ShareSafari, StayCategory, Upload, VisitPurpose};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\{Layout, On};
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.admin-app')]
class ShareSafariCrud extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $showModal = false, $isEditing = false, $editId, $deleteId;
    public $publishedStatusId, $publishedStatusValue;
    public $modalTitle = 'Add', $pageTitle = 'Shared Safari';
    public $search = '';
    public $step = 1;

    public $title, $safariPark, $day, $night, $safari_no = 1;
    public $visit_purpose_id, $stay_category_id, $min_price_pp, $max_price_pp, $total_seats, $share_seats;
    public $safari_plan, $display_image, $previousImage;
    public $safariParks, $visitPurposes, $stayCategories;
    public $filter_park, $filter_visitPurposes, $filter_stayCategories;
    public $filter_park_temp, $filter_visitPurposes_temp, $filter_stayCategories_temp, $details, $ids;
    public $uploaded_images = [], $best_month_start, $best_month_end, $category, $categories = [], $activeState = 1, $userCount, $adminCount, $agentCount;

    public function mount()
    {
        $this->safariParks = Park::pluck('name', 'park_id');
        $this->visitPurposes = VisitPurpose::pluck('name', 'visit_purpose_id');
        $this->stayCategories = StayCategory::pluck('name', 'stay_category_id');
        $this->categories = SpeciesCategory::pluck('name', 'species_category_id');
        $activeTabName = request()->query('tab');
        if (!empty($activeTabName)) {
            if ($activeTabName == 'admin') {
                $this->activeState = 1;
            } elseif ($activeTabName == 'user') {
                $this->activeState = 2;
            } elseif ($activeTabName == 'agent') {
                $this->activeState = 3;
            }
        }
    }
    public function render()
    {
        $this->userCount = ShareSafari::where('organized_type', 'user')->count();
        $this->adminCount = ShareSafari::where('organized_type', 'admin')->count();
        $this->agentCount = ShareSafari::where('organized_type', 'agent')->count();
        $shareSafaries = ShareSafari::with('payment')->orderBy('updated_at', 'desc');
        if (!empty($this->search)) {
            $shareSafaries->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->activeState == 1) {
            $shareSafaries->where('organized_type', 'admin');
        } elseif ($this->activeState == 2) {
            $shareSafaries->where('organized_type', 'user');
        } elseif ($this->activeState == 3) {
            $shareSafaries->where('organized_type', 'agent');
        }
        if (isset($this->filter_park_temp) && !empty($this->filter_park_temp)) {
            $shareSafaries->where('safari_park_id', $this->filter_park_temp);
        }
        if (isset($this->filter_visitPurposes_temp) && !empty($this->filter_visitPurposes_temp)) {
            $shareSafaries->where('visit_purpose_id', $this->filter_visitPurposes_temp);
        }
        if (isset($this->filter_stayCategories_temp) && !empty($this->filter_stayCategories_temp)) {
            $shareSafaries->where('stay_category_id', $this->filter_stayCategories_temp);
        }

        $shareSafaries = $shareSafaries->latest()->paginate(10);


        return view('livewire.admin.share-safari.index', compact('shareSafaries'));
    }
    public function applyFilter()
    {
        $this->filter_park_temp = $this->filter_park;
        $this->filter_visitPurposes_temp = $this->filter_visitPurposes;
        $this->filter_stayCategories_temp = $this->filter_stayCategories;
    }
    public function resetFilter()
    {
        $this->reset(['search', 'filter_park', 'filter_visitPurposes', 'filter_stayCategories', 'filter_park_temp', 'filter_visitPurposes_temp', 'filter_stayCategories_temp']);
    }

    public function detail($id)
    {

        $this->ids = $id;
        $this->details = 1;
    }


    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'delete'
        ]);
    }

    public function confirmPublishStatus($id, $status)
    {
        $this->publishedStatusId = $id;
        $this->publishedStatusValue = $status;
        
        $statusText = $status == 1 ? 'approve' : 'reject';
        
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => "Do you want to {$statusText} this safari?",
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, ' . ($status == 1 ? 'approve' : 'reject') . ' it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'executePublishStatus'
        ]);
    }

    #[On('delete')]
    public function delete()
    {
        ShareSafari::destroy($this->deleteId);
        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' deleted successfully!']);
    }
    public function updating()
    {
        $this->resetPage();
    }


    public function removeDisplayImage(): void
    {
        if ($this->display_image) {
            $this->display_image->delete();
        }
        $this->display_image = null;
    }


    public function toggleStatus($id)
    {
        $safari = ShareSafari::findOrFail($id);
        $safari->status = !$safari->status;
        $safari->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);

    }

    public function toggleStatusPopular($id)
    {
        $safari = ShareSafari::findOrFail($id);
        $safari->popular = !$safari->popular;
        $safari->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    public function toggleStatusTrending($id)
    {
        $safari = ShareSafari::findOrFail($id);
        $safari->trending = !$safari->trending;
        $safari->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
    public function toggleStatusTopRated($id)
    {
        $safari = ShareSafari::findOrFail($id);
        $safari->top_rated = !$safari->top_rated;
        $safari->save();

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }

    #[On('executePublishStatus')]
    public function executePublishStatus()
    {
        $safari = ShareSafari::findOrFail($this->publishedStatusId);
        $status = $this->publishedStatusValue;
        $safari->is_approved = $status;
        $safari->save();
        if ($status == 1) {
            createNotification(
                12,
                $safari->organized_by,
                $safari->organized_type == 'admin' ? 'App\Models\Admin' : 'App\Models\User',
                1,
                'App\Models\Admin',
                [
                    'safari_id' => $safari->id,
                    'safari_name' => $safari->title ?? null,
                    'safari_url' => route('shared-safari.detail', ['slug' => $safari->slug])
                ]
            );
        } else {

            createNotification(
                13,
                $safari->organized_by,
                $safari->organized_type == 'admin' ? 'App\Models\Admin' : 'App\Models\User',
                1,
                'App\Models\Admin',
                [
                    'safari_id' => $safari->id,
                    'safari_name' => $safari->title ?? null,
                    'safari_url' => route('shared-safari.detail', ['slug' => $safari->slug])
                ]
            );
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Status Changed Successfully']);
    }
}
