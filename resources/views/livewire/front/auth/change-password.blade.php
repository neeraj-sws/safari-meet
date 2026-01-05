<div>
    <section id="home-hero"
        class="search-hero listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
        <div class="container">
            <div class="bannertext text-center">
                <h1 class="fw-bold text-white">Change Your Password</h1>
                <p class="lead text-light mt-2">Enter your old password, new password, and confirm the new password
                    below.</p>
            </div>
        </div>
    </section>
    <section class="step-form my-5">
        <div class="container-lg">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-7">
                            <form wire:submit.prevent="save" class="user-store-form row">
                                <!-- Old Password Field -->
                                <div class="mb-3 col-lg-12 col-md-12 col-sm-6">
                                    <label class="form-label text-blue">Old Password <span>*</span></label>
                                    <input type="password" wire:model.live="old_password" class="form-control"
                                        placeholder="Enter Old Password" />
                                    @error('old_password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- New Password Field -->
                                <div class="mb-3 col-lg-12 col-md-12 col-sm-6">
                                    <label class="form-label text-blue">New Password <span>*</span></label>
                                    <input type="password" wire:model.live="password" class="form-control"
                                        placeholder="Enter New Password" />
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                    @if (!empty($password) && !$this->isPasswordValid())
                                        <div class="tooltip-style bg-blue px-2 mt-2">
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

                                <!-- Confirm Password Field -->
                                <div class="mb-3 col-lg-12 col-md-12 col-sm-6">
                                    <label class="form-label text-blue">Confirm New Password <span>*</span></label>
                                    <input type="password" wire:model.live="password_confirmation" class="form-control"
                                        placeholder="Re-enter New Password" />
                                    @error('password_confirmation')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror

                                    @if (!empty($password_confirmation) && !$this->isConfirmPasswordValid())
                                        <div class="tooltip-style bg-blue px-2 mt-2">
                                            <ul class="list-unstyled m-0 small">
                                                @php $rules = $this->confirmPasswordRules; @endphp
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

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <div class="login-btn loginbtntext rounded-3 text-center mb-2">
                                        <button class="btn rounded-3 btn-primary blue-btn-hover text-white fw-semibold w-100" type="submit"
                                            wire:loading.attr="disabled">
                                            <span wire:loading.remove wire:target="save">Save</span>
                                            <span wire:loading wire:target="save">Saving...</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-5 text-center">
                            <img src="{{ asset('front-assets/images/animal-images/tiger.png') }}" alt="Animal Image"
                                class="img-fluid rounded-4 shadow-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
