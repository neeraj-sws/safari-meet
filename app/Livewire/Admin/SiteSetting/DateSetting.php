<?php

namespace App\Livewire\Admin\SiteSetting;

use App\Models\SiteSetting;
use Livewire\Component;

class DateSetting extends Component
{
    public $settings, $key = [], $value = [];

    public function mount()
    {
        $this->settings = $settings = SiteSetting::pluck('value', 'key');

        if ($this->settings) {
            $this->key['enquiry_date_after'] = $settings['enquiry_date_after'] ?? '';
            $this->key['safari_date_after'] = $settings['safari_date_after'] ?? '';
        }
    }

    public function render()
    {
        return view('livewire.admin.site-setting.date-setting');
    }

    public function save()
    {
        $this->validate([
            'key.enquiry_date_after' => 'required|numeric',
            'key.safari_date_after' => 'required|numeric'
        ], [
            'key.enquiry_date_after' => 'The Enquiry date after field is required.',
            'key.safari_date_after' => 'The Safari date after field is required.'
        ]);

        foreach ($this->key as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                ]
            );
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Safari Settings updated successfully.']);
    }
}
