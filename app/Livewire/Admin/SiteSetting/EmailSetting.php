<?php

namespace App\Livewire\Admin\SiteSetting;

use App\Models\SiteSetting;
use Livewire\Component;

class EmailSetting extends Component
{
    public $key = [
        'mail_mailer' => '',
        'mail_host' => '',
        'mail_port' => '',
        'mail_username' => '',
        'mail_password' => '',
        'mail_encryption' => '',
        'mail_from_address' => '',
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
        return view('livewire.admin.site-setting.email-setting');
    }

    public function save()
    {
        $this->validate([
            'key.mail_mailer' => 'required|string',
            'key.mail_host' => 'required',
            'key.mail_port' => 'required|numeric',
            'key.mail_username' => 'required',
            'key.mail_password' => 'required',
            'key.mail_encryption' => 'nullable|string',
            'key.mail_from_address' => 'required|email',
        ]);

        // Save in DB
        foreach ($this->key as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->updateEnv([
            'MAIL_MAILER' => $this->key['mail_mailer'],
            'MAIL_HOST' => $this->key['mail_host'],
            'MAIL_PORT' => $this->key['mail_port'],
            'MAIL_USERNAME' => $this->key['mail_username'],
            'MAIL_PASSWORD' => $this->key['mail_password'],
            'MAIL_ENCRYPTION' => $this->key['mail_encryption'],
            'MAIL_FROM_ADDRESS' => $this->key['mail_from_address'],
        ]);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => '',
            'message' => 'Email Configuration updated successfully.'
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
