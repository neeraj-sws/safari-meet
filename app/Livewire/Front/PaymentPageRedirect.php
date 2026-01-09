<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

use App\Helpers\{UserHelper, SettingHelper};
use App\Models\{Admin, Package, ShareSafari, Payment};
use App\Mail\DynamicMail;
use Illuminate\Support\Facades\Mail;

use App\Services\Payment\{
    CouponService,
    AmountCalculator,
    QrCodeGenerator,
    PaymentSubmissionService
};


#[Layout('components.layouts.guest')]
class PaymentPageRedirect extends Component
{
    use WithFileUploads;

    public $type, $uuid;
    public $safariData;

    public $baseAmount;
    public $finalAmount;
    public $discount = 0;

    public $qrCode;

    public $showCoupon = false;
    public $couponCode;

    public $utr;
    public $screenshot;

    public function mount(QrCodeGenerator $qrGenerator, $type, $uuid)
    {
        $this->type = $type;
        $this->uuid = $uuid;

        $this->safariData = $this->getSafariData();
        $this->baseAmount = $this->getBaseAmount();
        $this->finalAmount = $this->baseAmount;

        $this->qrCode = $qrGenerator->generate(
            $this->finalAmount,
            'Order Payment'
        );
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

    private function getBaseAmount(): float
    {
        return match ($this->type) {
            'shared-safari' =>
            Auth::user()->user_type == 1
                ? SettingHelper::get('AGENT_SAFARI_PRICE')
                : SettingHelper::get('USER_SAFARI_PRICE'),

            'safari-package' =>
            SettingHelper::get('AGENT_PACKAGE_PRICE'),
        };
    }

    public function applyCoupon(CouponService $couponService, AmountCalculator $calculator, QrCodeGenerator $qrGenerator)
    {
        $this->resetErrorBag();

        if (empty($this->couponCode)) {
            $this->addError('couponCode', "Coupon Code is required");
            return;
        }

        $result = $couponService->apply(
            $this->couponCode,
            $this->baseAmount
        );

        if (!$result['valid']) {
            $this->addError('couponCode', $result['message']);
            return;
        }

        $this->discount = $result['discount'];
        $this->finalAmount = $calculator->calculate(
            $this->baseAmount,
            $this->discount
        );

        $this->qrCode = $qrGenerator->generate(
            $this->finalAmount,
            'Discounted Payment'
        );
    }


    public function submitPaymentProof(
        PaymentSubmissionService $paymentService
    ) {
        $this->validate([
            'screenshot' => 'nullable|image|max:2048',
            'utr' => 'nullable|string|max:255',
        ]);
       
        if (!$this->screenshot && !$this->utr) {
            $this->addError('utr', 'Screenshot or UTR / Transaction ID is required');
            $this->addError('screenshot', 'Screenshot or  UTR / Transaction ID is required');
            return;
        }

        $payment = $paymentService->submit(
            $this->safariData,
            $this->type,
            $this->baseAmount,
            $this->utr,
            $this->screenshot,
            $this->discount,
            $this->finalAmount,
            $this->couponCode,

        );

        $this->sendMailToAdmin($payment);
        $this->sendMailToUser($payment);
        if ($this->type == "safari-package") {
            return redirect()->route('agent.package.package')->with('success', 'Payment submitted');
        } else {
            return redirect()->route('profileusersafari', ['tab' => "shared-safari"])->with('success', 'Payment submitted');
        }
    }

    private function sendMailToAdmin(Payment $payment)
    {
        $admin = Admin::first();

        $parsed = UserHelper::parseTemplate('PAYMENTRECEIVED', [
            'name' => $admin->name,
            'safari_name' => $this->safariData->title ?? '',
            'safari_type' => $this->type === 'shared-safari' ? 'Shared Safari' : 'Safari Package',
            'amount' => $payment->amount,
            'payment_status' => 'Pending Verification',
            'rrn' => $payment->rrn ?? 'Image',
            'payment_date' => optional($payment->created_at)->format('d M Y'),
            'year' => date('Y'),
        ]);

        Mail::to($admin->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'], $payment->screenshot)
        );
    }

    private function sendMailToUser(Payment $payment)
    {
        $user = Auth::user();

        $parsed = UserHelper::parseTemplate('PAYMENTSUBMITTED', [
            'name' => $user->name,
            'safari_name' => $this->safariData->title ?? '',
            'safari_type' => $this->type === 'shared-safari' ? 'Shared Safari' : 'Safari Package',
            'amount' => $payment->amount,
            'payment_status' => 'Pending Approval',
            'rrn' => $payment->rrn ?? 'Image',
            'image' => '',
            'year' => date('Y'),
        ]);

        Mail::to($user->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'], $payment->screenshot)
        );
    }
    public function render()
    {
        return view('livewire.front.payment-page-redirect');
    }
}
