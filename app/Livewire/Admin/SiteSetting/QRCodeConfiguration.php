<?php

namespace App\Livewire\Admin\SiteSetting;

use App\Helpers\ImageUploadHelper;
use App\Models\SiteSetting;
use Livewire\Component;
use Livewire\WithFileUploads;

class QRCodeConfiguration extends Component
{
    use WithFileUploads;

    public $key = [
        'USER_SAFARI_PRICE' => '',
        'AGENT_SAFARI_PRICE' => '',
        'AGENT_PACKAGE_PRICE' => '',
        'QR_IMAGE' => null,
    ];

    public $existingQrImage; // for showing saved image

    public function mount()
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        foreach ($this->key as $k => $v) {
            if ($k === 'QR_IMAGE') {
                $this->existingQrImage = $settings[$k] ?? null;
            } else {
                $this->key[$k] = $settings[$k] ?? '';
            }
        }
    }

    public function save()
    {
        $this->validate([
            'key.USER_SAFARI_PRICE' => 'required|integer',
            'key.AGENT_SAFARI_PRICE' => 'required|integer',
            'key.AGENT_PACKAGE_PRICE' => 'required|integer',
            'key.QR_IMAGE' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        foreach ($this->key as $key => $value) {

            if ($key === 'QR_IMAGE' && $value) {
                $path = 'uploads/QR';
                 ImageUploadHelper::delete($this->existingQrImage);
                $value = ImageUploadHelper::upload($value, $path);
                $this->existingQrImage = $value;
            }

            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'QR Code Configuration updated successfully.'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.site-setting.q-r-code-configuration');
    }
}
