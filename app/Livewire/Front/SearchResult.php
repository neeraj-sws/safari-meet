<?php

namespace App\Livewire\Front;

use App\Models\Park;
use Livewire\Component;
use Livewire\Attributes\Layout;

class SearchResult extends Component
{
    public $parkLists = [];
    public $search = '';
    public $limit = 8, $totalCount = 0, $state;

    public function mount($state = null)
    {
        $this->state = base64_decode($state);
        $this->loadParks();
    }

    public function updatedSearch()
    {
        $this->limit = 8;
        $this->loadParks();
    }

    public function loadMore()
    {
        $this->limit += 8;
        $this->loadParks();
    }
    public function loadParks()
    {
        $query = Park::query();

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        if (!empty($this->state)) {
            $query->where('state_id', $this->state);
        }
        $this->totalCount = $query->count();
        $this->parkLists = $query
            ->where('status', 1)
            ->orderBy('park_id', 'desc')
            ->limit($this->limit)
            ->get();
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.front.search-result');
    }
}
