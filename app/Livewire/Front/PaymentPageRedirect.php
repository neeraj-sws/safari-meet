<?php

namespace App\Livewire\Front;

use App\Helpers\ImageUploadHelper;
use App\Helpers\UserHelper;
use App\Mail\DynamicMail;
use App\Models\{Admin, Package, ShareSafari, Payment};
use App\Helpers\SettingHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.guest')]
class PaymentPageRedirect extends Component
{
    use WithFileUploads;

    public $type, $uuid;
    public $safariData;
    public $paymentDetails;

    public $rrn;
    public $screenshot;

    public function mount($type, $uuid)
    {
        $this->type = $type;
        $this->uuid = $uuid;

        $this->safariData = $this->getSafariData();
        $this->paymentDetails = $this->getPaymentDetails();
    }

    private function getSafariData()
    {
        return match ($this->type) {
            'shared-safari' =>
            ShareSafari::with('park.state', 'park.country')
                ->where('uuid', $this->uuid)->firstOrFail(),

            'safari-package' =>
            Package::with('park.state', 'park.country')->where('uuid', $this->uuid)->firstOrFail(),

            default => abort(404)
        };
    }

    private function getPaymentDetails(): array
    {
        return [
            'price' => match ($this->type) {
                'shared-safari' =>
                Auth::user()->user_type == 1
                ? SettingHelper::get('AGENT_SAFARI_PRICE')
                : SettingHelper::get('USER_SAFARI_PRICE'),

                'safari-package' =>
                SettingHelper::get('AGENT_PACKAGE_PRICE')
            },
            'qr_image' => SettingHelper::get('QR_IMAGE'),
        ];
    }

    public function submitPaymentProof()
    {
        $this->validate([
            'screenshot' => 'nullable|image|max:2048',
            'rrn' => 'nullable|string|max:255',
        ]);

        if (!$this->screenshot && !$this->rrn) {
            $this->addError('screenshot', 'At least one of screenshot or RRN number is required.');
            $this->addError('rrn', 'At least one of screenshot or RRN number is required.');
            return;
        }

        $screenshotPath = null;
        if ($this->screenshot) {
            $screenshotPath = ImageUploadHelper::upload($this->screenshot, 'uploads/payments');
        }

        $payment = Payment::create([
            'user_id' => Auth::id(),
            'payable_type' => $this->type,
            'payable_id' => $this->safariData->id,
            'amount' => $this->paymentDetails['price'],
            'rrn' => $this->rrn,
            'screenshot' => $screenshotPath,
        ]);
        $this->safariData->is_paid = 1;
        $this->safariData->save();

        $this->sendPaymentReceivedMailToAdmin($payment);
        $this->sendPaymentSubmittedMailToUser($payment);

        if($this->type == 'safari-package'){
            return redirect()
                ->route('agent.package.package')
                ->with('success', 'Payment submitted successfully');
        }else{
              return redirect()
                ->route('profileusersafari', [
                    'type' => 'shared-safari',
                    'tab' => 'shared-safari',
                ])
                ->with('success', 'Payment submitted successfully');
        }

    }

    private function sendPaymentReceivedMailToAdmin(Payment $payment): void
    {
        $admin = Admin::first();

        $data = [
            'name' => $admin->name,
            'safari_name' => $this->safariData->title ?? '',
            'safari_type' => $this->type === 'shared-safari' ? 'Shared Safari' : 'Safari Package',
            'amount' => $payment->amount,
            'payment_status' => 'Pending Verification',
            'rrn' => $payment->rrn ?? 'Image',
            'payment_date' => optional($payment->created_at)->format('d M Y'),
            'year' => date('Y'),
        ];

        $parsed = UserHelper::parseTemplate('PAYMENTRECEIVED', $data);

        Mail::to($admin->email)->queue(
            new DynamicMail(
                $parsed['subject'],
                $parsed['body'],
                $payment->screenshot
            )
        );
    }


    private function sendPaymentSubmittedMailToUser(Payment $payment): void
    {
        $user = Auth::user();

        $data = [
            'name' => $user->name,
            'safari_name' => $this->safariData->title ?? '',
            'safari_type' => $this->type === 'shared-safari' ? 'Shared Safari' : 'Safari Package',
            'amount' => $payment->amount,
            'payment_status' => 'Pending Approval',
            'rrn' => $payment->rrn ?? 'Image',
            'image' => '',
            'year' => date('Y'),
        ];

        $parsed = UserHelper::parseTemplate('PAYMENTSUBMITTED', $data);

        Mail::to($user->email)->queue(
            new DynamicMail(
                $parsed['subject'],
                $parsed['body'],
                $payment->screenshot
            )
        );
    }




    public function render()
    {
        return view('livewire.front.payment-page-redirect');
    }
}
