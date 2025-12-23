<?php

namespace App\Livewire\Admin\Park\Details\Information;

use App\Models\ParkZoneModel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ZoneManager extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $zoneType, $park;
    public $zones = [['zone_name' => '', 'entry_gate' => '', 'zoneType' => '']];
    public $deleteId;

    protected function rules()
    {
        return [
            'zones.*.zone_name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Zone Name cannot have leading or trailing spaces.');
                    }
                },
            ],
            'zones.*.entry_gate' => [
                'required',
                'string',
                'min:3',
                'max:50',
                function ($attribute, $value, $fail) {
                    if (trim($value) !== $value) {
                        $fail('Entry Gate cannot have leading or trailing spaces.');
                    }
                },
            ],
            'zones.*.zoneType' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'zones.*.zone_name.required' => 'Zone Name is required.',
            'zones.*.entry_gate.required' => 'Entry Gate is required.',
            'zones.*.zoneType.required' => 'Zone Type is required.',
        ];
    }

    public function mount($park = null)
    {
        $this->park = $park;
    }

    public function addRow()
    {
        $this->zones[] = ['zone_name' => '', 'entry_gate' => '', 'zoneType' => ''];
    }

    public function removeRow($index)
    {
        unset($this->zones[$index]);
        $this->zones = array_values($this->zones);
    }

    public function saveZones()
    {
        $this->validate();

        foreach ($this->zones as $zone) {
            if (!empty($zone['zone_name']) && !empty($zone['entry_gate']) && !empty($zone['zoneType'])) {
                ParkZoneModel::create([
                    'park_id' => $this->park->id,
                    'type' => $zone['zoneType'],
                    'zone_name' => ucwords($zone['zone_name']),
                    'entry_gate' => ucwords($zone['entry_gate']),
                ]);
            }
        }

        $this->zones = [['zone_name' => '', 'entry_gate' => '', 'zoneType' => '']];

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Zone(s) Added Successfully'
        ]);
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
            'action' => 'deleteZoneConfirmed',
        ]);
    }

    #[On('deleteZoneConfirmed')]
    public function deleteZoneConfirmed()
    {
        $zone = ParkZoneModel::find($this->deleteId);

        if (!$zone) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => 'Zone not found!'
            ]);
            return;
        }

        $zone->delete();

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Zone deleted successfully!'
        ]);
    }

    public function render()
    {
        $query = ParkZoneModel::where('park_id', $this->park->id);
        if ($this->zoneType) {
            $query->where('type', $this->zoneType);
        }
        $zoneList = $query->orderBy('updated_at', 'desc')->latest()->paginate(10);

        return view('livewire.admin.park.details.information.zone-manager', compact('zoneList'));
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->reset(['zones']);
    }
}
