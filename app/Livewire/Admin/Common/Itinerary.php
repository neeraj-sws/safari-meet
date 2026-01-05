<?php

namespace App\Livewire\Admin\Common;

use App\Models\ItineraryPackage;
use App\Models\ItineraryPackageActivity;
use App\Models\Package;
use App\Models\ShareSafari;
use Livewire\Component;
use Carbon\Carbon;

class Itinerary extends Component
{
    public $modelTable, $days, $modalTitle, $isEditing, $showActivityCard = false;
    public $heading, $activity = [], $type, $activityday = '', $dayWiseData = [], $itinerary_id;

    public function mount($type = null, $id = null)
    {
        if ($type == 1) {
            $this->modelTable = ShareSafari::findOrFail($id);
            $startDate = Carbon::parse($this->modelTable->start_date);
            $endDate = Carbon::parse($this->modelTable->end_date);
            $this->days = $startDate->diffInDays($endDate) + 1;
            // dd($this->days);
        } else if ($type == 2) {
            $this->modelTable = Package::findOrFail($id);
            $startTour = $this->modelTable->start_tour;
            $endTour = $this->modelTable->end_tour;
            $this->days =  $startTour;
        }

        $this->type = $type;
    }
    public function render()
    {
        if ($this->type == 1) {
            $itineraries = ItineraryPackage::where('share_safari_id', $this->modelTable->id)
                ->orderBy('order_by', 'asc')
                ->get();

            foreach ($itineraries as $item) {
                $dayIndex = $item->order_by;
                $activities = ItineraryPackageActivity::where('itinerary_packages_id', $item->id)
                    ->select('safari_itinerary_activities_id', 'activity')
                    ->get()
                    ->toArray();

                $this->dayWiseData[$dayIndex] = [
                    'heading' => $item->short_description,
                    'activities' => $activities,
                ];
            }
        } else if ($this->type == 2) {
            $itineraries = ItineraryPackage::where('package_id', $this->modelTable->id)
                ->orderBy('order_by', 'asc')
                ->get();

            foreach ($itineraries as $item) {
                $dayIndex = $item->order_by;
                $activities = ItineraryPackageActivity::where('itinerary_packages_id', $item->id)
                    ->select('safari_itinerary_activities_id', 'activity')
                    ->get()
                    ->toArray();

                $this->dayWiseData[$dayIndex] = [
                    'heading' => $item->short_description,
                    'activities' => $activities,
                ];
            }
        }
        return view('livewire.admin.common.itinerary');
    }
    public function addActivityModel($day)
    {

        $titles = 'Day' . $day;
        $this->modalTitle = 'Add ' . $titles;
        $this->activityday = $day;
        $this->resetValidation();
        $this->resetExclusionData();
        $this->isEditing = true;
        $this->showActivityCard = true;
        $this->activity[] = [];
        if ($this->type == 1) {
            $itinerary = ItineraryPackage::where('share_safari_id', $this->modelTable->id)->where('order_by', $day)->first();
            // dd($itinerary);
            if (!empty($itinerary)) {
                $this->heading = $itinerary->short_description;
                $this->itinerary_id = $itinerary->id;
            } else {
                $this->heading = '';
                $this->itinerary_id = null;
            }
        } else if ($this->type == 2) {
            $itinerary = ItineraryPackage::where('package_id', $this->modelTable->id)->where('order_by', $day)->first();
            // dd($itinerary);
            if (!empty($itinerary)) {
                $this->heading = $itinerary->short_description;
                $this->itinerary_id = $itinerary->id;
            } else {
                $this->heading = '';
                $this->itinerary_id = null;
            }
        }
    }
    public function resetExclusionData()
    {

        $this->reset(['activity', 'heading', 'showActivityCard']);
        $this->resetValidation();
    }

    public function addActivity()
    {
        $this->activity[] = [];
    }

    public function removeActivity($index)
    {
        unset($this->activity[$index]);
        $this->activity = array_values($this->activity);
    }

    public function storeActivity()
    {
        // dd($this->itinerary_id,$this->activity);
        $this->validate([
            'heading' => [
                'required',
                'max:60',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('The heading cannot have leading or trailing spaces.');
                    }
                },
            ],
            'activity.*' => [
                'required',
                'max:150',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Activity cannot have leading or trailing spaces.');
                    }
                },
            ],
        ], [
            'heading.required' => 'The heading field is required.',
            'activity.*.required' => 'The activity field is required.',
            'heading.max' => 'The heading may not be greater than 60 characters.',
            'activity.*.max' => 'Each activity may not be greater than 150 characters.',
        ]);

        if ($this->type == 1) {
            if (!empty($this->itinerary_id)) {

                $itineraryPackge = ItineraryPackage::find($this->itinerary_id);
                $itineraryPackge->short_description = $this->heading;
                $itineraryPackge->save();
            } else {

                $itineraryPackge  =  ItineraryPackage::create([
                    'share_safari_id' => $this->modelTable->id,
                    'short_description' => $this->heading,
                    'order_by' => $this->activityday,
                ]);
            }

            foreach ($this->activity as $act) {
                ItineraryPackageActivity::create([
                    'itinerary_packages_id' => $itineraryPackge->id,
                    'activity' => $act
                ]);
            }
        } elseif ($this->type == 2) {

            if (!empty($this->itinerary_id)) {

                $itineraryPackge = ItineraryPackage::find($this->itinerary_id);
                $itineraryPackge->short_description = $this->heading;
                $itineraryPackge->save();
            } else {

                $itineraryPackge  =  ItineraryPackage::create([
                    'package_id' => $this->modelTable->id,
                    'short_description' => $this->heading,
                    'order_by' => $this->activityday,
                ]);
            }

            foreach ($this->activity as $act) {
                ItineraryPackageActivity::create([
                    'itinerary_packages_id' => $itineraryPackge->id,
                    'activity' => $act
                ]);
            }
        }


        $this->resetValidation();
        $this->resetExclusionData();
        $this->isEditing = false;
        $this->showActivityCard = false;
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => $this->modalTitle . ' saved successfully.'
        ]);
    }

    public function deleteActivity($dayIndex, $activityId)
    {
        ItineraryPackageActivity::where('safari_itinerary_activities_id', $activityId)->delete();
    
        if (isset($this->dayWiseData[$dayIndex]['activities'])) {
            $this->dayWiseData[$dayIndex]['activities'] = array_filter(
                $this->dayWiseData[$dayIndex]['activities'],
                fn($act) => $act['safari_itinerary_activities_id'] != $activityId
            );

            $this->dayWiseData[$dayIndex]['activities'] = array_values($this->dayWiseData[$dayIndex]['activities']);
        }
    }
}
