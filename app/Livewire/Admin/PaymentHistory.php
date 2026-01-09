<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin-app')]
class PaymentHistory extends Component
{
    use WithPagination;

    public $pageTitle = 'Transaction History';
    public $search = '';
    public $filter_type = ''; // shared-safari | safari-package

    protected $queryString = ['search', 'filter_type'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Payment::with(['user', 'payable'])
            ->when($this->filter_type, function ($q) {
                $q->where('payable_type', $this->filter_type);
            })
            ->when($this->search, function ($q) {
                $q->whereHas('user', function ($u) {
                    $u->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('utr', 'like', '%' . $this->search . '%');
            });

        $payments = $query->latest()->paginate(10);

        return view('livewire.admin.payment-history', compact('payments'));
    }

    public function getDetailUrl($payment): ?string
    {
        return match ($payment->payable_type) {
            'App\Models\ShareSafari' => route(
                'shared-safari.detail',
                $payment->payable->slug
            ),

            'App\Models\Package' => route(
                'safari-package.detail',
                $payment->payable->slug
            ),

            default => '#',
        };
    }
}
