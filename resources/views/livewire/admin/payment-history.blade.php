<div class="container">

    @include('livewire.components.breadcrumb', [
        'menu' => 'Transaction',
        'submenus' => ['Transaction History'],
    ])

    <div class="card">
        <div class="card-body">

            {{-- Filters --}}
            <div class="d-flex gap-2 mb-3">
                <input type="text" class="form-control" placeholder="Search user / UTR"
                    wire:model.live.debounce.300ms="search">

                <select class="form-select" wire:model.live.debounce.300ms="filter_type">
                    <option value="">All Types</option>
                    <option value="App\Models\ShareSafari">Shared Safari</option>
                    <option value="App\Models\Package">Safari Package</option>
                </select>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Safari / Package</th>
                            <th>Amount</th>
                            <th>Discount</th>
                            <th>Final Amount</th>
                            <th>UTR</th>
                            <th>Screenshot</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($payments as $index => $payment)
                            <tr>
                                <td>{{ $index + $payments->firstItem() }}</td>

                                <td>
                                    @if ($payment->user)
                                        {{ $payment->user->name }} <br>
                                        <small>{{ $payment->user->email }}</small>
                                    @else
                                        <span class="text-danger">User Deleted</span>
                                    @endif
                                </td>


                                <td class="text-capitalize">
                                    {{ str_replace('-', ' ', $payment->payable_type) }}
                                </td>

                                <td>
                                    @if ($payment->payable)
                                        <a href="{{ $this->getDetailUrl($payment) }}" target="_blank"
                                            class="fw-semibold text-primary">
                                            {{ $payment->payable->title ?? 'View' }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>

                                <td>₹{{ $payment->amount }}</td>
                                <td>₹{{ $payment->discounted_amount ?? 0 }}</td>
                                <td class="fw-bold">₹{{ $payment->final_amount }}</td>

                                <td>{{ $payment->utr ?? '—' }}</td>

                                <td>
                                    @if ($payment->screenshot)
                                        <a href="{{ asset($payment->screenshot) }}" target="_blank">
                                            View
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>{{ $payment->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">
                                    No payment records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
