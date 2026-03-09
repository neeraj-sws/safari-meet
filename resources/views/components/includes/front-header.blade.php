<header>
    @php
        use Illuminate\Support\Facades\Auth;
    @endphp

    <style>
        .notifications-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .notifications-wrapper::-webkit-scrollbar-thumb {
            background: #bbb;
            border-radius: 4px;
        }

        .dropdown-menu a:hover {
            background: #bbbbbb !important;
            color: #F59856 !important;
        }

        /* Mobile Fix: Center Items */
        @media (max-width: 991px) {
            .navbar-nav {
                text-align: center;
                width: 100%;
            }

            .navbar-nav .nav-item {
                width: 100%;
                margin: 5px 0;
            }

            .notification-dropdown {
                margin-left: 0 !important;
                text-align: center !important;
            }
        }
    </style>

    <nav class="navbar navbar-expand-lg bg-white py-2 shadow-sm">
        <div class="container-fluid container-padding">

            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('front-assets/images/safari-logo.png') }}" alt="SafariMeet Logo" height="40">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#safariNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation -->
            <div class="collapse navbar-collapse" id="safariNavbar">
                <ul class="navbar-nav ms-auto align-items-center">

                    @auth
                        <!-- Create Shared Safari -->
                        <li class="nav-item me-2">
                            @if ((Auth::user()->user_type == 1 && Auth::user()->status == 1) || Auth::user()->user_type == 0)
                                <a href="{{ route('createsaharedshafari') }}"
                                    class="btn btn-sm btn-primary blue-btn-hover blue-btn-hover px-3 w-100 rounded-pill">
                                    Create Shared Safari
                                </a>
                            @endif
                        </li>
                    @endauth

                    <!-- Nav Links -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('shared-safari.list') ? 'active fw-bold text-primary' : '' }}"
                            href="{{ route('shared-safari.list') }}" data-skeleton="safari">Join Shared Safari</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('safari-package.list') ? 'active fw-bold text-primary' : '' }}"
                            href="{{ route('safari-package.list') }}" data-skeleton="package">Safari Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('park.list') ? 'active fw-bold text-primary' : '' }}"
                            href="{{ route('park.list') }}" data-skeleton="park">Park Guides</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('species.list') ? 'active fw-bold text-primary' : '' }}"
                            href="{{ route('species.list') }}" data-skeleton="species">Species</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ContactUs') ? 'active fw-bold text-primary' : '' }}"
                            href="{{ route('ContactUs') }}">Contact</a>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a class="nav-link align-items-center count-days" href="{{ route('login') }}">
                                Login
                                <i class="fa-solid fa-right-to-bracket"></i>
                            </a>
                        </li>
                    @endguest

                    @auth
                        <li class="nav-item dropdown ms-2">

                            <a class="nav-link dropdown-toggle align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown">
                                @php
                                    $user = Auth::user();
                                    $userImage =
                                        $user && $user->profile_photo_path
                                            ? asset($user->profile_photo_path)
                                            : asset('front-assets/images/user.png');
                                @endphp

                                <img src="{{ $userImage }}" alt="User" class="rounded-circle me-2" width="32"
                                    height="32" style="object-fit: cover;">

                                <span class="fw-semibold">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="d-flex justify-content-center">
                                <ul class="dropdown-menu dropdown-menu-end text-center">
                                    @if (Auth::user()->user_type == 1 && Auth::user()->status == 1)
                                        <li><a class="dropdown-item" href="{{ route('agent.dashboard') }}">Dashboard</a>
                                        </li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">My Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user-wishlist') }}">Wishlist</a></li>
                                    <li><a class="dropdown-item" href="{{ route('transaction-history') }}">Transaction
                                            History</a></li>
                                    <li><a class="dropdown-item" href="{{ route('changepassword') }}">Change Password</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        <div wire:ignore>
                            <livewire:front.common.front-notification-master :key="'front-notification'" />
                        </div>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page skeleton overlay (hidden by default). When header links are clicked we show the matching skeleton. -->
    {{-- <div id="page-skeleton-overlay" class="d-none" style="position:fixed;top:0;left:0;right:0;bottom:0;background:#fff;z-index:9998;overflow:auto;margin-top:0;">
        <div style="max-width:1200px;margin:32px auto;padding:16px;">
            <div class="overlay-skeleton" data-type="safari" style="display:none;">
                @include('components.skeletons.listing-skeleton', ['count' => 6, 'type' => 'safari'])
            </div>
            <div class="overlay-skeleton" data-type="package" style="display:none;">
                @include('components.skeletons.listing-skeleton', ['count' => 6, 'type' => 'package'])
            </div>
            <div class="overlay-skeleton" data-type="park" style="display:none;">
                @include('components.skeletons.listing-skeleton', ['count' => 6, 'type' => 'park'])
            </div>
            <div class="overlay-skeleton" data-type="species" style="display:none;">
                @include('components.skeletons.listing-skeleton', ['count' => 8, 'type' => 'species'])
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const overlay = document.getElementById('page-skeleton-overlay');
            const navBar = document.querySelector('nav'); // Get header element

            document.querySelectorAll('a[data-skeleton]').forEach(function (el) {
                el.addEventListener('click', function (e) {
                    if (e.metaKey || e.ctrlKey || e.shiftKey || el.target === '_blank') return;
                    try {
                        const type = el.getAttribute('data-skeleton');
                        overlay.classList.remove('d-none');
                        overlay.style.display = 'block';

                        // Position overlay below the header
                        if (navBar) {
                            const headerHeight = navBar.offsetHeight;
                            overlay.style.top = headerHeight + 'px';
                        }

                        overlay.querySelectorAll('.overlay-skeleton').forEach(function (s) { s.style.display = 'none'; });
                        const selected = overlay.querySelector('.overlay-skeleton[data-type="' + type + '"]');
                        if (selected) selected.style.display = 'block';
                    } catch (err) {
                    }
                });
            });
            window.addEventListener('pagehide', function () { if (overlay) overlay.style.display = 'none'; });
        });
    </script> --}}
</header>
