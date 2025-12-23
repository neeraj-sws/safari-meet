<?php

namespace App\Livewire\Admin\Park\Details\Reachability;

use App\Models\City;
use App\Models\ParkReachability;
use App\Models\ParkReachabilityDistance;
use App\Models\ReachabilityMode;
use App\Models\State;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ImportantCities extends Component
{
    use WithPagination;

    public $park, $characterDetails;
    public $showForm = false;
    public $states = [], $state, $cities = [], $city = [], $citisList = [], $heading = [], $ReachabilityListes = [], $availableReachabilities = [];
    public $deleteId = null;

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->availableReachabilities = ReachabilityMode::where('status', true)->pluck('title', 'reachability_modes_id')->toArray();
        $this->ReachabilityListes = ParkReachability::where('park_id', $this->park->id)
            ->whereIn('reachability_id', array_keys($this->availableReachabilities))
            ->get()
            ->keyBy('reachability_id');
    }
    public function render()
    {
        $IMPCitisList = ParkReachabilityDistance::with('cityData')->where('park_id', $this->park->id)->latest()->paginate(10);
        return view('livewire.admin.park.details.reachability.important-cities', compact('IMPCitisList'));
    }

    public function toggleForm()
    {
        $this->resetErrorBag();
        $this->showForm = !$this->showForm;
        if ($this->showForm) {
            $this->states = State::where('country_id', $this->park?->country_id)->get();
            $this->heading = [];
            if (count($this->ReachabilityListes) > 0) {
                foreach ($this->availableReachabilities as $id => $title) {
                    $slug =  Str::slug($this->ReachabilityListes[$id]->title);
                    $this->heading[$slug] = $this->ReachabilityListes[$id]->heading;
                }
            } else {

                foreach ($this->availableReachabilities as $id => $title) {
                    $slug =  Str::slug($title);
                    $this->heading[$slug] = $title;
                }
            }
            $this->city = [];
            $this->citisList = [];
        } else {
            $this->heading = [];
            $this->city = [];
            $this->citisList = [];
        }
    }

    public function updatedState()
    {
        if (!empty($this->state)) {
            $this->cities = City::where('state_id', $this->state)->get();
        } else {
            $this->cities = [];
            $this->city = [];
        }
    }

    public function storeCities()
    {

        $rules = [];
        $messages = [];

        $rules["city"] = 'required|array|min:1';
        $messages["city.required"] = "Please select at least one city.";
        $messages["city.min"] = "Please select at least one city.";

        foreach ($this->heading as $key => $value) {
            $rules["heading.$key"] = 'required|string';
            $messages["heading.$key.required"] = ucfirst(str_replace('-', ' ', $key)) . ' heading is required';
        }

        foreach ($this->citisList as $index => $city) {
            foreach ($city['reachability'] as $slug => $value) {
                $rules["citisList.$index.reachability.$slug"] = 'required|string';
                $label = $city['reachability_label'][$slug] ?? $slug;
                $messages["citisList.$index.reachability.$slug.required"] =
                    ucfirst($label) . " field is required for " . $city['name'];
            }
        }

        Validator::make($this->all(), $rules, $messages)->validate();
        if (count($this->ReachabilityListes) <= 0) {
            $reachabilityMap = [];
            foreach ($this->heading as $key => $reachability) {
                $reachabilityModel =  ReachabilityMode::where('slug', $key)->first();
                $parkReachability = ParkReachability::create([
                    'heading' => $reachability,
                    'park_id' => $this->park->id,
                    'reachability_id' => $reachabilityModel?->id,
                ]);

                if ($parkReachability) {
                    $reachabilityMap[$key] = $parkReachability->id;
                }
            }

            foreach ($this->citisList as $cityKey => $city) {
                foreach ($city['reachability'] as $slug => $value) {
                    ParkReachabilityDistance::create([
                        'park_id' => $this->park->id,
                        'distance' => $value,
                        'city_id' => $city['id'],
                        'reachability_id' => $reachabilityMap[$slug] ?? null,
                    ]);
                }
            }
        } else {
            $reachabilityMap = [];
            foreach ($this->heading as $key => $reachability) {
                $reachabilityModel = ReachabilityMode::where('slug', $key)->first();

                $existingParkReachability = ParkReachability::where('park_id', $this->park->id)
                    ->where('reachability_id', $reachabilityModel?->id)
                    ->first();
                if ($existingParkReachability) {
                    $existingParkReachability->update([
                        'heading' => $reachability,
                    ]);

                    $reachabilityMap[$key] = $existingParkReachability->id;
                }
            }

            ParkReachabilityDistance::whereIn('park_reachabilities_distance_id', $reachabilityMap)->delete();
            foreach ($this->citisList as $cityKey => $city) {
                foreach ($city['reachability'] as $slug => $value) {
                    ParkReachabilityDistance::create([
                        'park_id' => $this->park->id,
                        'distance' => $value,
                        'city_id' => $city['id'],
                        'reachability_id' => $reachabilityMap[$slug] ?? null,
                    ]);
                }
            }
        }
        $this->showForm = !$this->showForm;
        $this->reset(['state', 'cities', 'city', 'citisList', 'heading']);
        $this->resetPage();
    }


    public function updatedCity()
    {
        $city = city::whereIn('city_id', $this->city)->pluck('name', 'city_id')->toArray();
        $this->citisList = [];
        $reachabilityInputs = [];
        $reachabilityLable = [];
        if ($city) {
            foreach ($this->availableReachabilities as $id => $reachability) {
                $slug =  Str::slug($reachability);
                $reachabilityInputs[$slug] = '';
                $reachabilityLable[$slug] = $reachability;
            }
            foreach ($city as $id => $name) {
                $this->citisList[] = [
                    'id' => $id,
                    'name' => $name,
                    'reachability' => $reachabilityInputs,
                    'reachability_label' => $reachabilityLable,
                ];
            }
        }
    }
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('swal:confirm', [
            'title' => 'Are you sure?',
            'text' => 'This will permanently delete this record.',
            'icon' => 'warning',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'action' => 'deleteConfirmed',
        ]);
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $record = ParkReachabilityDistance::find($this->deleteId);
        if ($record) {
            $record->delete();
            $this->dispatch('swal:toast', [
                'type' => 'success',
                'message' => 'City deleted successfully.',
            ]);
        } else {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => 'City not found.',
            ]);
        }
        $this->deleteId = null;
    }
}
