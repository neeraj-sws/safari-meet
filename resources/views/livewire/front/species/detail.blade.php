<div  data-profile-parent>
    <style>
        #parkTab {
            overflow-x: auto;
            justify-content: left !important;
        }

        @media (max-width: 768px) {
            .packagetab-navbar.species-detail-tabs .nav-pills .nav-link {
                padding: 9px 14px;
            }

        }

        #parkTab::-webkit-scrollbar {
            height: 0px;
        }
    </style>
    <!-- Hero Section -->
    <section id="home-hero"
        class="park-home-hero d-flex align-items-center justify-content-center text-center text-white mb-2"
        style="background-image:url({{ asset($species->banner_image) }} )">
        <div class="container-fluid container-padding">
            <div class="bannertext text-center">
                <h1 class="text-white">{{ $species->name }}</h1>
            </div>
        </div>
    </section>
    <!-- Tabs Navigation -->
    <section id="package-details-nav" class="mb-4 border-bottom" wire:key="tab-sections">
        <div class="container-lg container-inner-padding">
            <nav class="overflow-auto">
                <ul class="nav nav-pills flex-nowrap flex-sm-nowrap d-flex border-0 gap-2" id="packageTab"
                    role="tablist" style="white-space: nowrap;">
                    <li class="nav-item" role="presentation">
                        <a href="javascript:void(0);" onclick="updateTab('overview')"
                            class="nav-link fw-semibold bg-white {{ $activeTab === 'overview' ? 'active' : '' }}"
                            id="overview-tab" type="button" role="tab">
                            Overview
                        </a>

                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="javascript:void(0);" onclick="updateTab('safaris')"
                            class="nav-link fw-semibold bg-white {{ $activeTab === 'safaris' ? 'active' : '' }}"
                            id="safaris-tab" type="button" role="tab">
                            Shared Safaris
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="javascript:void(0);" onclick="updateTab('packages')"
                            class="nav-link fw-semibold bg-white {{ $activeTab === 'packages' ? 'active' : '' }}"
                            id="packages-tab" type="button" role="tab">
                            Packages
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </section>
    <main>
        <div class="container-lg container-inner-padding mb-5">
            <!-- Tabs Content -->
            <div class="tab-content" id="ParkTabContent">
                @if ($activeTab === 'overview')
                    <div class="row gx-3 flex-lg-row flex-column-reverse">
                        <!-- Sidebar Filter -->
                        <aside class="col-12 col-lg-4 col-xl-3 d-flex justify-content-center ">

                            <div class="filter-sidebar-wrapper filter-sidebar-wrapper-park border-0 mb-xl-0 mb-3"
                                wire:key="filter-sidebar">
                                <div class="quote-form">
                                    <!-- Safari Quote Request Box -->
                                    <div class="card py-4 px-lg-3 px-sm-4 px-3 rounded-3 shadow-sm border-muted">
                                        <h3 class="fw-bold text-blue text-center mb-3">
                                            Safari Quotes
                                        </h3>

                                        <form wire:submit.prevent="submit">
                                            <!-- Safaris & Travelers -->
                                            <div class="row gx-3">
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Name <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control text-capitalize"
                                                        wire:model="user_name"
                                                        oninput="filterAndFormatInputs(this,{allowAlpha:true})"
                                                        placeholder="Enter your Name">
                                                    @error('user_name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Email <span class="text-danger">*</span> </label>
                                                    <input type="email" class="form-control" wire:model="user_email"
                                                        placeholder="Enter your Email">
                                                    @error('user_email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Number <span class="text-danger">*</span> </label>
                                                    <input type="number" class="form-control" wire:model="user_number"
                                                        oninput="filterPhoneNumber(this)"
                                                        placeholder="Enter you Number">
                                                    @error('user_number')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Safaris <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" wire:model="safaris"
                                                        placeholder="Enter Safaris ">
                                                    @error('safaris')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Travellers <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" wire:model="travellers"
                                                        placeholder="Enter Travellers ">
                                                    @error('travellers')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                 <!-- Accommodation -->
                                            <div class="col-lg-12 col-sm-6 mb-3">
                                                <label for="accommodation" class="form-label mb-1">Accommodation <span class="text-danger">*</span> </label>
                                                <select class="form-select " id="accommodation"
                                                    wire:model="accommodation">
                                                    <option value="">Select...</option>
                                                    @foreach ($accommodations as $accommodation)
                                                        <option value="{{ $accommodation->id }}">
                                                            {{ $accommodation->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('accommodation')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            </div>
                                            <!-- Dates -->
                                            <div class="row gx-3">
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Start Date <span class="text-danger">*</span> </label>
                                                    @php $start =  \App\Helpers\SettingHelper::get('enquiry_date_after', '0') @endphp
                                                    <input type="text" class="form-control datepicker"
                                                        data-role="start" data-start="{{ $start }}"
                                                        data-group="booking1" wire:model="start_date">
                                                    @error('start_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">End Date <span class="text-danger">*</span> </label>
                                                    <input type="text" class="form-control datepicker"
                                                        data-role="end" data-group="booking1" wire:model="end_date">
                                                    @error('end_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- Submit Button -->
                                            <div class="">
                                                <button type="submit"
                                                    class="btn btn-outline-primary blue-btn-hover px-5 w-100 rounded-pill"
                                                    wire:loading.attr="disabled"><span wire:loading.class="d-none"
                                                        class="text-white"> Send Request </span>
                                                    <span wire:loading wire:target="submit">
                                                        <i class="spinner-border spinner-border-sm me-2"
                                                            role="status" aria-hidden="true"></i>
                                                        Sending...
                                                    </span>
                                                </button>
                                            </div>
                                            <!-- Note -->
                                            <p class="small mt-2 mb-0 text-center text-dark">
                                                *We'll share your request with all operators in the park and send
                                                you
                                                their quotes.
                                            </p>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </aside>
                        <!-- Main Content -->
                        <div class="col-12 col-lg-8 col-xl-9 main-content-scroll">
                            @if ($species?->charactersticDetails->where('status', 1)->count() > 0)
                                <div
                                    class="bg-white packagetab-navbar species-detail-tabs rounded-3 px-4 py-1 shadow-sm mb-4">
                                    <nav class="">
                                        <ul class="nav nav-pills border-0 flex-nowrap flex-row flex-lg-row justify-content-md-center"
                                            id="parkTab">
                                            @foreach ($species->charactersticDetails->where('status', 1) as $characterstic)
                                                @php $slug = Str::slug($characterstic?->title, '_'); @endphp
                                                <li class="nav-item" role="presentation">
                                                    <a href="javascript:void(0)"
                                                        onclick="updateTab('overview', '{{ $slug }}','{{ $characterstic->species_characterstics }}')"
                                                         wire:click="setOverViewActiveTab('{{ $slug }}')"
                                                        class="nav-link {{ $overviewActiveTab }}--{{ $slug }}  {{ $overviewActiveTab === $slug ? 'active' : '' }} fw-normal rounded-pill"
                                                        id="{{ $slug }}-tab">
                                                        {{ $characterstic?->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </nav>
                                </div>
                                <div class="tab-content">
                                    @php
                                        $characterstic = $species->charactersticDetails
                                            ->where('status', 1)
                                            ->where('species_characterstics', $overviewActiveTabData)
                                            ->first();
                                        $slug = Str::slug($characterstic?->title, '_');
                                    @endphp
                                    @if ($overviewActiveTabData == 1 && !empty($species) && !empty($characterstic))
                                        @livewire('front.species.pages.over-view-component', ['species' => $species, 'characterstic' => $characterstic])
                                    @elseif($overviewActiveTabData == 2 && !empty($species) && !empty($characterstic))
                                        @livewire('front.species.pages.physical-appereance-component', ['species' => $species, 'characterstic' => $characterstic])
                                    @elseif($overviewActiveTabData == 3 && !empty($species) && !empty($characterstic))
                                        @livewire('front.species.pages.life-style-component', ['species' => $species, 'characterstic' => $characterstic])
                                    @elseif($overviewActiveTabData == 4 && !empty($species) && !empty($characterstic))
                                        @livewire('front.species.pages.threat-component', ['species' => $species, 'characterstic' => $characterstic])
                                    @elseif($overviewActiveTabData == 5 && !empty($species) && !empty($characterstic))
                                        @livewire('front.species.pages.interesting-facts-component', ['species' => $species, 'characterstic' => $characterstic])
                                    @else
                                        @if (!empty($species) && !empty($characterstic))
                                            @livewire('front.species.pages.common-tab-component', ['species' => $species, 'characterstic' => $characterstic], key('common-' . $characterstic?->id))
                                        @endif
                                    @endif
                                </div>
                            @else
                                <div class="text-center">
                                    <img src="{{ asset('front-assets/images/cat-with-magnifying-glass-illustration-svg-png-download-11511372.png') }}"
                                        class="freepikimg" style="width:350px;">
                                    <h6>Data Not Found</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif ($activeTab === 'packages')
                    <div class="row g-3 position-relative" style="min-height: 100vh;">
                        <livewire:front.safari-package.listing :carousel="1" :type="1" :species="$species"
                            :key="'package-list'" />
                    </div>
                @elseif ($activeTab === 'safaris')
                    <div class="row g-3 position-relative" style="min-height: 100vh;">
                        <livewire:front.shared-safari.listing :carousel="1" :type="1" :species="$species"
                            :key="'sharedsafari'" />
                    </div>
                @else
                    <div class="text-center">
                        <img src="{{ asset('front-assets/images/cat-with-magnifying-glass-illustration-svg-png-download-11511372.png') }}"
                            class="freepikimg" style="width:250px;">
                        <h6>Data Not Found</h6>
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
@push('scripts')
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

    <script>
        function updateTab(tab, subtab = null, subtabId = null) {
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);

            if (subtab) {
                url.searchParams.set('subtab', subtab);
            } else {
                url.searchParams.delete('subtab');
            }

            window.history.pushState({}, '', url);

            const componentEl = document.querySelector('[data-profile-parent][wire\\:id]');
            if (!componentEl) return;

            const component = Livewire.find(componentEl.getAttribute('wire:id'));

            component.set('activeTab', tab);
            if (subtab) {
                component.set('overviewActiveTabData', subtabId);
                component.set('overviewActiveTab', subtab);
            }
        }
    </script>
@endpush
