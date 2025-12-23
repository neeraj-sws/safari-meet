<div>
    <div class="login-wrapper" style="background-image:url({{ asset('assets/images/layered-waves-haikei-7.svg') }})">
        <div class="container-lg login-container">
            <div class="row g-0 justify-content-between">
                <!-- Left Column (Login Form) -->
                <div class="col-md-5 login-left">
                    <div class="login-form-box py-md-5">
                        <div class="login-logo mb-4 text-center d-md-block d-none">
                            <a href=" {{ url('/') }} ">
                                <img src="{{ asset('assets/images/safari-footer-logo.png') }}"
                                    style="height: 50px; width: 100%; object-fit: contain;">
                            </a>


                        </div>

                        <h2 class="mb-4">Reset Your Password</h2>

                        <form class="user-store-form row" wire:submit.prevent="save">
                            <div class="mb-3">
                                <label class="form-label text-white">Email <span>*</span></label>
                                <input type="email" class="form-control" wire:model="email" placeholder="Enter Email">
                                @error('email')
                                    <small class="text-white small">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="login-btn loginbtntext rounded-3 text-center mb-4">
                                <button type="submit" class="btn rounded-3 w-100 h-100 text-white fw-semibold"
                                    wire:loading.attr="disabled">

                                    <span wire:loading.remove wire:target="save">Send Reset Link</span>

                                    <span wire:loading wire:target="save">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true"></span>
                                        Sending...
                                    </span>
                                </button>
                            </div>

                            <div class="text-center mt-3 small-text">
                                <a href="{{ route('login') }}" class="text-decoration-none text-white"><i
                                        class="fa-solid fa-arrow-left me-1 text-white"></i>Back to Login</a>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Right Column (Image) -->
                <div class="col-md-6 login-right">
                    <div class="login-logo mb-4 text-center d-md-none d-block">
                        <img src="{{ asset('assets/images/safari-footer-logo.png') }}"
                            style="height: 50px; width: 100%; object-fit: contain;">
                    </div>
                    <img src="{{ asset('front-assets/images/login/loginimage.png') }}" alt="Login illustration" />
                </div>
            </div>
        </div>
    </div>
</div>
