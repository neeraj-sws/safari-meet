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
        'UPI_ID' => "",
        'UPI_MERCHANT_NAME' => '',
    ];

    public $existingQrImage; // for showing saved image

    public function mount()
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        foreach ($this->key as $k => $v) {
            $this->key[$k] = $settings[$k] ?? '';
        }
    }

    public function save()
    {
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
