<footer class="site-footer pt-md-5 pt-3">
    <div class="container-lg container-padding">
        <div class="row gy-4 justify-content-between mt-5 pt-sm-4 pt-5">
            <div class="col-lg-3 footer-section footer-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('front-assets/images/safari-footer-logo.png') }}" alt="SafariMeet Logo"></a>
            </div>
            <div class="col-md-auto col-sm-6 footer-section">
                <h3 class="position-relative">Quick Links <span class="border-half"></span></h3>
                <ul class="footer-ul">
                    <li><a href="{{ route('aboutUs') }}"
                            class="{{ request()->routeIs('aboutUs') ? 'active' : '' }}">About Us</a></li>
                    <li><a href="{{ route('faqs') }}" class="{{ request()->routeIs('faqs') ? 'active' : '' }}">FAQ</a>
                    </li>
                   <li><a href="{{ route('media') }}" class="{{ request()->routeIs('media') ? 'active' : '' }}">Social Media</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-auto col-sm-6 footer-section">
                <h3 class="position-relative">Policies and Terms <span class="border-half"></span></h3>
                <ul class="footer-ul">
                    <li><a href="{{ route('privacyPolicy') }}"
                            class="{{ request()->routeIs('privacyPolicy') ? 'active' : '' }}">Privacy Policy</a></li>
                    <li><a href="{{ route('termsConditions') }}"
                            class="{{ request()->routeIs('termsConditions') ? 'active' : '' }}">Terms & Conditions</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-auto footer-section">
                <h3 class="position-relative">Contact Us <span class="border-half"></span></h3>
                <ul class="footer-ul">
                    <li><a href="javascript:void(0)">Address: <span
                                class="ps-2">{{ \App\Helpers\SettingHelper::get('address', 'Bangalore, India,560035') }}</span></a>
                    </li>
                    @php
                       $email =  \App\Helpers\SettingHelper::get('site_email', 'hello@safarimeet.com')
                    @endphp
                    <li><a href="mailto:{{$email }}">Email:
                            <span
                                class="ps-2">{{ $email }}</span></a>
                    </li>
                    {{-- <li><a href="{{ route('home') }}"><img src="{{ asset('front-assets/images/instragram.png')}}" class="safarilogo" />safarimeet</a></li> --}}
                </ul>

            </div>
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
                                <i class="fa-brands fa-facebook-f fs-5"></i>
                            </div>
                        </a>
                    @endif
                    @if ($instagram_status == 1)
                        <a href="{{ $instagram_link }}" class="text-decoration-none">
                            <div
                                class="icon border border-blue rounded-circle p-3 d-flex align-items-center justify-content-center">
                                <i class="fa-brands fa-instagram fs-5 "></i>
                            </div>
                        </a>
                    @endif
                    @if ($linkedin_status == 1)
                        <a href="{{ $linkedin_link }}" class="text-decoration-none">
                            <div
                                class="icon border border-blue rounded-circle p-3 d-flex align-items-center justify-content-center">
                                <i class="fa-brands fa-linkedin-in fs-5 "></i>
                            </div>
                        </a>
                    @endif
                    @if ($pinterest_status == 1)
                        <a href="{{ $pinterest_link }}" class="text-decoration-none">
                            <div
                                class="icon border border-blue rounded-circle p-3 d-flex align-items-center justify-content-center">
                                <i class="fa-brands fa-pinterest-p fs-5 "></i>
                            </div>
                        </a>
                    @endif
                    @if ($twitter_status == 1)
                        <a href="{{ $twitter_link }}" class="text-decoration-none">
                            <div
                                class="icon border border-blue rounded-circle p-3 d-flex align-items-center justify-content-center">
                                <i class="fa-brands fa-x-twitter fs-5 "></i>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom mt-4 py-2">
        <p class="mb-0">
            {{ \App\Helpers\SettingHelper::get('footer_text', 'COPYRIGHT © ' . date('Y') . ' | ALL RIGHTS RESERVED') }}
        </p>
    </div>
</footer>
