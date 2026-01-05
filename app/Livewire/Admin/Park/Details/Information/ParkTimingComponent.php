<?php

namespace App\Livewire\Admin\Park\Details\Information;

use App\Models\{ParkSafariTimeDetail, ParkSafariTime, WeatherModel};
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ParkTimingComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $park, $weatherTypes, $weather_type, $monthSlots = [], $type;
    public $deleteId;

    public function mount($park = null)
    {
        $this->park = $park;
        $this->weatherTypes = WeatherModel::where('status', true)->get();
    }

    public function render()
    {
        $query = ParkSafariTimeDetail::with('parktiming')
            ->whereHas('parktiming', fn($q) => $q->where('park_id', $this->park->id));

        if ($this->type) {
            $query->where('slot_type', $this->type);
        }

        $slotLists = $query->latest()->paginate(10);
        return view('livewire.admin.park.details.information.park-timing-component', compact('slotLists'));
    }

    public function updatedWeatherType($id)
    {
        if (!$id) {
            $this->reset(['monthSlots', 'weather_type']);
            return;
        }

        $weatherData = WeatherModel::where('park_weather_id', $id)->first();
        if (!$weatherData) return;

        $this->monthSlots = [];
        $startMonth = (int)$weatherData->start;
        $endMonth = (int)$weatherData->end;

        $months = $startMonth > $endMonth
            ? array_merge(range($startMonth, 12), range(1, $endMonth))
            : range($startMonth, $endMonth);

        foreach ($months as $monthNum) {
            $monthName = Carbon::createFromDate(null, $monthNum, 1)->format('F');
            $this->monthSlots[] = ['month' => $monthName, 'morning' => '', 'evening' => ''];
        }
    }

    public function storeSlots()
    {
        $this->validate([
            'monthSlots.*.morning' => 'required|string|min:3|max:60',
            'monthSlots.*.evening' => 'required|string|min:3|max:60',
            'weather_type' => 'required',
        ]);

        $weatherData = WeatherModel::where('park_weather_id', $this->weather_type)->first();
        if (!$weatherData) return;

        $start = Carbon::createFromDate(null, $weatherData->start, 1)->format('F');
        $end = Carbon::createFromDate(null, $weatherData->end, 1)->format('F');

        $parkTime = ParkSafariTime::create([
            'park_id' => $this->park->id,
            'weather_id' => $weatherData->id,
            'start' => $start,
            'end' => $end,
        ]);

        foreach ($this->monthSlots as $slot) {
            ParkSafariTimeDetail::create([
                'park_safari_time_id' => $parkTime->id,
                'month' => $slot['month'],
                'slot_type' => 'Morning',
                'start_time' => $slot['morning'],
            ]);

            ParkSafariTimeDetail::create([
                'park_safari_time_id' => $parkTime->id,
                'month' => $slot['month'],
                'slot_type' => 'Evening',
                'start_time' => $slot['evening'],
            ]);
        }

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Time Added Successfully',
        ]);

        $this->reset(['monthSlots', 'weather_type']);
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
            'action' => 'deleteConfirmed',
        ]);
    }


    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $slot = ParkSafariTimeDetail::find($this->deleteId);
        if (!$slot) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => 'Slot not found!',
            ]);
            return;
        }

        $slotCount = ParkSafariTimeDetail::where('park_safari_time_id', $slot->park_safari_time_id)->count();
        if ($slotCount > 1) {
            $slot->delete();
        } else {
            ParkSafariTime::find($slot->park_safari_time_id)?->delete();
            $slot->delete();
        }

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Slot deleted successfully!',
        ]);
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->reset(['monthSlots', 'weather_type']);
    }
}
