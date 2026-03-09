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
<<<<<<< HEAD
        'UPI_ID' => "",
        'UPI_MERCHANT_NAME' => '',
=======
        'QR_IMAGE' => null,
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    ];

    public $existingQrImage; // for showing saved image

    public function mount()
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        foreach ($this->key as $k => $v) {
<<<<<<< HEAD
            $this->key[$k] = $settings[$k] ?? '';
=======
            if ($k === 'QR_IMAGE') {
                $this->existingQrImage = $settings[$k] ?? null;
            } else {
                $this->key[$k] = $settings[$k] ?? '';
            }
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        }
    }

    public function save()
    {
<<<<<<< HEAD
        $this->validate(
            [
                'key.USER_SAFARI_PRICE'   => 'required|integer',
                'key.AGENT_SAFARI_PRICE'  => 'required|integer',
                'key.AGENT_PACKAGE_PRICE' => 'required|integer',
                'key.UPI_ID'              => 'required|string',
                'key.UPI_MERCHANT_NAME'   => 'required|string',
            ],
            [
                'key.USER_SAFARI_PRICE.required'    => 'User Safari Price is required.',
                'key.USER_SAFARI_PRICE.integer'     => 'User Safari Price must be a number.',

                'key.AGENT_SAFARI_PRICE.required'   => 'Agent Safari Price is required.',
                'key.AGENT_SAFARI_PRICE.integer'    => 'Agent Safari Price must be a number.',

                'key.AGENT_PACKAGE_PRICE.required'  => 'Agent Package Price is required.',
                'key.AGENT_PACKAGE_PRICE.integer'   => 'Agent Package Price must be a number.',

                'key.UPI_ID.required'               => 'UPI ID is required.',
                'key.UPI_ID.string'                 => 'UPI ID must be a valid text.',

                'key.UPI_MERCHANT_NAME.required'    => 'UPI Merchant Name is required.',
                'key.UPI_MERCHANT_NAME.string'      => 'UPI Merchant Name must be valid text.',
            ]
        );

        foreach ($this->key as $key => $value) {

=======
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

>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
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
