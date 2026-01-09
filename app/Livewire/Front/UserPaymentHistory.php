<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Services\Payment\UserPaymentHistoryService;

#[Layout('components.layouts.guest')]
class UserPaymentHistory extends Component
{
    use WithPagination;

    public $status = '';

    protected $queryString = [
        'status' => ['except' => ''],
    ];

    /**
     * Reset pagination when filter changes
     */
    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render(UserPaymentHistoryService $service)
    {
        return view('livewire.front.user-payment-history', [
            'paymentsByMonth' => $service->getUserPayments([
                'status' => $this->status,
            ]),
        ]);
    }

    /**
     * Detail page link based on payable type
     */
    public function getDetailUrl($payment): string
    {
        if (! $payment->payable) {
            return '#';
        }

        return match ($payment->payable_type) {
            \App\Models\ShareSafari::class =>
            route('shared-safari.detail', $payment->payable->slug),

            \App\Models\Package::class =>
            route('safari-package.detail', $payment->payable->slug),

            default => '#',
        };
    }
}
