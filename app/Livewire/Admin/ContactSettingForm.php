<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SiteSetting;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin-app')]
class ContactSettingForm extends Component
{
    public $pageTitle = "Contact Us Settings";
    public $contact_email, $contact_phone,$contact_whatsapp_phone, $contact_address, $contact_map_embed;
    public $facebook_url, $instagram_url, $twitter_url, $youtube_url, $linkedin_url;
    public function mount()
    {
        $this->contact_email = SiteSetting::getValue('contact_email');
        $this->contact_phone = SiteSetting::getValue('contact_phone');
        $this->contact_whatsapp_phone = SiteSetting::getValue('contact_whatsapp_phone');
        $this->contact_address = SiteSetting::getValue('contact_address');
        $this->contact_map_embed = SiteSetting::getValue('contact_map_embed');

        $this->facebook_url = SiteSetting::getValue('facebook_url');
        $this->instagram_url = SiteSetting::getValue('instagram_url');
        $this->twitter_url = SiteSetting::getValue('twitter_url');
        $this->youtube_url = SiteSetting::getValue('youtube_url');
        $this->linkedin_url = SiteSetting::getValue('linkedin_url');
    }
    public function render()
    {
        return view('livewire.admin.contact-setting-form');
    }

    public function save()
    {
        $this->validate([
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'contact_whatsapp_phone' => 'nullable|string|max:20',
            'contact_address' => 'required|string|max:255',
            'contact_map_embed' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        foreach (['contact_email' => $this->contact_email, 'contact_phone' => $this->contact_phone, 'contact_whatsapp_phone' => $this->contact_whatsapp_phone, 'contact_address' => $this->contact_address, 'contact_map_embed' => $this->contact_map_embed, 'facebook_url' => $this->facebook_url, 'instagram_url' => $this->instagram_url, 'twitter_url' => $this->twitter_url, 'youtube_url' => $this->youtube_url, 'linkedin_url' => $this->linkedin_url,] as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => $this->pageTitle . ' updated Successfully']);

    }
}
