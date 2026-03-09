<?php

namespace App\Livewire\Front;

<<<<<<< HEAD
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

=======
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
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b

#[Layout('components.layouts.guest')]
class PaymentPageRedirect extends Component
{
    use WithFileUploads;

    public $type, $uuid;
    public $safariData;
<<<<<<< HEAD

    public $baseAmount;
    public $finalAmount;
    public $discount = 0;

    public $qrCode;

    public $showCoupon = false;
    public $couponCode;
    public $appliedCoupon;

    public $utr;
    public $screenshot;

    public function isPaymentProofRequired(): bool
    {
        return $this->finalAmount > 0;
    }

    public function getSubmitButtonTextProperty(): string
    {
        return $this->isPaymentProofRequired()
            ? 'Submit Payment Proof'
            : 'Confirm Booking';
    }

    public function mount(QrCodeGenerator $qrGenerator, $type, $uuid)
=======
    public $paymentDetails;

    public $rrn;
    public $screenshot;

    public function mount($type, $uuid)
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    {
        $this->type = $type;
        $this->uuid = $uuid;

        $this->safariData = $this->getSafariData();
<<<<<<< HEAD
        $this->baseAmount = $this->getBaseAmount();
        $this->finalAmount = $this->baseAmount;

        $this->qrCode = $qrGenerator->generate(
            $this->finalAmount,
            'Order Payment'
        );
=======
        $this->paymentDetails = $this->getPaymentDetails();
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
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

<<<<<<< HEAD
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
        $this->appliedCoupon = $result['coupon'];
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
       $rules = [
            'screenshot' => 'nullable|image|max:15360',
            'utr' => 'nullable|string|max:255',
        ];

        $messages = [
            'screenshot.image' => 'The screenshot must be a valid image file.',
            'screenshot.max' => 'The screenshot must not be larger than 15 MB.',
            'utr.string' => 'The UTR must be a valid text value.',
            'utr.max' => 'The UTR may not be greater than 255 characters.',
        ];

        $this->validate($rules, $messages);

        // Only require payment proof if amount is greater than 0
        if ($this->isPaymentProofRequired() && !$this->screenshot && !$this->utr) {
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
            $this->appliedCoupon
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
=======
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
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            'name' => $admin->name,
            'safari_name' => $this->safariData->title ?? '',
            'safari_type' => $this->type === 'shared-safari' ? 'Shared Safari' : 'Safari Package',
            'amount' => $payment->amount,
            'payment_status' => 'Pending Verification',
            'rrn' => $payment->rrn ?? 'Image',
            'payment_date' => optional($payment->created_at)->format('d M Y'),
            'year' => date('Y'),
<<<<<<< HEAD
        ]);

        // Mail::to($admin->email)->queue(
        //     new DynamicMail($parsed['subject'], $parsed['body'], $payment->screenshot)
        // );
         dispatch(function () use ($admin, $parsed, $payment) {
            Mail::to($admin->email)->send(
                new DynamicMail($parsed['subject'], $parsed['body'], $payment->screenshot)
            );
        })->afterResponse();
    }

    private function sendMailToUser(Payment $payment)
    {
        $user = Auth::user();

        $parsed = UserHelper::parseTemplate('PAYMENTSUBMITTED', [
=======
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
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            'name' => $user->name,
            'safari_name' => $this->safariData->title ?? '',
            'safari_type' => $this->type === 'shared-safari' ? 'Shared Safari' : 'Safari Package',
            'amount' => $payment->amount,
            'payment_status' => 'Pending Approval',
            'rrn' => $payment->rrn ?? 'Image',
            'image' => '',
            'year' => date('Y'),
<<<<<<< HEAD
        ]);

        // Mail::to($user->email)->queue(
        //     new DynamicMail($parsed['subject'], $parsed['body'], $payment->screenshot)
        // );

        dispatch(function () use ($user, $parsed) {
            Mail::to($user->email)->send(
                new DynamicMail($parsed['subject'], $parsed['body'])
            );
        })->afterResponse();
    }
=======
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




>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
    public function render()
    {
        return view('livewire.front.payment-page-redirect');
    }
}
