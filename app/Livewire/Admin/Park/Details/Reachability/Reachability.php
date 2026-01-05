<?php

namespace App\Livewire\Admin\Park\Details\Reachability;

use App\Models\ParkReachability;
use App\Models\ReachabilityMode;
use Livewire\Component;

class Reachability extends Component
{
    public $park, $characterDetails;
    public $availableReachabilities = [], $selectedReachabilityListes = [], $ReachabilityListes = [];

    public function mount($park = null, $characterstic = null)
    {
        $this->park = $park;
        $this->characterDetails = $characterstic;
        $this->availableReachabilities = ReachabilityMode::where('status', true)->pluck('title', 'reachability_modes_id')->toArray();
        $this->ReachabilityListes = ParkReachability::where('park_id', $this->park->id)
            ->whereIn('reachability_id', array_keys($this->availableReachabilities))
            ->get()
            ->keyBy('reachability_id');
        foreach ($this->availableReachabilities as $id => $title) {
            $this->selectedReachabilityListes[$id] = [
                'title' => $title,
                'description' => $this->ReachabilityListes[$id]->description ?? '',
            ];
        }
        $this->dispatch('initializeCKEditor');
    }

    public function render()
    {
        $this->ReachabilityListes = ParkReachability::where('park_id', $this->park->id)
            ->whereIn('reachability_id', array_keys($this->availableReachabilities))
            ->get()
            ->keyBy('reachability_id');
        return view('livewire.admin.park.details.reachability.reachability');
    }

    public function storereachability()
    {
        $filledCount = 0;
        foreach ($this->selectedReachabilityListes as $reachability) {
            if (empty($reachability['description'])) {
                $filledCount++;
            }
        }

        if (count($this->selectedReachabilityListes) == $filledCount) {
            return $this->dispatch('swal:toast', [
                'type' => 'error',
                'title' => '',
                'message' => 'Please fill at least one reachability.'
            ]);
        }

        if (count($this->ReachabilityListes) > 0) {

            foreach ($this->selectedReachabilityListes as $id => $reachability) {
                ParkReachability::where('park_id', $this->park->id)->where('reachability_id', $id)->update([
                    'title' => $reachability['title'],
                    'description' => $reachability['description'],
                ]);
            }
        } else {
            foreach ($this->selectedReachabilityListes as $id => $reachability) {
                if (!empty($reachability['description'])) {
                    ParkReachability::create([
                        'title' => $reachability['title'],
                        'description' => $reachability['description'],
                        'park_id' => $this->park->id,
                        'reachability_id' => $id,
                    ]);
                }
            }
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Reachability Added Successfully']);
    }
}
