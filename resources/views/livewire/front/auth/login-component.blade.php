<div>
    <style>
        .text-error {
            color: #f27a3b !important;
        }

        .btn-google {
            color: white !important;
            background-color: #ea4335;
            font-size: 14px;
        }

        .btn-google:hover {
            background-color: #cc392f !important;
            color: white !important;
        }

        .btn-facebook {
            color: white !important;
            background-color: #3b5998;
            font-size: 14px;
        }

        .btn-facebook:hover {
            background-color: #2d4373 !important;
            color: white !important;
        }
    </style>
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
                            @if ($showMessage)
                                <span> Your Registration Successfully Completed. Now login with the details. </span>
                            @endif

                        </div>

                        <h2 class="mb-4">Sign In</h2>

                        <form class="user-store-form row" wire:submit.prevent="login">
                            <div class="mb-3 col-md-12">
                                <label class="form-label text-white">Email <span>*</span></label>
                                <input type="email" class="form-control" wire:model="email" placeholder="Enter Email">
                                @error('email')
                                    <span class="text-white small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12 position-relative">
                                <label class="form-label text-white">Password <span>*</span></label>

                                <div class="input-group">
                                    <input type="{{ $showPassword ? 'text' : 'password' }}" class="form-control"
                                        wire:model="password" placeholder="Enter Password">

                                    <button type="button" class="btn btn-outline-light border-0 bg-white"
                                        wire:click="$toggle('showPassword')" style="border-left: 0;">
                                        @if ($showPassword)
                                        <i class="fas fa-eye-slash text-dark"></i>
                                        @else
                                        <i class="fas fa-eye text-dark"></i>
                                        @endif
                                    </button>
                                </div>

                                @error('password')
                                <span class="text-white small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 mt-4 d-flex justify-content-between align-items-center pt-2 flex-wrap">
                                <div class="form-check d-flex gap-2 align-items-center mb-0 me-3">
                                    <input class="form-check-input pb-0 mb-0" type="checkbox" wire:model="remember"
                                        id="rememberMe">
                                    <label class="remember-me form-check-label text-light small pb-0 mb-0"
                                        for="rememberMe">Remember Me</label>
                                </div>
                                <a href="{{ route('forgotpassword') }}" class="text-white small fw-semibold me-3">Forgot
                                    password?</a>
                            </div>

                            <div class="login-btn loginbtntext rounded-3 text-center mb-4">
                                <button type="submit" class="btn rounded-3 w-100 h-100 text-white fw-semibold"
                                    wire:loading.attr="disabled">

                                    <span wire:loading.remove wire:target="login">Login</span>

                                    <span wire:loading wire:target="login">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </span>
                                </button>
                            </div>

                            <div class="form-links d-flex justify-content-between flex-wrap">
                                <p class="text-white fw-normal small">New User?
                                    <a href="{{ route('register') }}" class="fw-semibold text-white">Sign Up</a>
                                </p>
                                <p class="text-white fw-normal small">New Travel Agency?
                                    <a href="{{ route('agent_registration') }}" class="fw-semibold text-white">Sign
                                        Up</a>
                                </p>
                            </div>
                        </form>
                        <div>
                            <hr class="my-3">
                        </div>
                        <div class="d-grid mb-2">
                            <button class="btn btn-lg btn-google  fw-semibold " wire:click="loginWithGoogle"
                                type="button">
                                <i class="fab fa-google me-2"></i> Sign up with Google
                            </button>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-lg btn-facebook  fw-semibold " wire:click="loginWithFacebook"
                                type="button">
                                <i class="fab fa-facebook-f me-2"></i> Sign up with Facebook
                            </button>
                        </div>

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
