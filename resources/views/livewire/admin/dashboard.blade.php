<<<<<<< HEAD
<div>
    <div class="container-fluid">

        <style>
            .card {
                transition: all 0.3s ease;
                border-radius: 12px;
                overflow: hidden;
            }

            .card:hover {
                transform: translateY(-8px);
                box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15) !important;
            }

            .list-group-item {
                transition: all 0.2s ease;
                border-radius: 8px;
                margin-bottom: 8px;
            }

            .list-group-item:hover {
                background-color: #f8f9fa;
                transform: translateX(5px);
            }

            .stat-card {
                position: relative;
                overflow: hidden;
            }

            /* .stat-card::before {
                content: '';
                position: absolute;
                top: -50%;
                right: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
                transform: rotate(45deg);
                transition: all 0.5s;
            } */

            /* .stat-card:hover::before {
                top: 100%;
                right: 100%;
            } */

            .icon-wrapper {
                width: 70px;
                height: 70px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 16px;
                backdrop-filter: blur(10px);
            }

            .safari-item {
                border-left: 3px solid transparent;
                transition: all 0.3s ease;
            }

            .safari-item:hover {
                border-left-color: #dc3545;
                background: linear-gradient(90deg, rgba(220, 53, 69, 0.05) 0%, transparent 100%);
            }

            .package-item {
                border-left: 3px solid transparent;
                transition: all 0.3s ease;
            }

            .package-item:hover {
                border-left-color: #198754;
                background: linear-gradient(90deg, rgba(25, 135, 84, 0.05) 0%, transparent 100%);
            }

            .pulse-badge {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.6;
                }
            }

            .gradient-text {
                background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .payment-item {
                border-left: 3px solid transparent;
                transition: all 0.3s ease;
            }

            .payment-item:hover {
                border-left-color: #0d6efd;
                background: linear-gradient(90deg, rgba(13, 110, 253, 0.05) 0%, transparent 100%);
            }

            .revenue-card {
                position: relative;
                overflow: hidden;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.95) 100%);
            }

            .revenue-card::after {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 100px;
                height: 100px;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
                border-radius: 50%;
                transform: translate(30%, -30%);
            }
        </style>

        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0"
                    style="background: linear-gradient(135deg, #8b9dc3 0%, #9fadc4 100%);">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center justify-content-between text-white">
                            <div>
                                <h3 class="mb-2 fw-bold">👋 Welcome Back, Admin!</h3>
                                <p class="mb-0 opacity-75">Here's your safari business overview for {{ date('F j, Y') }}
                                </p>
                            </div>
                            <div class="d-none d-md-block">
                                <div class="d-flex gap-3">
                                    <div class="text-center">
                                        <div class="fs-2 fw-bold">{{ $safarisCount }}</div>
                                        <small class="opacity-75">Total Safaris</small>
                                    </div>
                                    <div class="text-center border-start ps-3">
                                        <div class="fs-2 fw-bold">{{ $activeSafaris }}</div>
                                        <small class="opacity-75">Active Now</small>
                                    </div>
                                    <div class="text-center border-start ps-3">
                                        <div class="fs-2 fw-bold">₹{{ number_format($totalRevenue) }}</div>
                                        <small class="opacity-75">Total Revenue</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue & Financial Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 revenue-card"
                    style="background: linear-gradient(135deg, #dfc4f5 0%, #e5a9b8 100%);">
                    <div class="card-body text-white position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="flex-grow-1">
                                <p class="mb-2 small fw-semibold text-uppercase opacity-75">Total Revenue</p>
                                <h2 class="mb-1 fw-bold">₹{{ number_format($totalRevenue) }}</h2>
                                <small class="opacity-75">
                                    <i class="fas fa-chart-line"></i> {{ $totalPayments }} Payments
                                </small>
                            </div>
                            <div class="icon-wrapper bg-white bg-opacity-20">
                                <i class="fas fa-rupee-sign fa-2x text-dark"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 revenue-card"
                    style="background: linear-gradient(135deg, #9fd8f5 0%, #a8e5f5 100%);">
                    <div class="card-body text-white position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="flex-grow-1">
                                <p class="mb-2 small fw-semibold text-uppercase opacity-75">Today's Revenue</p>
                                <h2 class="mb-1 fw-bold">₹{{ number_format($todayRevenue) }}</h2>
                                <small class="opacity-75">
                                    <i class="far fa-calendar-check"></i> {{ now()->format('M d, Y') }}
                                </small>
                            </div>
                            <div class="icon-wrapper bg-white bg-opacity-20">
                                <i class="fas fa-coins fa-2x text-dark"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 revenue-card"
                    style="background: linear-gradient(135deg, #a8dbb8 0%, #b3e9d5 100%);">
                    <div class="card-body text-white position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="flex-grow-1">
                                <p class="mb-2 small fw-semibold text-uppercase opacity-75">This Month</p>
                                <h2 class="mb-1 fw-bold">₹{{ number_format($monthRevenue) }}</h2>
                                <small class="opacity-75">
                                    <i class="far fa-calendar-alt"></i> {{ now()->format('F Y') }}
                                </small>
                            </div>
                            <div class="icon-wrapper bg-white bg-opacity-20">
                               <i class="fas fa-wallet fs-1 text-dark"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 revenue-card"
                    style="background: linear-gradient(135deg, #f5b0a9 0%, #fdd9a8 100%);">
                    <div class="card-body text-white position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="flex-grow-1">
                                <p class="mb-2 small fw-semibold text-uppercase opacity-75">Total Users</p>
                                <h2 class="mb-1 fw-bold">{{ number_format($totalUsers) }}</h2>
                                <small class="opacity-75">
                                    <i class="fas fa-user-plus"></i> {{ $newUsersThisMonth }} new this month
                                </small>
                            </div>
                            <div class="icon-wrapper bg-white bg-opacity-20">
                               <i class="fas fa-users fs-1 text-dark"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Row -->
        <div class="row g-3 mb-4">
            <!-- Total Parks -->
            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-2 small fw-semibold text-uppercase">National Parks</p>
                                <h2 class="mb-1 fw-bold" style="color: #ffa726;">{{ $parksCount }}</h2>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge" style="background-color: #e8f5e9; color: #66bb6a;">
                                        <i class="fas fa-check-circle"></i> {{ $activeParks }} Active
                                    </span>
                                    @if ($inactiveParks > 0)
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            {{ $inactiveParks }} Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="icon-wrapper" style="background-color: #fff3e0;">
                                <i class="fas fa-map-marker-alt fs-1" style="color: #ffa726;"></i>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar" style="background-color: #ffa726;" role="progressbar"
                                style="width: {{ $parksCount > 0 ? ($activeParks / $parksCount) * 100 : 0 }}%"></div>
                        </div>
                        <a href="{{ route('admin.package.package') }}" class="btn btn-sm w-100 text-white"
                            style="background-color: #ffa726;">
                            <i class="fas fa-eye"></i> View All Parks
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Species -->
            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-2 small fw-semibold text-uppercase">Wildlife Species</p>
                                <h2 class="mb-1 fw-bold" style="color: #42a5f5;">{{ $speciesCount }}</h2>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge" style="background-color: #e8f5e9; color: #66bb6a;">
                                        <i class="fas fa-check-circle"></i> {{ $activeSpecies }} Active
                                    </span>
                                    @if ($inactiveSpecies > 0)
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            {{ $inactiveSpecies }} Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="icon-wrapper" style="background-color: #e3f2fd;">
                                <i class="fas fa-paw fs-1" style="color: #42a5f5;"></i>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar" style="background-color: #42a5f5;" role="progressbar"
                                style="width: {{ $speciesCount > 0 ? ($activeSpecies / $speciesCount) * 100 : 0 }}%">
                            </div>
                        </div>
                        <a href="{{ route('admin.species.species') }}" class="btn btn-sm w-100 text-white"
                            style="background-color: #42a5f5;">
                            <i class="fas fa-cog"></i> Manage Species
                        </a>
                    </div>
                </div>
            </div>

            <!-- Shared Safaris -->
            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-2 small fw-semibold text-uppercase">Shared Safaris</p>
                                <h2 class="mb-1 fw-bold" style="color: #e57373;">{{ $safarisCount }}</h2>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge pulse-badge"
                                        style="background-color: #e8f5e9; color: #66bb6a;">
                                        <i class="fas fa-heartbeat"></i> {{ $activeSafaris }} Active
                                    </span>
                                    @if ($inactiveSafaris > 0)
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            {{ $inactiveSafaris }} Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="icon-wrapper" style="background-color: #ffebee;">
                                <i class="fas fa-truck fs-1" style="color: #e57373;"></i>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar" style="background-color: #e57373;" role="progressbar"
                                style="width: {{ $safarisCount > 0 ? ($activeSafaris / $safarisCount) * 100 : 0 }}%">
                            </div>
                        </div>
                        <a href="{{ route('admin.sharedsafari.share.safari') }}" class="btn btn-sm w-100 text-white"
                            style="background-color: #e57373;">
                            <i class="fas fa-eye"></i> View All Safaris
                        </a>
                    </div>
                </div>
            </div>

            <!-- Packages -->
            <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-2 small fw-semibold text-uppercase">Tour Packages</p>
                                <h2 class="mb-1 fw-bold" style="color: #66bb6a;">{{ $packagesCount }}</h2>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge" style="background-color: #e8f5e9; color: #66bb6a;">
                                        <i class="fas fa-check-circle"></i> {{ $activePackages }} Active
                                    </span>
                                    @if ($inactivePackages > 0)
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            {{ $inactivePackages }} Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="icon-wrapper" style="background-color: #e8f5e9;">
                                <i class="fas fa-box fs-1" style="color: #66bb6a;"></i>
                            </div>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar" style="background-color: #66bb6a;" role="progressbar"
                                style="width: {{ $packagesCount > 0 ? ($activePackages / $packagesCount) * 100 : 0 }}%">
                            </div>
                        </div>
                        <a href="{{ route('admin.package.package') }}" class="btn btn-sm w-100 text-white"
                            style="background-color: #66bb6a;">
                            <i class="fas fa-cog"></i> Manage Packages
                        </a>
                    </div>
                </div>
            </div>
        </div>



        <style>
            .payment-card {
                transition: all 0.3s ease;
                background-color: #ffffff;
            }

            .payment-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
            }
        </style>


        <!-- Safari Status Overview -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100 stat-card"
                    style="border-left: 4px solid #81c784 !important;">
                    <div class="card-body text-center py-4">
                        <div class="icon-wrapper" style="background-color: #e8f5e9;" class="mx-auto mb-3">
                            <i class="fas fa-check-circle fs-1" style="color: #66bb6a;"></i>
                        </div>
                        <h2 class="fw-bold mb-2" style="color: #66bb6a;">{{ $approvedSafaris }}</h2>
                        <p class="text-muted mb-0 fw-medium">Approved Safaris</p>
                        <small style="color: #66bb6a;">
                            <i class="fas fa-shield-alt"></i> Ready to go
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100 stat-card"
                    style="border-left: 4px solid #ffb74d !important;">
                    <div class="card-body text-center py-4">
                        <div class="icon-wrapper" style="background-color: #fff3e0;" class="mx-auto mb-3">
                            <i class="fas fa-clock fs-1" style="color: #ffa726;"></i>
                        </div>
                        <h2 class="fw-bold mb-2" style="color: #ffa726;">{{ $pendingSafaris }}</h2>
                        <p class="text-muted mb-0 fw-medium">Pending Approval</p>
                        <small style="color: #ffa726;">
                            <i class="fas fa-hourglass-half"></i> Needs review
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100 stat-card"
                    style="border-left: 4px solid #64b5f6 !important;">
                    <div class="card-body text-center py-4">
                        <div class="icon-wrapper" style="background-color: #e3f2fd;" class="mx-auto mb-3">
                            <i class="fas fa-star fs-1" style="color: #42a5f5;"></i>
                        </div>
                        <h2 class="fw-bold mb-2" style="color: #42a5f5;">{{ $popularSafaris }}</h2>
                        <p class="text-muted mb-0 fw-medium">Popular Safaris</p>
                        <small style="color: #42a5f5;">
                            <i class="fas fa-fire"></i> Top picks
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100 stat-card"
                    style="border-left: 4px solid #ef9a9a !important;">
                    <div class="card-body text-center py-4">
                        <div class="icon-wrapper" style="background-color: #ffebee;" class="mx-auto mb-3">
                            <i class="fas fa-chart-line fs-1" style="color: #e57373;"></i>
                        </div>
                        <h2 class="fw-bold mb-2" style="color: #e57373;">{{ $trendingSafaris }}</h2>
                        <p class="text-muted mb-0 fw-medium">Trending Safaris</p>
                        <small style="color: #e57373;">
                            <i class="fas fa-arrow-circle-up"></i> Hot now
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row g-3">
            <!-- Recent Safaris -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header border-0"
                        style="background: linear-gradient(135deg, #8b9dc3 0%, #9fadc4 100%);">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="mb-0 fw-semibold">
                                <i class="far fa-calendar"></i> Recent Shared Safaris
                            </h6>
                            <span class="badge bg-white text-dark">{{ $recentSafaris->count() }}</span>
                        </div>
                    </div>
                    <div class="card-body p-0" style="max-height: 600px; overflow-y: auto;">
                        @if ($recentSafaris->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($recentSafaris as $safari)
                                    <div class="list-group-item safari-item p-2">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-start gap-2 mb-2">
                                                    <div class="rounded p-2" style="background-color: #ffebee;">
                                                        <i class="fas fa-truck" style="color: #e57373;"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fw-semibold">
                                                            {{ $safari->title ?? 'Untitled Safari' }}
                                                        </h6>
                                                        <div class="d-flex flex-wrap gap-2 align-items-center small">
                                                            <span class="text-muted">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                {{ $safari->park->name ?? 'Park not assigned' }}
                                                            </span>
                                                            <span class="text-muted">•</span>
                                                            <span class="badge bg-light text-dark">
                                                                <i class="far fa-calendar-alt"></i> {{ $safari->day }}D /
                                                                {{ $safari->night }}N
                                                            </span>
                                                            @if ($safari->min_price_pp)
                                                                <span class="text-muted">•</span>
                                                                <span class="text-success fw-semibold">
                                                                    <i
                                                                        class="fas fa-rupee-sign"></i>{{ number_format($safari->min_price_pp) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex gap-1 mt-2">
                                                            @if ($safari->popular)
                                                                <span class="badge bg-warning-subtle text-warning">
                                                                    <i class="fas fa-star"></i> Popular
                                                                </span>
                                                            @endif
                                                            @if ($safari->trending)
                                                                <span class="badge bg-danger-subtle text-danger">
                                                                    <i class="fas fa-chart-line"></i> Trending
                                                                </span>
                                                            @endif
                                                            @if ($safari->is_approved)
                                                                <span class="badge bg-success-subtle text-success">
                                                                    <i class="fas fa-check-circle"></i> Approved
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end ms-3">
                                                <span
                                                    class="badge {{ $safari->status == 'active' ? 'bg-success' : 'bg-secondary' }} mb-2">
                                                    {{ ucfirst($safari->status ?? 'N/A') }}
                                                </span>
                                                <div class="text-muted small">
                                                    <i class="far fa-clock"></i>
                                                    {{ $safari->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="icon-wrapper bg-danger bg-opacity-10 mx-auto mb-3">
                                    <i class="fas fa-inbox fs-1 text-danger"></i>
                                </div>
                                <p class="text-muted fw-medium">No safaris found</p>
                                <small class="text-muted">Create your first safari to get started</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Packages -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header border-0"
                        style="background: linear-gradient(135deg, #8b9dc3 0%, #9fadc4 100%);">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="mb-0 fw-semibold">
                                <i class="fas fa-box"></i> Recent Tour Packages
                            </h6>
                            <span class="badge bg-white text-dark">{{ $recentPackages->count() }}</span>
                        </div>
                    </div>
                    <div class="card-body p-0" style="max-height: 600px; overflow-y: auto;">
                        @if ($recentPackages->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($recentPackages as $package)
                                    <div class="list-group-item package-item p-2">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-start gap-2 mb-2">
                                                    <div class="rounded p-2" style="background-color: #e8f5e9;">
                                                        <i class="fas fa-box" style="color: #66bb6a;"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fw-semibold">
                                                            {{ $package->title ?? 'Untitled Package' }}
                                                        </h6>
                                                        <div class="d-flex flex-wrap gap-2 align-items-center small">
                                                            <span class="text-muted">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                {{ $package->park->name ?? 'Park not assigned' }}
                                                            </span>
                                                            @if ($package->min_price_pp || $package->max_price_pp)
                                                                <span class="text-muted">•</span>
                                                                <span class="text-success fw-semibold">
                                                                    <i class="fas fa-rupee-sign"></i>
                                                                    @if ($package->min_price_pp && $package->max_price_pp)
                                                                        {{ number_format($package->min_price_pp) }} -
                                                                        {{ number_format($package->max_price_pp) }}
                                                                    @elseif($package->min_price_pp)
                                                                        {{ number_format($package->min_price_pp) }}
                                                                    @else
                                                                        {{ number_format($package->max_price_pp) }}
                                                                    @endif
                                                                </span>
                                                            @endif
                                                            @if ($package->no_of_safari)
                                                                <span class="text-muted">•</span>
                                                                <span class="badge bg-light text-dark">
                                                                    <i class="fas fa-binoculars"></i>
                                                                    {{ $package->no_of_safari }} Safaris
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex gap-1 mt-2">
                                                            @if ($package->popular)
                                                                <span class="badge bg-warning-subtle text-warning">
                                                                    <i class="fas fa-star"></i> Popular
                                                                </span>
                                                            @endif
                                                            @if ($package->trending)
                                                                <span class="badge bg-danger-subtle text-danger">
                                                                    <i class="fas fa-chart-line"></i> Trending
                                                                </span>
                                                            @endif
                                                            @if ($package->top_rated)
                                                                <span class="badge bg-primary-subtle text-primary">
                                                                    <i class="fas fa-trophy"></i> Top Rated
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end ms-3">
                                                <span
                                                    class="badge {{ $package->status == 'active' ? 'bg-success' : 'bg-secondary' }} mb-2">
                                                    {{ ucfirst($package->status ?? 'N/A') }}
                                                </span>
                                                <div class="text-muted small">
                                                    <i class="far fa-clock"></i>
                                                    {{ $package->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="icon-wrapper bg-success bg-opacity-10 mx-auto mb-3">
                                    <i class="fas fa-inbox fs-1 text-success"></i>
                                </div>
                                <p class="text-muted fw-medium">No packages found</p>
                                <small class="text-muted">Create your first package to get started</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Payment History Cards -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header border-0"
                        style="background: linear-gradient(135deg, #8b9dc3 0%, #9fadc4 100%);">
                        <div class="d-flex align-items-center justify-content-between text-white">
                            <h6 class="mb-0 fw-semibold">
                                <i class="far fa-credit-card"></i> Today's Payments
                            </h6>
                            <span class="badge bg-white text-dark">{{ $recentPayments->count() }}</span>
                        </div>
                    </div>
                    <div class="card-body p-0" style="max-height: 600px; overflow-y: auto;">
                        @if ($recentPayments->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($recentPayments as $payment)
                                    <div class="list-group-item payment-item p-2">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-start gap-2 mb-2">
                                                    <div class="rounded p-2" style="background-color: #e3f2fd;">
                                                        <i class="far fa-credit-card" style="color: #42a5f5;"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        @if ($payment->payable_type == 'App\Models\ShareSafari')
                                                            <span class="badge bg-light text-dark mb-1">
                                                                <i class="fas fa-truck"></i> Safari Booking
                                                            </span>
                                                        @elseif($payment->payable_type == 'App\Models\Package')
                                                            <span class="badge bg-light text-dark mb-1">
                                                                <i class="fas fa-box"></i> Package Booking
                                                            </span>
                                                        @else
                                                            <span class="badge bg-light text-dark mb-1">Booking</span>
                                                        @endif

                                                        <div class="d-flex flex-wrap gap-2 align-items-center small">
                                                            <span class="text-muted">
                                                                <i class="fas fa-user"></i>
                                                                {{ Str::limit($payment->user->name ?? 'Guest', 20) }}
                                                            </span>
                                                            <span class="text-muted">•</span>
                                                            <span class="text-success fw-semibold">
                                                                <i
                                                                    class="fas fa-rupee-sign"></i>{{ number_format($payment->final_amount) }}
                                                            </span>
                                                        </div>

                                                        @if ($payment->discounted_amount > 0)
                                                            <div class="d-flex gap-1 mt-1">
                                                                <span class="badge"
                                                                    style="background-color: #fff3e0; color: #f57c00; font-size: 0.7rem;">
                                                                    <i class="fas fa-tag"></i>
                                                                    ₹{{ number_format($payment->discounted_amount) }}
                                                                    Off
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end ms-3">
                                                <span class="badge bg-success mb-2">
                                                    Paid
                                                </span>
                                                <div class="text-muted small">
                                                    <i class="far fa-clock"></i>
                                                    {{ $payment->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="icon-wrapper mx-auto mb-3" style="background-color: #e3f2fd;">
                                    <i class="fas fa-inbox fs-1" style="color: #42a5f5;"></i>
                                </div>
                                <p class="text-muted fw-medium">No payments today</p>
                                <small class="text-muted">Today's transactions will appear here</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Status Overview -->
        <div class="row g-3 mt-3">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-gradient text-white border-0"
                        style="background: linear-gradient(135deg, #8b9dc3 0%, #9fadc4 100%);">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-chart-bar"></i> Quick Status Overview
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="text-center p-4 border rounded-3 h-100 stat-card"
                                    style="background: linear-gradient(135deg, #fff8e1 0%, #fff 100%);">
                                    <div class="icon-wrapper mx-auto mb-3" style="background-color: #fff3e0;">
                                        <i class="fas fa-map-marker-alt fs-2" style="color: #ffa726;"></i>
                                    </div>
                                    <h6 class="text-muted mb-2 text-uppercase small fw-semibold">Active Parks</h6>
                                    <h3 class="mb-2 fw-bold" style="color: #ffa726;">{{ $activeParks }}</h3>
                                    <div class="progress mb-2" style="height: 4px;">
                                        <div class="progress-bar"
                                            style="background-color: #ffa726; width: {{ $parksCount > 0 ? ($activeParks / $parksCount) * 100 : 0 }}%;">
                                        </div>
                                    </div>
                                    <small class="text-muted">of {{ $parksCount }} total</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-4 border rounded-3 h-100 stat-card"
                                    style="background: linear-gradient(135deg, #ffebee 0%, #fff 100%);">
                                    <div class="icon-wrapper mx-auto mb-3" style="background-color: #ffebee;">
                                        <i class="fas fa-truck fs-2" style="color: #e57373;"></i>
                                    </div>
                                    <h6 class="text-muted mb-2 text-uppercase small fw-semibold">Active Safaris</h6>
                                    <h3 class="mb-2 fw-bold" style="color: #e57373;">{{ $activeSafaris }}</h3>
                                    <div class="progress mb-2" style="height: 4px;">
                                        <div class="progress-bar"
                                            style="background-color: #e57373; width: {{ $safarisCount > 0 ? ($activeSafaris / $safarisCount) * 100 : 0 }}%;">
                                        </div>
                                    </div>
                                    <small class="text-muted">of {{ $safarisCount }} total</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-4 border rounded-3 h-100 stat-card"
                                    style="background: linear-gradient(135deg, #e8f5e9 0%, #fff 100%);">
                                    <div class="icon-wrapper mx-auto mb-3" style="background-color: #e8f5e9;">
                                        <i class="fas fa-box fs-2" style="color: #66bb6a;"></i>
                                    </div>
                                    <h6 class="text-muted mb-2 text-uppercase small fw-semibold">Active Packages</h6>
                                    <h3 class="mb-2 fw-bold" style="color: #66bb6a;">{{ $activePackages }}</h3>
                                    <div class="progress mb-2" style="height: 4px;">
                                        <div class="progress-bar"
                                            style="background-color: #66bb6a; width: {{ $packagesCount > 0 ? ($activePackages / $packagesCount) * 100 : 0 }}%;">
                                        </div>
                                    </div>
                                    <small class="text-muted">of {{ $packagesCount }} total</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-4 border rounded-3 h-100 stat-card"
                                    style="background: linear-gradient(135deg, #e3f2fd 0%, #fff 100%);">
                                    <div class="icon-wrapper mx-auto mb-3" style="background-color: #e3f2fd;">
                                        <i class="fas fa-paw fs-2" style="color: #42a5f5;"></i>
                                    </div>
                                    <h6 class="text-muted mb-2 text-uppercase small fw-semibold">Wildlife Species</h6>
                                    <h3 class="mb-2 fw-bold" style="color: #42a5f5;">{{ $speciesCount }}</h3>
                                    <div class="mt-2">
                                        <span class="badge" style="background-color: #e3f2fd; color: #42a5f5;">
                                            <i class="fas fa-layer-group"></i> Complete Catalog
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
=======
<div class="container">
    <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card m-0 h-100 radius-10 border-start border-0 border-3 border-warning">
                <div class="card-body">
                    <a href="{{ route('admin.package.package') }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">National Parks</p>
                                <h4 class="my-1 text-warning">{{$parksCount}}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card m-0 h-100 radius-10 border-start border-0 border-3 border-info">
                <div class="card-body">
                    <a href="{{ route('admin.species.species') }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Species</p>
                                <h4 class="my-1 text-info">{{$speciesCount}}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card m-0 h-100 radius-10 border-start border-0 border-3 border-danger">
                <div class="card-body">
                    <a href="{{ route('admin.sharedsafari.share.safari') }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Shared Safari</p>
                                <h4 class="my-1 text-danger">{{$safarisCount}}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card m-0 h-100 radius-10 border-start border-0 border-3 border-success">
                <div class="card-body">
                    <a href="{{ route('admin.package.package') }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Packages</p>
                                <h4 class="my-1 text-success">{{$packagesCount}}</h4>
                            </div>
                        </div>
                    </a>
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
=======
</div>
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
