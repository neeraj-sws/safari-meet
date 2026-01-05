<?php

namespace App\Livewire\Admin\SiteSetting;

use App\Helpers\ImageHelper;
use App\Helpers\ImageUploadHelper;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SiteSetting;
use App\Models\Upload;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;

class SiteSettingForm extends Component
{
    use WithFileUploads;

    public $site_name, $site_email, $footer_text, $site_logo, $existing_logo;
    public $pageTitle = "Site Setting";

    public $key = [], $value = [];

    public $favicon;

    public $settings;

    public function mount()
    {
        $this->settings = $settings = SiteSetting::pluck('value', 'key');

        if ($this->settings) {
            $this->key['site_name'] = $settings['site_name'] ?? '';
            $this->key['site_email'] = $settings['site_email'] ?? '';
            $this->key['footer_text'] = $settings['footer_text'] ?? '';
            $this->key['existing_logo'] = $settings['site_logo'] ?? '';
            $this->key['site_status'] = $settings['site_status'] ?? 'live';
            $this->key['timezone'] = $settings['timezone'] ?? config('app.timezone');
            $this->key['language'] = $settings['language'] ?? 'en';
            $this->key['existing_favicon'] = $settings['favicon'] ?? '';
            $this->key['publish_user_sharedsafari'] = $settings['publish_user_sharedsafari'] ?? '';
            $this->key['publish_agent_sharedsafari'] = $settings['publish_agent_sharedsafari'] ?? '';
            $this->key['phone_number'] = $settings['phone_number'] ?? '';
            $this->key['address'] = $settings['address'] ?? '';
        }
    }

    public function save()
    {
        $this->validate($this->rules());


        if (!empty($this->favicon)) {
            $faviconImage = $this->favicon;
            $path = 'uploads/site-icons';
            // $origPath = $faviconImage->store($path, 'public_root');

            // $avifPath = ImageHelper::convertToAvif($origPath, $path);
            $avifPath = ImageUploadHelper::upload($faviconImage, $path);

            Upload::create([
                'original_name' => $faviconImage->getClientOriginalName(),
                'avif_path' => $avifPath,
            ]);

            $faviconPath = $avifPath;
        } else {
            $faviconPath = $this->key['existing_favicon'];
        }
        $this->key['favicon'] = $this->key['existing_favicon'] = $faviconPath;

        if (!empty($this->site_logo)) {
            $image = $this->site_logo;
            $path = 'uploads/site-logos';
            // $origPath = $image->store($path, 'public_root');
            $avifPath = ImageUploadHelper::upload($image, $path);
            $upload = Upload::create([
                'original_name' => $image->getClientOriginalName(),
                'avif_path' => $avifPath,
            ]);

            $logoPath = $avifPath;
        } else {
            $logoPath = $this->key['existing_logo'];
        }

        $this->key['site_logo'] = $this->key['existing_logo'] = $logoPath;

        foreach ($this->key as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                ]
            );

            $siteStatus = $this->key['site_status'] ?? null;
            if ($siteStatus === 'maintenance') {
                try {
                    Artisan::call('down', [
                        '--render' => 'errors.maintenance',
                        '--secret' => 'letmein',
                    ]);
                } catch (\Exception $e) {
                }
            } elseif ($siteStatus === 'live') {
                try {
                    Artisan::call('up');
                } catch (\Exception $e) {
                }
            }
        }

        $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Settings updated successfully.']);
    }

    public function rules()
    {
        return [
            'key' => 'required|array',
            'key.site_name' => 'required|string|max:255',
            'key.site_email' => 'required|email|max:255',
            'key.footer_text' => 'nullable|string',
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'key.site_status' => 'required|in:live,maintenance',
            'key.timezone' => 'required|string',
            'key.language' => 'required|string|max:5',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,ico,webp|max:512',
            'key.phone_number' => 'required|digits:10',
            'key.address' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'key.site_name.required' => 'The site name is required.',
            'key.site_name.string' => 'The site name must be a valid string.',
            'key.site_name.max' => 'The site name may not be greater than 255 characters.',

            'key.site_email.required' => 'The site email is required.',
            'key.site_email.email' => 'Please provide a valid email address.',
            'key.site_email.max' => 'The site email may not be greater than 255 characters.',

            'key.footer_text.string' => 'The footer text must be a string.',

            'site_logo.image' => 'The site logo must be an image.',
            'site_logo.mimes' => 'The site logo must be a file of type: jpg, jpeg, png, webp.',
            'site_logo.max' => 'The site logo must not be greater than 2MB.',

            'key.site_status.required' => 'The site status is required.',
            'key.site_status.in' => 'The selected site status is invalid.',

            'key.timezone.required' => 'The timezone is required.',
            'key.timezone.string' => 'The timezone must be a valid string.',

            'key.language.required' => 'The language is required.',
            'key.language.string' => 'The language must be a string.',
            'key.language.max' => 'The language code may not be greater than 5 characters.',

            'favicon.image' => 'The favicon must be an image.',
            'favicon.mimes' => 'The favicon must be a file of type: jpg, jpeg, png, ico, webp.',
            'favicon.max' => 'The favicon must not be greater than 512KB.',

            'key.phone_number.required' => 'The phone number is required.',
            'key.phone_number.digits' => 'The phone number must be exactly 10 digits.',

            'key.address.required' => 'Please provide your address.',
            'key.address.string' => 'The address must be a valid string.',
            'key.address.max' => 'The address may not be greater than 500 characters.',
        ];
    }


    public function render()
    {
        return view('livewire.admin.site-setting.site-setting-form');
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
