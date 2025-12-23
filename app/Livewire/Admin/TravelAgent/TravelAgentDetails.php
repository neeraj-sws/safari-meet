<?php

namespace App\Livewire\Admin\TravelAgent;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin-app')]
class TravelAgentDetails extends Component
{
    public $agent;

    public function mount($id)
    {
        $this->agent = User::with(['country','state','city'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.travel-agent.travel-agent-details');
    }
}
