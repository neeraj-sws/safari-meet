<div>
    <style>
        h6 {
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .form-control {
            padding-left: 0.5rem;
            font-weight: 600;
        }

        .card-img-custom {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 0.75rem;
        }

        .price-highlight {
            color: #F2994A;
            font-weight: 600;
        }

        .checkout-summary {
            background: #F2F2F2;
            border-radius: 0.75rem;
            padding: 1.5rem;
        }

        .qr-code-img {
            max-width: 300px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            padding: 0.5rem;
            background: white;
        }
    </style>

    <div class="container mt-5">
        <div class="row g-5">

            <!-- Safari Summary -->
            <div class="col-lg-5 order-lg-2">
                <div class="checkout-summary">
                    @if ($safariData->display_image)
                        <img src="{{ asset($safariData->display_image) }}" class="card-img-custom mb-3"
                            alt="{{ $safariData->title }}">
                    @endif

                    <h6>{{ $safariData->title }}</h6>

                    @if ($safariData->park)
                        <p>
                            Park: {{ $safariData->park->name }},
                            {{ $safariData->park->state->name }},
                            {{ $safariData->park->country->name }}
                        </p>
                    @endif

                    <p>Start Date: {{ $safariData->day ?? 'N/A' }}</p>
                    <p>End Date: {{ $safariData->night ?? 'N/A' }}</p>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Base Amount</span>
                        <strong>₹{{ $baseAmount }}</strong>
                    </div>

                    @if ($discount > 0)
                        <div class="d-flex justify-content-between text-success">
                            <span>Discount</span>
                            <strong>- ₹{{ $discount }}</strong>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-2">
                        <strong>Amount to Pay</strong>
                        <strong class="price-highlight">₹{{ $finalAmount }}</strong>
                    </div>
                </div>
            </div>

            <!--  Payment Section -->
            <div class="col-lg-7 order-lg-1">
                <h6>Complete Your {{ $finalAmount > 0 ? 'Payment' : 'Booking' }}</h6>

                @if($finalAmount > 0)
                    <p>
                        Scan the QR code below to pay
                        <span class="price-highlight">₹{{ $finalAmount }}</span>
                    </p>

                    <!-- QR CODE -->
                    <div class="text-center mb-4">
                        <img src="{{ $qrCode }}" alt="QR Code" class="qr-code-img">
                    </div>
                @else
                    <p class="alert alert-success">
                        Great news! No payment is required for this booking. Click below to confirm your booking.
                    </p>
                @endif

                <!-- Coupon Section -->
                @if($finalAmount > 0)
                    <button type="button" class="btn btn-link p-0 mb-2" wire:click="$toggle('showCoupon')">
                        Have a coupon?
                    </button>

                    @if ($showCoupon)
                        <div class="card p-3 mb-3">
                            <input type="text" class="form-control" placeholder="Enter coupon code"
                                wire:model.defer="couponCode">

                            @error('couponCode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <button type="button" class="btn btn-sm btn-success mt-2" wire:traget='applyCoupon'
                                wire:loading.attr="disabled" wire:click="applyCoupon">
                                <span wire:traget='applyCoupon' wire:loading.remove>
                                Apply Coupon
                                </span>
                                <span wire:loading wire:traget='applyCoupon'>
                                    <span class="spinner-border spinner-border-sm"></span>
                                    Appling...
                                </span>
                            </button>
                        </div>
                    @endif
                @endif

                <!--  Payment Proof Form -->
                <form wire:submit.prevent="submitPaymentProof">

                    @if($finalAmount > 0)
                        <div class="mb-3">
                            <label class="form-label">Upload Screenshot (OR)</label>
                            <input type="file" class="form-control" wire:model="screenshot">
                            @error('screenshot')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">UTR / Transaction ID (OR)</label>
                            <input type="text" class="form-control" wire:model="utr" placeholder="Enter UTR / Transaction ID  number">
                            @error('utr')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary w-100 rounded-pill" wire:loading.attr="disabled"
                        wire:target="submitPaymentProof">

                        <span wire:loading.remove  wire:traget='submitPaymentProof'>
                            {{ $this->submitButtonText }}
                        </span>

                        <span wire:loading  wire:traget='submitPaymentProof'>
                            <span class="spinner-border spinner-border-sm"></span>
                            {{ $finalAmount > 0 ? 'Submitting...' : 'Confirming...' }}
                        </span>
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
