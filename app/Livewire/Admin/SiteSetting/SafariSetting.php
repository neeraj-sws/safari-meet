<?php

namespace App\Livewire\Admin\SiteSetting;

use App\Models\SiteSetting;
use Livewire\Component;

class SafariSetting extends Component
{
    public $settings, $key = [], $value = [];

    public function mount()
    {
        $this->settings = $settings = SiteSetting::pluck('value', 'key');

        if ($this->settings) {
            $this->key['publish_user_sharedsafari'] = $settings['publish_user_sharedsafari'] ?? '';
            $this->key['publish_agent_sharedsafari'] = $settings['publish_agent_sharedsafari'] ?? '';
            $this->key['publish_show_booked_shared_safari'] = $settings['publish_show_booked_shared_safari'] ?? '';
        }
    }

    public function render()
    {
        return view('livewire.admin.site-setting.safari-setting');
    }

    public function save()
    {


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
