<div>
    <div class="login-wrapper" style="background-image:url({{ asset('assets/images/layered-waves-haikei-7.svg') }})">
        <div class="container-lg login-container">
            <div class="row g-0 justify-content-between">
                <!-- Left Column (Login Form) -->
                <div class="col-md-5 login-left">
                    <div class="login-form-box py-md-5">
                        <div class="login-logo mb-4 text-center d-md-block d-none">
                            <a href=" {{ url('/') }}">
                                <img src="{{ asset('assets/images/safari-footer-logo.png') }}"
                                    style="height: 50px; width: 100%; object-fit: contain;">
                            </a>
                        </div>

                        <h2 class="mb-4">Sign In</h2>

                        <form wire:submit.prevent="resetPassword" class="user-store-form row">

                            {{-- Password --}}
                            <div class="mb-3 col-lg-12 col-md-12 col-sm-6">
                                <label class="form-label text-white">Password <span>*</span></label>
                                <div class="input-group">
                                    <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model.live="password"
                                        class="form-control" placeholder="Enter Password" />
                                    <button type="button" class="btn btn-outline-light border-0 bg-white"
                                        wire:click="$set('showPassword', {{ $showPassword ? 'false' : 'true' }})"
                                        style="border-left: 0;">
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

                                @if (!empty($password) && !$this->isPasswordValid())
                                    <div class="tooltip-style bg-white px-2 mt-2">
                                        <ul class="list-unstyled m-0 small">
                                            @php $rules = $this->passwordRules; @endphp
                                            <li class="{{ $rules['lower'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['lower'] ? '✔' : '✖' !!} 1 small letter minimum
                                            </li>
                                            <li class="{{ $rules['upper'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['upper'] ? '✔' : '✖' !!} 1 capital letter minimum
                                            </li>
                                            <li class="{{ $rules['number'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['number'] ? '✔' : '✖' !!} 1 number minimum
                                            </li>
                                            <li class="{{ $rules['special'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['special'] ? '✔' : '✖' !!} 1 special character minimum
                                            </li>
                                            <li class="{{ $rules['length'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['length'] ? '✔' : '✖' !!} 6 character password
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-3 col-lg-12 col-md-12 col-sm-6">
                                <label class="form-label text-white">Confirm Password <span>*</span></label>
                                <div class="input-group">
                                    <input type="{{ $showConfirmPassword ? 'text' : 'password' }}"
                                        wire:model.live="password_confirmation" class="form-control"
                                        placeholder="Re-enter Password" />
                                    <button type="button" class="btn btn-outline-light border-0 bg-white"
                                        wire:click="$set('showConfirmPassword', {{ $showConfirmPassword ? 'false' : 'true' }})"
                                        style="border-left: 0;">
                                        @if ($showConfirmPassword)
                                            <i class="fas fa-eye-slash text-dark"></i>
                                        @else
                                            <i class="fas fa-eye text-dark"></i>
                                        @endif
                                    </button>
                                </div>

                                @error('password_confirmation')
                                    <span class="text-white small">{{ $message }}</span>
                                @enderror

                                @if (!empty($password_confirmation) && !$this->isConfirmPasswordValid())
                                    <div class="tooltip-style bg-white px-2 mt-2">
                                        <ul class="list-unstyled m-0 small">
                                            @php $rules = $this->confirmPasswordRules; @endphp
                                            <li class="{{ $rules['lower'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['lower'] ? '✔' : '✖' !!} 1 small letter minimum
                                            </li>
                                            <li class="{{ $rules['upper'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['upper'] ? '✔' : '✖' !!} 1 capital letter minimum
                                            </li>
                                            <li class="{{ $rules['number'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['number'] ? '✔' : '✖' !!} 1 number minimum
                                            </li>
                                            <li class="{{ $rules['special'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['special'] ? '✔' : '✖' !!} 1 special character minimum
                                            </li>
                                            <li class="{{ $rules['length'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['length'] ? '✔' : '✖' !!} 6 character password
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            {{-- Submit --}}
                            <div class="login-btn loginbtntext rounded-3 text-center mb-4">
                                <button type="submit" class="btn rounded-3 w-100 h-100 text-white fw-semibold"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="resetPassword">Change Password</span>
                                    <span wire:loading wire:target="resetPassword">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true"></span>
                                        Changing...
                                    </span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

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
