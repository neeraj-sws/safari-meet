<div>
    <style>
        body {
            background-color: #f5f6fa;
        }

        .page-title {
            font-weight: 600;
        }

        .safari-badge {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .status-pill {
            font-size: 0.75rem;
            padding: 0.15rem 0.55rem;
            border-radius: 999px;
            font-weight: 500;
        }

        .status-paid {
            background-color: #d1f5e0;
            color: #137a42;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-refunded {
            background-color: #f8d7da;
            color: #842029;
        }

        .amount-text {
            font-weight: 600;
            text-align: right;
            white-space: nowrap;
        }

        .card-safari img {
            height: 70px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .card-safari {
            border-radius: 0.75rem;
            border: 1px solid #e7eaf3;
        }

        .table thead th {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #6c757d;
        }

        .small-muted {
            font-size: 0.8rem;
            color: #6c757d;
        }
    </style>
    <!-- Hero Banner -->
    <section id="home-hero"
        class="search-hero listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
        <div class="container">
            <div class="bannertext text-center">
                <h1 class="fw-bold text-white">Transaction History</h1>
                {{-- <p class="lead text-light mt-2">Fill in the details below to publish your safari</p> --}}
            </div>
        </div>
    </section>
    <div class="container py-4">
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Safari / Package</th>
                        <th>Reference</th>
                        <th>Date</th>
                        <th class="text-center">Coupon</th>
                        <th class="text-center">Base Amount</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">Final Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($paymentsByMonth as $payment)
                        @php
                            $payable = $payment->payable;
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                @if ($payable)
                                    <a href="{{ $this->getDetailUrl($payment) }}" target="_blank">
                                        {{ $payable->title }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>

                            <td>
                                @if ($payment)
                                    <a class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                        href="#paymentDetails{{ $payment->id }}" role="button"
                                        aria-expanded="false" aria-controls="paymentDetails{{ $payment->id }}">
                                        View Payment
                                    </a>

                                    <div class="collapse mt-2" id="paymentDetails{{ $payment->id }}">
                                        <div class="border p-2 rounded bg-light">

                                            <div><strong>Amount:</strong> ₹{{ $payment->final_amount }}
                                            </div>

                                            @if ($payment->utr)
                                                <div class="text-muted">
                                                    <strong>UTR / Transaction ID:</strong>
                                                    {{ $payment->utr }}
                                                </div>
                                            @endif

                                            @if ($payment->screenshot)
                                                <div class="mt-1">
                                                    <a href="{{ $payment->screenshot }}" target="_blank"
                                                        class="text-decoration-underline">
                                                        View Screenshot
                                                    </a>
                                                </div>
                                            @endif

                                            <div class="text-muted small mt-1">
                                                {{ $payment->created_at->format('d M Y, h:i A') }}
                                            </div>

                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-secondary">Unpaid</span>
                                @endif
                            </td>

                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                            <td class="text-center">{{ $payment->coupon_code ?? ' NA' }}</td>
                            <td class="text-end fw-semibold">
                                ₹{{ number_format($payment->amount, 2) }}
                            </td>
                            <td class="text-end fw-semibold">
                                ₹{{ number_format($payment->discounted_amount, 2) }}
                            </td>
                            <td class="text-end fw-semibold">
                                ₹{{ number_format($payment->final_amount, 2) }}
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    Paid
                                </span>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                No payment history found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <x-pagination :paginator="$paymentsByMonth" />
        </div>
    </div>
</div>
