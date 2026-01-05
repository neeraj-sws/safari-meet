<div data-profile-parent>
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
        style="background-image:url({{ asset($parkDetails->banner_image) }} )">
        <div class="container-fluid container-padding">
            <div class="bannertext text-center">
                <h1 class="text-white">{{ $parkDetails?->banner_title }}</h1>
                <h3 class="text-white fw-normal">{{ $parkDetails->name }}</h3>
            </div>
        </div>
    </section>
    <!-- Tabs Navigation -->
    <section id="package-details-nav" class="mb-4 border-bottom">
        <div class="container-lg container-inner-padding">
            <nav class="overflow-auto">
                <ul class="nav nav-pills flex-nowrap flex-sm-nowrap d-flex border-0 gap-2" id="packageTab"
                    role="tablist" style="white-space: nowrap;">
                    <li class="nav-item" role="presentation">
                        <a href="javascript:void(0);" onclick="updateTab('overview')"
                            class="nav-link fw-semibold rounded-pill {{ $activeTab === 'overview' ? 'active bg-white' : '' }}"
                            id="overview-tab" type="button" role="tab">Overview</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="javascript:void(0);" onclick="updateTab('shared-safaris')"
                            class="nav-link fw-semibold rounded-pill {{ $activeTab === 'shared-safaris' ? 'active bg-white' : '' }}"
                            id="safaris-tab" type="button" role="tab">
                            Shared Safaris
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="javascript:void(0);" onclick="updateTab('packages')"
                            class="nav-link fw-semibold rounded-pill {{ $activeTab === 'packages' ? 'active bg-white' : '' }}"
                            id="packages-tab" type="button" role="tab">Packages
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
                        <aside class="col-12 col-lg-4 col-xl-3 d-flex justify-content-center">

                            <div class="filter-sidebar-wrapper filter-sidebar-wrapper-park border-0 mb-xl-0 mb-3"
                                wire:key="filter-sidebar-{{ now()->timestamp }}">
                                <div class="quote-form">
                                    <!-- Safari Quote Request Box -->
                                    <div class="card py-4 px-lg-3 px-sm-4 px-3 rounded-3 shadow-sm border-muted">
                                        <h3 class="fw-bold text-blue text-center mb-3">
                                            Get Free Quotes
                                        </h3>

                                        <form wire:submit.prevent="store">
                                            <!-- Safaris & Travelers -->
                                            <div class="row gx-3">
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" wire:model="user_name"
                                                        placeholder="Enter your Name">
                                                    @error('user_name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Email <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" wire:model="user_email"
                                                        placeholder="Enter your Email">
                                                    @error('user_email')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Number <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" wire:model="user_number"
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
                                                    <label class="form-label mb-1">Travellers <span class="text-danger">*</span> </label>
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
                                                    @foreach ($accommodations as $item)
                                                        <option value="{{ $item->id }}"
                                                            @selected($item->id == $accommodation)>
                                                            {{ $item->title }}
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
                                                    <span wire:loading wire:target="store">
                                                        <i class="spinner-border spinner-border-sm me-2"
                                                            role="status" aria-hidden="true"></i>
                                                        Sending...
                                                    </span>
                                                </button>
                                            </div>
                                            <!-- Note -->
                                            <p class="small mt-2 mb-0 text-center text-dark">
                                                *We'll share your request with all operators in the park and send you
                                                their quotes.
                                            </p>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </aside>
                        <!-- Main Content -->
                        <div class="col-12 col-lg-8 col-xl-9 main-content-scroll">
                            @if (
                                $parkDetails->DetailsCharacterstic->isNotEmpty() &&
                                    $parkDetails?->DetailsCharacterstic->where('status', 1)->count() > 0)
                                <div
                                    class="bg-white packagetab-navbar species-detail-tabs rounded-3 px-4 py-1 shadow-sm mb-4">
                                    <nav class="">
                                        <ul class="nav nav-pills border-0 flex-nowrap flex-row flex-lg-row"
                                            id="parkTab" role="tablist">
                                            @foreach ($parkDetails?->DetailsCharacterstic->where('status', 1) as $characteristic)
                                                @php $slug = Str::slug($characteristic?->title, '_'); @endphp
                                                <li class="nav-item" role="presentation">
                                                    <a href="javascript:void(0)"
                                                     onclick="updateTab('overview', '{{ $slug }}','{{ $characteristic->park_tabs_id }}')"
                                                         wire:click="setActiveTab('{{ $slug }}')"
                                                        class="nav-link {{ $activeTabForOverview === $slug ? 'active' : '' }}  fw-normal rounded-pill"
                                                        id="keyinfo-tab">{{ $characteristic->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </nav>
                                </div>
                            @endif
                            <div class="tab-content">
                                @php
                                    $characterstic = $parkDetails?->DetailsCharacterstic
                                        ->where('status', 1)
                                        ->where('park_tabs_id', $overviewActiveTabData)
                                        ->first();
                                    $slug = Str::slug($characterstic?->title, '_');
                                @endphp
                                @if (!empty($parkDetails) && !empty($characterstic))

                                    @if ($overviewActiveTabData == 1 && !empty($parkDetails) && !empty($characterstic))
                                        <livewire:front.park.details.key-info-component :parkdetails="$parkDetails"
                                            :characteristic="$characterstic" :key="'info' . $characterstic->id" />
                                    @elseif($overviewActiveTabData == 2 && !empty($parkDetails) && !empty($characterstic))
                                        <livewire:front.park.details.about-park-component :parkdetails="$parkDetails"
                                            :characteristic="$characterstic" :key="'about' . $characterstic->id" />
                                    @elseif($overviewActiveTabData == 3 && !empty($parkDetails) && !empty($characterstic))
                                        <livewire:front.park.details.safari-information-component :parkdetails="$parkDetails"
                                            :characteristic="$characterstic" :key="'safari-information' . $characterstic->id" />
                                    @elseif($overviewActiveTabData == 4 && !empty($parkDetails) && !empty($characterstic))
                                        <livewire:front.park.details.park-accommodations :parkdetails="$parkDetails"
                                            :characteristic="$characterstic" :key="'park-accommodations' . $characterstic->id" />
                                    @elseif($overviewActiveTabData == 5 && !empty($parkDetails) && !empty($characterstic))
                                        <livewire:front.park.details.wildlife-you-may-see-component :parkdetails="$parkDetails"
                                            :characteristic="$characterstic" :key="'wildlife-you-may-see' . $characterstic->id" />
                                    @elseif($overviewActiveTabData == 6 && !empty($parkDetails) && !empty($characterstic))
                                        <livewire:front.park.details.how-to-reach-component :parkdetails="$parkDetails"
                                            :characteristic="$characterstic" :key="'how-to-reach' . $characterstic->id" />
                                    @elseif($overviewActiveTabData == 7 && !empty($parkDetails) && !empty($characterstic))
                                        <livewire:front.park.details.travel-tips-component :parkdetails="$parkDetails"
                                            :characteristic="$characterstic" :key="'travel-tips' . $characterstic->id" />
                                    @elseif($overviewActiveTabData == 11 && !empty($parkDetails) && !empty($characterstic))
                                        <livewire:front.park.details.park-faq :parkdetails="$parkDetails"
                                            :characteristic="$characterstic" :key="'travel-tips' . $characterstic->id" />
                                    @else
                                        <livewire:front.park.details.dynamic-tab-component :parkdetails="$parkDetails"
                                            :characteristic="$characterstic" :key="'ynamic-tab' . $characterstic->id" />
                                    @endif
                                @else
                                    <div class="text-center">
                                        <img src="{{ asset('front-assets/images/cat-with-magnifying-glass-illustration-svg-png-download-11511372.png') }}"
                                            class="freepikimg" style="width:350px;">
                                        <h6>Data Not Found</h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif ($activeTab === 'packages')
                    <div class="row g-3 position-relative mb-5" style="min-height: 100vh;">
                        <livewire:front.safari-package.listing :carousel="1" :type="2" :species="$parkDetails"
                            :key="'package.list'" />
                    </div>
                @elseif ($activeTab === 'shared-safaris')
                    <div class="row g-3 position-relative mb-5" style="min-height: 100vh;">
                        <livewire:front.shared-safari.listing :carousel="1" :type="2" :species="$parkDetails"
                            :key="'sharedsafari'" />
                    </div>
                @else
                    <div class="text-center">
                        <img src="{{ asset('front-assets/images/cat-with-magnifying-glass-illustration-svg-png-download-11511372.png') }}"
                            class="freepikimg" style="width:350px;">
                        <h6>Data Not Found</h6>
                    </div>
                @endif
            </div>
            <!-- Top Rated Park  -->
            <div id="top-rated-park" class="mt-3">
                <livewire:front.common.top-rated-parks-carousel :key="'top-rated-parks-carousel-details'" />
            </div>
        </div>
    </main>
</div>
@push('scripts')
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
            component.set('activeTab', tab);
            if (subtab) {
                component.set('overviewActiveTabData', subtabId);
                component.set('activeTabForOverview', subtab);
            }
        }
    </script>
@endpush
