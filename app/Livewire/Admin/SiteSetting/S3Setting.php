<?php

namespace App\Livewire\Admin\SiteSetting;

use App\Models\SiteSetting;
use Livewire\Component;

class S3Setting extends Component
{
    public $key = [
        'AWS_ACCESS_KEY_ID' => '',
        'AWS_SECRET_ACCESS_KEY' => '',
        'AWS_DEFAULT_REGION' => '',
        'AWS_BUCKET' => '',
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
        return view('livewire.admin.site-setting.s3-setting');
    }

    public function save()
    {
        $this->validate([
            'key.AWS_ACCESS_KEY_ID' => 'required|string',
            'key.AWS_SECRET_ACCESS_KEY' => 'required|string',
            'key.AWS_DEFAULT_REGION' => 'required|string',
            'key.AWS_BUCKET' => 'required|string',
        ]);

        // Save in DB
        foreach ($this->key as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->updateEnv([
            'AWS_ACCESS_KEY_ID' => $this->key['AWS_ACCESS_KEY_ID'],
            'AWS_SECRET_ACCESS_KEY' => $this->key['AWS_SECRET_ACCESS_KEY'],
            'AWS_DEFAULT_REGION' => $this->key['AWS_DEFAULT_REGION'],
            'AWS_BUCKET' => $this->key['AWS_BUCKET'],
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
