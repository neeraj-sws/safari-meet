<div>
    <div class="login-wrapper" style="background-image:url({{ asset('assets/images/layered-waves-haikei-7.svg') }})">
        <div class="container-lg login-container">
            <div class="row align-items-center">
                <!-- Left Column -->
                <div class="col-md-6 login-left">
                    <div class="login-form-box py-md-5">
                        <div class="login-logo mb-4 text-center d-md-block d-none">
                            <img src="{{ asset('assets/images/safari-footer-logo.png') }}"
                                style="height: 50px; width: 100%; object-fit: contain;">
                        </div>
                        <h2 class="mb-4">Sign Up as a Safari Travel Partner</h2>
                        <form wire:submit.prevent="register" class="user-store-form row">

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Agency Name <span>*</span></label>
                                <input type="text" class="form-control" wire:model="agencyName"
                                    placeholder="Enter Agency Name" />
                                @error('agencyName')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">License Number <span>*</span></label>
                                <input type="text" class="form-control" wire:model="licenseNumber"
                                    placeholder="Enter License Number" />
                                @error('licenseNumber')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Contact Person <span>*</span></label>
                                <input type="text" class="form-control" wire:model="contactPerson"
                                    placeholder="Enter Contact Person" />
                                @error('contactPerson')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Phone Number <span>*</span></label>
                                <input type="tel" class="form-control" wire:model="phoneNumber"
                                    placeholder="Enter Phone Number" />
                                @error('phoneNumber')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Email <span>*</span></label>
                                <input type="email" class="form-control" wire:model="email"
                                    placeholder="Enter Email" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Website <span>*</span></label>
                                <input type="url" class="form-control" wire:model="website"
                                    placeholder="Enter Website" />
                                @error('website')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Location <span>*</span></label>
                                <select class="form-select" wire:model="location">
                                    <option value="">Select Location</option>
                                    <option value="ranthambore">Ranthambore</option>
                                    <option value="jimcorbett">Jim Corbett</option>
                                    <option value="kaziranga">Kaziranga</option>
                                    <option value="bandhavgarh">Bandhavgarh</option>
                                </select>
                                @error('location')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Years of Experience <span>*</span></label>
                                <input type="number" class="form-control" wire:model="yearsOfExperience"
                                    placeholder="Years of Experience" />
                                @error('yearsOfExperience')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Password <span>*</span></label>
                                <input type="password" wire:model.live="password" class="form-control"
                                    placeholder="Enter Password" />
                                @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror

                                @if (!empty($password))
                                    <div class="tooltip-style bg-white px-2 mt-2">
                                        <ul class="list-unstyled m-0 small">
                                            @php $rules = $this->passwordRules; @endphp
                                            <li class="{{ $rules['lower'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['lower'] ? '✔' : '✖' !!} 1 small letter minimum </li>
                                            <li class="{{ $rules['upper'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['upper'] ? '✔' : '✖' !!} 1 capital letter minimum </li>
                                            <li class="{{ $rules['number'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['number'] ? '✔' : '✖' !!} 1 number minimum </li>
                                            <li class="{{ $rules['special'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['special'] ? '✔' : '✖' !!} 1 special character minimum </li>
                                            <li class="{{ $rules['length'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['length'] ? '✔' : '✖' !!} 6 character password </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3 col-lg-6 col-md-12 col-sm-6">
                                <label class="form-label text-white">Confirm Password <span>*</span></label>
                                <input type="password" wire:model.live="password_confirmation" class="form-control"
                                    placeholder="Re-enter Password" />
                                @error('password_confirmation')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror

                                @if (!empty($password_confirmation))
                                    <div class="tooltip-style bg-white px-2 mt-2">
                                        <ul class="list-unstyled m-0 small">
                                            @php $rules = $this->confirPasswordRules; @endphp
                                            <li class="{{ $rules['lower'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['lower'] ? '✔' : '✖' !!} 1 small letter minimum </li>
                                            <li class="{{ $rules['upper'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['upper'] ? '✔' : '✖' !!} 1 capital letter minimum </li>
                                            <li class="{{ $rules['number'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['number'] ? '✔' : '✖' !!} 1 number minimum </li>
                                            <li class="{{ $rules['special'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['special'] ? '✔' : '✖' !!} 1 special character minimum </li>
                                            <li class="{{ $rules['length'] ? 'text-success' : 'text-danger' }}">
                                                {!! $rules['length'] ? '✔' : '✖' !!} 6 character password </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="col-12">
                                <div class="form-check d-flex gap-2 align-items-start mb-3 me-3">
                                    <input class="form-check-input pb-0 mb-0" type="checkbox" wire:model="terms"
                                        id="terms">
                                    <label class="remember-me form-check-label text-white small pb-0 mb-0"
                                        for="terms">
                                        I agree to the <a
                                            href="https://safari-meet.codelive.info/terms-conditions.html"
                                            class="text-white">terms & conditions</a>
                                    </label>
                                </div>
                                @error('terms')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="login-btn loginbtntext rounded-3 text-center mb-2">
                                    <button type="submit"
                                        class="btn rounded-3 w-100 h-100 text-white fw-semibold position-relative"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="register">Register</span>

                                        <!-- Loader Spinner -->
                                         <div wire:loading wire:target="register"
                                            class="custom-spinner spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </button>
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
