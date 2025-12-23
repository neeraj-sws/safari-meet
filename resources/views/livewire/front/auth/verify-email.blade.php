<div>
    <div class="login-wrapper">
        <div class="container-lg login-container">
            <div class="row align-items-center">

                <div class="col-md-6 login-left">
                    <div class="login-form-box py-md-5">
                        <div class="login-logo mb-4 text-center d-md-block d-none">
                            <img src="{{ asset('assets/images/safari-footer-logo.png') }}"
                                style="height: 50px; width: 100%; object-fit: contain;">
                        </div>

                        <h2 class="mb-4">Verify OTP</h2>
                        <form wire:submit.prevent="verifyOtp">
                            <input type="hidden" name="action" value="otp_verification">

                            <div class="mb-3 forminputbox">
                                <label for="otp" class="form-label text-white">Enter OTP</label>
                                <div class="otp-container d-flex justify-content-md-start justify-content-center gap-2">
                                    @foreach (range(0, 5) as $i)
                                        <input type="text" class="otp-input" maxlength="1"
                                            wire:model="otp.{{ $i }}"
                                            oninput="moveToNextInput(this, {{ $i }})"
                                            onkeypress="return event.keyCode !== 69 && event.keyCode !== 188" />
                                    @endforeach
                                </div>
                                @error('otp')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Resend OTP Link -->
                            <div class="text-md-start text-center mb-4">
                                <a href="javascript:void(0)" wire:click="requestNewOtp"
                                    class="text-decoration-underline text-info small">
                                    Didn’t receive the OTP? <span class="fw-semibold">Resend</span>
                                </a>
                            </div>
                            <div class="text-center mb-4">
                                <div
                                    class="login-btn loginbtntext rounded-3 text-end mb-4 register-verify-btn forminputbox">
                                    <button type="submit"
                                        class="btn rounded-3 text-white fw-semibold w-100">Verify</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6 login-right">
                    <div class="login-logo mb-4 text-center d-md-none d-block">
                        <img src="{{ asset('assets/images/safari-footer-logo.png') }}"
                            style="height: 50px; width: 100%; object-fit: contain;">
                    </div>
                    <img src="{{ asset('assets/images/login-forms/registerimg.svg') }}" alt="Login illustration" />
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function moveToNextInput(currentInput, index) {
        currentInput.value = currentInput.value.replace(/[^0-9]/g, '');
        if (currentInput.value.length === 1) {
            const nextInput = document.querySelectorAll('.otp-input')[index + 1];
            if (nextInput) {
                nextInput.focus();
            }
        }

        if (currentInput.value.length === 0 && index > 0) {
            const previousInput = document.querySelectorAll('.otp-input')[index - 1];
            if (previousInput) {
                previousInput.focus();
            }
        }
    }

    document.getElementById('pasteOtpBtn').addEventListener('click', async () => {
        if (!navigator.clipboard || !navigator.clipboard.readText) {
            alert('Clipboard API not supported or unavailable in this context.');
            return;
        }

        try {
            const text = await navigator.clipboard.readText();
            const otpDigits = text.trim().replace(/\D/g, '').split('');
            const inputs = document.querySelectorAll('.otp-input');

            inputs.forEach(input => input.value = '');

            otpDigits.forEach((digit, i) => {
                if (i < inputs.length) {
                    inputs[i].value = digit;
                }
            });

            if (otpDigits.length > 0 && otpDigits.length <= inputs.length) {
                inputs[Math.min(otpDigits.length, inputs.length) - 1].focus();
            } else {
                inputs[inputs.length - 1].focus();
            }
        } catch (err) {
            alert('Failed to read clipboard contents: ' + err);
        }
    });
</script>
