<?php

namespace App\Livewire\Admin\SiteSetting;

use App\Models\SiteSetting;
use Livewire\Component;

class SocialLinkSetting extends Component
{
    public $settings, $value = [], $status = [];
    public $key = [
        'facebook_link' => '',
        'twitter_link' => '',
        'instagram_link' => '',
        'linkedin_link' => '',
        'facebook_status' => false,
        'twitter_status' => false,
        'instagram_status' => false,
        'linkedin_status' => false,
    ];

    public function mount()
    {
        $this->settings = $settings = SiteSetting::pluck('value', 'key');

        if ($this->settings) {

            $this->key['facebook_link'] = $settings['facebook_link'] ?? '';
            $this->key['twitter_link'] = $settings['twitter_link'] ?? '';
            $this->key['instagram_link'] = $settings['instagram_link'] ?? '';
            $this->key['linkedin_link'] = $settings['linkedin_link'] ?? '';
            $this->key['pinterest_link'] = $settings['pinterest_link'] ?? '';

            $this->key['facebook_status'] = (bool) ($settings['facebook_status'] ?? false);
            $this->key['twitter_status'] = (bool) ($settings['twitter_status'] ?? false);
            $this->key['instagram_status'] = (bool) ($settings['instagram_status'] ?? false);
            $this->key['linkedin_status'] = (bool) ($settings['linkedin_status'] ?? false);
            $this->key['pinterest_status'] = (bool) ($settings['pinterest_status'] ?? false);
        }
    }

    protected $rules = [
        'key.facebook_link' => 'required|url',
        'key.twitter_link' => 'required|url',
        'key.instagram_link' => 'required|url',
        'key.linkedin_link' => 'required|url',
        'key.pinterest_link' => 'required|url',
        'key.facebook_status' => 'required',
        'key.twitter_status' => 'required',
        'key.instagram_status' => 'required',
        'key.linkedin_status' => 'required',
        'key.pinterest_status' => 'required',
    ];

    protected $messages = [
        'key.facebook_link.required' => 'Facebook link is required.',
        'key.facebook_link.url' => 'Please provide a valid URL for Facebook.',
        'key.twitter_link.required' => 'Twitter link is required.',
        'key.twitter_link.url' => 'Please provide a valid URL for Twitter.',
        'key.instagram_link.required' => 'Instagram link is required.',
        'key.instagram_link.url' => 'Please provide a valid URL for Instagram.',
        'key.linkedin_link.required' => 'LinkedIn link is required.',
        'key.linkedin_link.url' => 'Please provide a valid URL for LinkedIn.',
        'key.pinterest_link.required' => 'Pinterest link is required.',
        'key.pinterest_link.url' => 'Please provide a valid URL for LinkedIn.',
        'key.facebook_status.required' => 'Please enable or disable the Facebook link.',
        'key.twitter_status.required' => 'Please enable or disable the Twitter link.',
        'key.instagram_status.required' => 'Please enable or disable the Instagram link.',
        'key.linkedin_status.required' => 'Please enable or disable the LinkedIn link.',
        'key.pinterest_status.required' => 'Please enable or disable the Pinterest link.',
    ];

    public function render()
    {
        return view('livewire.admin.site-setting.social-link-setting');
    }

    public function save()
    {
        $this->validate();

        foreach ($this->key as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        foreach ($this->status as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key . '_status'],
                ['value' => $value]
            );
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Social Links and Settings updated successfully.']);
    }
}
