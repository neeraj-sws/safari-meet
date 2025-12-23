<?php

namespace App\Livewire\Admin\SiteSetting;

use App\Models\SiteSetting;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

#[Layout('components.layouts.admin-app')]
class AdminSiteSetting extends Component
{
    public $pageTitle = "Site Setting";
    public $activeTab = "genral_setting";

    public function mount()
    {
        $activeTabName = request()->query('tab');
        if (!empty($activeTabName)) {
            $this->activeTab = $activeTabName;
        }
    }

    public function render()
    {
        return view('livewire.admin.site-setting.admin-site-setting');
    }

    public function changeTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function clearCache()
    {
        foreach (SiteSetting::pluck('key') as $key) {
            Cache::forget("setting_{$key}");
        }

        Cache::forget('site_settings_all');

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Site settings cache cleared successfully.',
        ]);
    }
}
