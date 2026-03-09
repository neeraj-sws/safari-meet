<?php

namespace App\Services\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserPaymentHistoryService
{
    public function getUserPayments(array $filters = []): LengthAwarePaginator
    {
        return Payment::with('payable')
            ->where('user_id', Auth::id())
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            )
            ->latest()
            ->paginate(10);
    }
}
