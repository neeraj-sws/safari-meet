<?php

namespace App\Livewire\Front\Species;

use App\Helpers\UserHelper;
use App\Models\Species;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Cache;

class Listing extends Component
{
    public $perPage = 12;
    public $seoContents;

    public $search = '';
    public function mount()
    {
        $this->seoContents = Cache::remember('species', 1440, function () {
            return UserHelper::SeoDetails('species');
        });
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        $species = Species::where('status', 1)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('species_id', 'desc')
            ->limit($this->perPage)
            ->get();

        return view('livewire.front.species.list', compact('species'))->layoutData([
            'seoContents' => $this->seoContents,
        ]);
    }

    public function firstTimeLoading()
    {

    }

    public function loadMore()
    {
        $this->perPage += 12;
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->perPage = 12;
    }
}
