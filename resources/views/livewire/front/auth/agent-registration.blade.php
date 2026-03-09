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
    <div class="login-wrapper">
        <div class="container-lg login-container">
            <div class="row align-items-center">
                <!-- Left Column -->
                <div class="col-md-6 login-left">
                    <div class="login-form-box py-md-5">
                        <div class="login-logo mb-4 text-center d-md-block d-none">
                            <a href=" {{ url('/') }} ">
                                <img src="{{ asset('assets/images/safari-footer-logo.png') }}"
                                    style="height: 50px; width: 100%; object-fit: contain;">
                            </a>
                        </div>
                        <h2 class="mb-4">Sign Up as a Safari Travel Partner</h2>
                        <form wire:submit.prevent="register" class="user-store-form row">
                            <div class="mb-3 col-lg-12 col-md-12 col-sm-6">
                                <label class="form-label text-white">Agency Name <span>*</span></label>
                                <input type="text" class="form-control text-capitalize" wire:model="agency_name"
                                    oninput="filterAndFormatInputs(this,{allowAlpha:true})" />
                                @error('agency_name')
                                    <span class="text-error small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Contact Person <span>*</span></label>
                                <input type="text" class="form-control text-capitalize" wire:model="contact_person"
                                    oninput="filterAndFormatInputs(this,{allowAlpha:true})" />
                                @error('contact_person')
                                    <span class="text-error small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Phone Number <span>*</span></label>
                                <input type="number" class="form-control" wire:model="phone"
                                    oninput="filterPhoneNumber(this)" />
                                @error('phone')
                                    <span class="text-error small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Email <span>*</span></label>
                                <input type="email" class="form-control" wire:model="email" />
                                @error('email')
                                    <span class="text-error small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Website</label>
                                <input type="url" class="form-control" wire:model="website" />
                                @error('website')
                                    <span class="text-error small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Years of Experience <span>*</span></label>
                                <input type="number" class="form-control" wire:model="experience"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2)" />
                                @error('experience')
                                    <span class="text-error small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Country <span>*</span></label>
                                <select class="form-select select2" wire:model="country" id="country">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $key => $item)
                                        <option @selected($key == $country) value="{{ $key }}">
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <span class="text-error small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">State <span>*</span></label>
                                <select class="form-select select2" wire:model="state" id="state">
                                    <option value="">Select State</option>
                                    @foreach ($states as $key => $item)
                                        <option @selected($key == $state) value="{{ $key }}">
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <span class="text-error small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">City <span>*</span></label>
                                <select class="form-select select2" wire:model="city" id="city">
                                    <option value="">Select City</option>
                                    @foreach ($cities as $key => $item)
                                        <option @selected($key == $city) value="{{ $key }}">
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <span class="text-error small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
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
                                    <span class="text-error small">{{ $message }}</span>
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

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
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
                                    <span class="text-error small">{{ $message }}</span>
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

                            <div class="col-12">
                                <div class="form-check d-flex gap-2 align-items-start mb-3 me-3">
                                    <input class="form-check-input pb-0 mb-0" type="checkbox" wire:model="terms"
                                        id="terms">
                                    <label class="form-check-label text-white small" for="terms">
                                        I agree to the <a href="{{ route('termsConditions') }}"
                                            class="text-white">terms & conditions</a>
                                    </label>
                                    @error('terms')
                                        <span class="text-error small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="login-btn loginbtntext rounded-3 text-center mb-2">
                                    <button
                                        class="btn rounded-3 text-white fw-semibold w-100 d-flex align-items-center justify-content-center"
                                        wire:loading.attr="disabled" wire:target="register">
                                        <span wire:loading.remove wire:target="register">
                                            Register
                                        </span>
                                        <div wire:loading wire:target="register"
                                            class="spinner-border spinner-border-sm text-light ms-2" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-links d-flex justify-content-center flex-wrap">
                                    <p class="text-white fw-normal small">Already registered?
                                        <a href="{{ route('login') }}" class="fw-semibold small text-white ">Login
                                            here</a>
                                    </p>

                                </div>
                            </div>
<<<<<<< HEAD
							{{-- <div>
=======
                            <div>
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
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
<<<<<<< HEAD
                            </div> --}}
=======
                            </div>
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
                        </form>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6 login-right">
                    <div class="login-logo mb-4 text-center d-md-none d-block">
                        <img src="images/safari-footer-logo.png"
                            style="height: 50px; width: 100%; object-fit: contain;">
                    </div>
                    <img src="{{ asset('front-assets/images/login/loginimage.png') }}" alt="Login illustration" />
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function validateName(input) {
        const regex = /^[A-Za-z]+(?: [A-Za-z]+)*$/;

        if (!regex.test(input.value)) {

            input.value = input.value
                .replace(/[^a-zA-Z\s]/g, '')

        }

        input.value = input.value.replace(/\b\w/g, function(c) {
            return c.toUpperCase();
        });
    }
</script>

<script>
    function filterPhoneNumber(input) {
        let value = input.value.replace(/[^0-9]/g, ''); // Remove non-digits

        // Prevent starting with 0
        if (value.startsWith('0')) {
            value = value.slice(1);
        }

        // Allow max 5 same digits in a row
        let newValue = '';
        let count = 1;

        for (let i = 0; i < value.length; i++) {
            if (i > 0 && value[i] === value[i - 1]) {
                count++;
                if (count > 5) {
                    continue; // Block the digit beyond 5 repeats
                }
            } else {
                count = 1;
            }
            newValue += value[i];
        }

        // Limit to 10 digits total
        input.value = newValue.slice(0, 10);
    }
</script>
