<div>
    <style>
        .step {
            text-align: center;
        }

        .step .circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-weight: 600;
        }

        .step.active .circle {
            background: #f27a3b;
            color: #fff;
        }

        .progress {
            height: 3px;
            background: #dee2e6;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            background-color: #f27a3b;
        }

        .nav-pills .nav-link.active .tab-title {
            color: #fff !important;
        }
    </style>

    <!-- Hero Banner -->
    <section id="home-hero"
        class="search-hero listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
        <div class="container">
            <div class="bannertext text-center">
                <h1 class="fw-bold text-white">Organize a Shared Safari</h1>
                <p class="lead text-light mt-2">Fill in the details below to publish your safari</p>
            </div>
        </div>
    </section>

    <!-- Main Form Section -->
    <section class="step-form my-5">
        <div class="container-lg">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="row g-5 align-items-center">
                        <!-- Steps Progress -->
                        <div class="col-lg-7">
                            <!-- Step Indicators -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                @foreach (range(1, 4) as $step)
                                    @if ($step > 1)
                                        <div class="progress flex-grow-1 mx-2"></div>
                                    @endif
                                    <div class="step {{ $active == $step ? 'active' : '' }}">
                                        <div class="circle">{{ $step }}</div>
                                        <small class="d-block mt-2">
                                            @switch($step)
                                                @case(1) Basic Info @break
                                                @case(2) Details @break
                                                @case(3) Upload @break
                                                @case(4) Other @break
                                            @endswitch
                                        </small>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Main Form -->
                            <form wire:submit.prevent="store">
                                <!-- Tab 1: Basic Info -->
                                @if ($active == 1)
                                    @include('livewire.front.shared-safari.organize.tabs.basic-info')
                                @endif

                                <!-- Tab 2: Details -->
                                @if ($active == 2)
                                    @include('livewire.front.shared-safari.organize.tabs.details')
                                @endif

                                <!-- Tab 3: Upload Image -->
                                @if ($active == 3)
                                    @include('livewire.front.shared-safari.organize.tabs.upload-image')
                                @endif
                            </form>

                            <!-- Tab 4: Other (Characteristics) -->
                            @if ($active == 4)
                                @include('livewire.front.shared-safari.organize.tabs.other')
                            @endif
                        </div>

                        <!-- Sidebar Image -->
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
