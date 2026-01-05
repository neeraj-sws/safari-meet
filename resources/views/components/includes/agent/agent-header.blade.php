<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="col">
                <a href="{{ route('home') }}" class="btn btn-outline-warning px-5">Home</a>
            </div>

            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal"
                        data-bs-target="#SearchModal">
                        <a class="nav-link" href="avascript:;"><i class="bx bx-search"></i>
                        </a>
                    </li>

                    <livewire:admin.common.notification-master :type="'agent'" :key="'all-notification'" />

                </ul>
            </div>

            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- <img src="{{ \App\Helpers\UserHelper::photo() }}" class="user-img" alt="user avatar"> --}}
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ \App\Helpers\UserHelper::name('web') ?? 'Agent' }}</p>
                        <p class="designattion mb-0">Agent</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('agent.dashboard') }}"><i
                                class="bx bx-home-circle"></i><span>Dashboard</span></a>
                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}" wire:navigate><i
                                class="bx bx-log-out-circle"></i><span>Logout</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
