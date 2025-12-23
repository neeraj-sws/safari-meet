<?php

namespace App\Livewire\TravelAgent\SharedSafari;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\{SpeciesCategory, Park, ShareSafari, StayCategory, Upload, VisitPurpose};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.agent-app')]
class SharedSafariComponet extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search = '', $filter_park, $filter_visitPurposes, $filter_stayCategories, $filter_park_temp, $filter_visitPurposes_temp;
    public $filter_stayCategories_temp;
    public $pageTitle = 'Shared Safari', $safariParks = [], $visitPurposes = [], $stayCategories = [], $categories = [];
    public $deleteId, $display_image;

    public function mount()
    {
        if (Auth::guard('web')->user()->status != 1) {
            return redirect()->route('profile-edit');
        }

        $this->safariParks = Park::pluck('name', 'park_id');
        $this->visitPurposes = VisitPurpose::pluck('name', 'visit_purpose_id');
        $this->stayCategories = StayCategory::pluck('name', 'stay_category_id');
        $this->categories = SpeciesCategory::pluck('name', 'species_category_id');
    }

    public function render()
    {
        $shareSafaries = ShareSafari::where('title', 'like', "%{$this->search}%")->orderBy('updated_at', 'desc')->where('organized_type', 'agent')->where('organized_by', Auth::guard('web')->user()->id);
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

        return view('livewire.travel-agent.shared-safari.shared-safari-componet', compact('shareSafaries'));
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
}
