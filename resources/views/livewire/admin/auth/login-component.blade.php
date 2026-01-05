
<div class="container">
    <div class="section-authentication-signin d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="card mt-5 mt-lg-0">
                        <div class="card-body">
                            <div class="">
                                <div class="text-center">
                                    <h3 >Admin</h3>
                                    <a href="{{ url('/') }}">
                                    <img src="{{ asset('front-assets/images/safari-logo.png') }}" class="w-50" alt="SafariMeet Logo">
                                    </a>
                                </div>

                                <div class="form-body mt-3">
                                    <form class="row g-3" wire:submit.prevent="login">
                                        <div class="col-12">
                                            <label for="inputEmailAddress" class="form-label">Email
                                                Address</label>
                                            <input type="email" class="form-control" id="inputEmailAddress"
                                                placeholder="Email Address" wire:model="email">
                                            @error('email')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="inputLastEnterPassword" class="form-label">Enter
                                                Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" class="form-control border-end-0"
                                                    wire:model="password" id="inputLastEnterPassword" value="12345678"
                                                    placeholder="Enter Password">
                                                <span class="input-group-text bg-transparent"
                                                    onclick="togglePassword()">
                                                    <a href="javascript:void(0);">
                                                    <i class="fa-solid fa-eye" id="password-icon"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            @error('password')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                wire:model="remember"
                                                    id="flexSwitchCheckChecked" >
                                                <label class="form-check-label" for="flexSwitchCheckChecked">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            {{-- <a
                                                href="{{ route('authentication-forgot-password') }}">Forgot
                                                Password ?</a> --}}
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary"
                                                    wire:loading.attr="disabled"><i class="bx bxs-lock-open"></i>Sign
                                                    in</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

    <script>
        window.togglePassword = function() {
            const passwordInput = document.getElementById("inputLastEnterPassword");
            const passwordIcon = document.getElementById("password-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            }
        };
    </script>
    @endpush
