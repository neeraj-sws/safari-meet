<?php

namespace App\Livewire\Admin\SiteSetting;

use App\Models\SiteSetting;
use Livewire\Component;

class SocialLoginConfiguration extends Component
{
    public $key = [
        'GOOGLE_CLIENT_ID' => '',
        'GOOGLE_CLIENT_SECRET' => '',
        'FACEBOOK_CLIENT_ID' => '',
        'FACEBOOK_CLIENT_SECRET' => '',
    ];

    public function mount()
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        foreach ($this->key as $k => $v) {
            $this->key[$k] = $settings[$k] ?? '';
        }
    }

    public function render()
    {
        return view('livewire.admin.site-setting.social-cogin-configuration');
    }

    public function save()
    {
        $this->validate([
            'key.GOOGLE_CLIENT_ID' => 'required|string',
            'key.GOOGLE_CLIENT_SECRET' => 'required|string',
            'key.FACEBOOK_CLIENT_ID' => 'required|string',
            'key.FACEBOOK_CLIENT_SECRET' => 'required|string',
        ]);

        // Save in DB
        foreach ($this->key as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->updateEnv([
            'GOOGLE_CLIENT_ID' => $this->key['GOOGLE_CLIENT_ID'],
            'GOOGLE_CLIENT_SECRET' => $this->key['GOOGLE_CLIENT_SECRET'],
            'FACEBOOK_CLIENT_ID' => $this->key['FACEBOOK_CLIENT_ID'],
            'FACEBOOK_CLIENT_SECRET' => $this->key['FACEBOOK_CLIENT_SECRET'],
        ]);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'S3 Configuration updated successfully.'
        ]);

    }

    private function updateEnv(array $data)
    {
        $path = base_path('.env');

        if (!file_exists($path)) {
            return;
        }

        $env = file_get_contents($path);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replace = "{$key}=\"{$value}\"";

            if (preg_match($pattern, $env)) {
                $env = preg_replace($pattern, $replace, $env);
            } else {
                $env .= "\n$replace";
            }
        }

        file_put_contents($path, $env);
    }


}
