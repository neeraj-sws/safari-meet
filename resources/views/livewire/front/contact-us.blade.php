<div>
    <section id="home-hero"
     style="background-image: url('{{ asset('front-assets/images/banner-image/home-hero-banner.png') }}');"
        class="listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
        <div class="container-fluid container-padding">
            <div class="bannertext text-center">
                <h1 class="text-white">Contact Us</h1>
            </div>
        </div>
    </section>

    <section class="booking-section" id="data">
        <div class="container-lg container-inner-padding">

            <div class="row gy-4 my-sm-3 align-items-center">
                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div>
                        <form wire:submit.prevent="submit" class="all-form grey-bg p-3 rounded-3">
                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Your Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" wire:model="name"
                                        class="form-control text-capitalize @error('name') is-invalid @enderror"
                                        oninput="filterAndFormatInputs(this,{allowAlpha:true})" placeholder="Name ">
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address <span
                                            class="text-danger">*</span></label>
                                    <input type="email" wire:model="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email Address ">
                                    @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" wire:model="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        oninput="filterPhoneNumber(this)" placeholder="Phone Number (10 degits) ">
                                    @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="people-traveling" class="form-label">Number of People Traveling
                                        <span class="text-danger">*</span></label>
                                    <input type="number" wire:model="people_traveling"
                                        class="form-control @error('people_traveling') is-invalid @enderror"
                                        placeholder="Number of People ">
                                    @error('people_traveling')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="travel-date" class="form-label">Date of Travel <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control datepicker  @error('travel_date') is-invalid @enderror"
                                        wire:model="travel_date">
                                    @error('travel_date')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="park" class="form-label ">Park you are interested in? <span
                                            class="text-danger">*</span></label>
                                    <select wire:model="park" id="park"
                                        class="form-select select2 @error('park') is-invalid @enderror">
                                        <option value="">Select Park</option>
                                        @foreach ($parks as $park)
                                        <option value="{{ $park->id }}">{{ $park->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('park')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="safari-type" class="form-label">Safari Type <span
                                            class="text-danger">*</span></label>
                                    <select wire:model="safari_type"
                                        class="form-select @error('safari_type') is-invalid @enderror">
                                        <option value="">Select Safari Type</option>
                                        @foreach ($safariTypes as $id => $type)
                                        <option value="{{ $type->id }}">{{ $type?->safari_type?->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('safari_type')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <textarea wire:model.defer="message"
                                        class="form-control @error('message') is-invalid @enderror" rows="4"
                                        placeholder="Any custom message about your requirements. "></textarea>
                                    @error('message')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 mb-1 text-center">
                                    <button class="btn btn-sm btn-primary blue-btn-hover blue-btn-hover px-4 rounded-pill"
                                        type="submit" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="submit">Submit Inquiry</span>
                                        <span wire:loading wire:target="submit">
                                            <span class="spinner-border spinner-border-sm"></span> Submiting Inquiry...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if (session()->has('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                        @endif
                    </div>

                </div>
                <!-- Contact Info -->
                <div class="col-lg-5">
                    <div class="row g-4">

                        <!-- Our Office -->
                        <div class="col-md-6">
                            <div class="border-0 contact-info-card">
                                <div
                                    class="text-center d-flex gap-2 flex-column justify-content-center align-items-center ">
                                    <div
                                        class="mb-3 fs-2 text-white rounded-circle border-muted border icon-circle d-flex align-items-center justify-content-center bg-accent">
                                        <i class="fa-solid fa-location-dot fs-5"></i>
                                    </div>
                                    <div class="text-center">
                                        <h5 class="text-dark">Our Office</h5>
                                        <p class="text-dark">
                                            {{ \App\Helpers\SettingHelper::get('address', 'Bangalore, India,560035') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="border-0 contact-info-card">
                                <div
                                    class="text-center d-flex gap-2 flex-column justify-content-center align-items-center ">
                                    <div
                                        class="mb-3 fs-2 text-white rounded-circle border-muted border icon-circle d-flex align-items-center justify-content-center bg-accent">
                                        <i class="fa-solid fa-envelope fs-5"></i>
                                    </div>
                                    <div class="text-center">
                                        <h5 class="text-dark">Email</h5>
                                        <p class="text-dark">
                                            <a href="javascript:void(0)" class="text-decoration-none text-dark">{{
                                                \App\Helpers\SettingHelper::get('site_email',
                                                'contactsafarimeet@gmail.com') }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <div class="border-0 contact-info-card">
                                <div
                                    class="text-center d-flex gap-2 flex-column justify-content-center align-items-center ">
                                    <div
                                        class="mb-3 fs-2 text-white rounded-circle border-muted border icon-circle d-flex align-items-center justify-content-center bg-accent">
                                        <i class="fa-solid fa-phone fs-5"></i>
                                    </div>
                                    <div class="text-center">
                                        <h5 class="text-dark">Phone</h5>
                                        <p class="">
                                            @php
                                            $number = \App\Helpers\SettingHelper::get('phone_number', '9028738734');
                                            @endphp
                                            <a href="tel:+91{{ $number }}" class="text-decoration-none text-dark">+91-{{
                                                $number }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="col-md-6">
                            <div class="border-0 contact-info-card">
                                <div
                                    class="text-center d-flex gap-2 flex-column justify-content-center align-items-center ">
                                    <div
                                        class="mb-3 fs-2 text-white rounded-circle border-muted border icon-circle d-flex align-items-center justify-content-center bg-accent">
                                        <i class="fa-solid fa-clock fs-5"></i>
                                    </div>
                                    <div class="text-center">
                                        <h5 class="text-dark">Working Hours</h5>
                                        <p class="mb-1 text-dark">Mon – Sat: 9:00 AM – 6:00 PM</p>
                                        <p class="text-danger">Sunday: Closed</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div class="col-12">
                            <div class="social-icons d-flex align-items-center gap-3 flex-wrap justify-content-center">
                                @php
                                $facebook_link = \App\Helpers\SettingHelper::get('facebook_link', '#');
                                $facebook_status = \App\Helpers\SettingHelper::get('facebook_status', '0');

                                $twitter_link = \App\Helpers\SettingHelper::get('twitter_link', '#');
                                $twitter_status = \App\Helpers\SettingHelper::get('twitter_status', '0');

                                $instagram_link = \App\Helpers\SettingHelper::get('instagram_link', '#');
                                $instagram_status = \App\Helpers\SettingHelper::get('instagram_status', '0');

                                $linkedin_link = \App\Helpers\SettingHelper::get('linkedin_link', '#');
                                $linkedin_status = \App\Helpers\SettingHelper::get('linkedin_status', '0');

                                $pinterest_link = \App\Helpers\SettingHelper::get('pinterest_link', '#');
                                $pinterest_status = \App\Helpers\SettingHelper::get('pinterest_status', '0');
                                @endphp
                                @if ($facebook_status == 1)
                                <a href="{{ $facebook_link }}" class="text-decoration-none">
                                    <div
                                        class="icon border border-blue rounded-circle p-3 d-flex align-items-center justify-content-center">
                                        <i class="fa-brands fa-facebook-f fs-5 text-blue"></i>
                                    </div>
                                </a>
                                @endif
                                @if ($instagram_status == 1)
                                <a href="{{ $instagram_link }}" class="text-decoration-none">
                                    <div
                                        class="icon border border-blue rounded-circle p-3 d-flex align-items-center justify-content-center">
                                        <i class="fa-brands fa-instagram fs-5 text-blue"></i>
                                    </div>
                                </a>
                                @endif
                                @if ($linkedin_status == 1)
                                <a href="{{ $linkedin_link }}" class="text-decoration-none">
                                    <div
                                        class="icon border border-blue rounded-circle p-3 d-flex align-items-center justify-content-center">
                                        <i class="fa-brands fa-linkedin-in fs-5 text-blue"></i>
                                    </div>
                                </a>
                                @endif
                                @if ($pinterest_status == 1)
                                <a href="{{ $pinterest_link }}" class="text-decoration-none">
                                    <div
                                        class="icon border border-blue rounded-circle p-3 d-flex align-items-center justify-content-center">
                                        <i class="fa-brands fa-pinterest-p fs-5 text-blue"></i>
                                    </div>
                                </a>
                                @endif
                                @if ($twitter_status == 1)
                                <a href="{{ $twitter_link }}" class="text-decoration-none">
                                    <div
                                        class="icon border border-blue rounded-circle p-3 d-flex align-items-center justify-content-center">
                                        <i class="fa-brands fa-x-twitter fs-5 text-blue"></i>
                                    </div>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    function filterPhoneNumber(input) {
        let value = input.value.replace(/[^0-9]/g, '');

        if (value.startsWith('0')) {
            value = value.slice(1);
        }

        let newValue = '';
        let count = 1;

        for (let i = 0; i < value.length; i++) {
            if (i > 0 && value[i] === value[i - 1]) {
                count++;
                if (count > 5) {
                    continue;
                }
            } else {
                count = 1;
            }
            newValue += value[i];
        }
        input.value = newValue.slice(0, 10);
    }
</script>
