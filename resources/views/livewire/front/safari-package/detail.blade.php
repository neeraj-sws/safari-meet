<div>
    <style>
        #similar-packages-owl .card-img-top {
            width: 100%;
            height: 260px;
            /* adjust size if needed */
            object-fit: cover;
            object-position: center;
            border-radius: 10px 10px 0 0;
        }
    </style>
    <main>
        @if (count($bannerImg) > 0)
        <section id="package-carousel-section" class="">
            <div class="pe-md-0">
                <div class="guest-carousel-wrapper position-relative">
                    <div class="carousel-text position-absolute text-white text-center w-100">
                        <h2>{{ $package->end_tour }} Night / {{ $package->start_tour }} Days Stay -
                            {{ $package->title }}</h2>
                    </div>

                    <div class="owl-carousel owl-theme" id="package-detail-slider">
                        @foreach ($bannerImg as $img)
                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="carousel-image">
                                    <img src="{{ asset($img) }}" alt="Carousel-1" class="img-fluid rounded-0">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif

        <section id="general-info" class="grey-bg py-5">
            <div class="container-lg container-inner-padding">
                <div class="row gx-3 align-items-center">
                    <div class="col-md-3">
                        <div class="general-info-img text-md-start text-center mb-md-0 mb-3">
                            <img src="{{ asset($package->display_image) }}" alt="Pathway-image"
                                class="img-fluid rounded-3">
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="general-info-list border-start ps-2 border-primary mb-md-0 mb-3">
                            <ul class="list-unstyled mb-0  package-lists ps-3">
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-wrap mb-3">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M480-80q-106 0-173-33.5T240-200q0-24 14.5-44.5T295-280l63 59q-9 4-19.5 9T322-200q13 16 60 28t98 12q51 0 98.5-12t60.5-28q-7-8-18-13t-21-9l62-60q28 16 43 36.5t15 45.5q0 53-67 86.5T480-80Zm1-220q99-73 149-146.5T680-594q0-102-65-154t-135-52q-70 0-135 52t-65 154q0 67 49 139.5T481-300Zm-1 100Q339-304 269.5-402T200-594q0-71 25.5-124.5T291-808q40-36 90-54t99-18q49 0 99 18t90 54q40 36 65.5 89.5T760-594q0 94-69.5 192T480-200Zm0-320q33 0 56.5-23.5T560-600q0-33-23.5-56.5T480-680q-33 0-56.5 23.5T400-600q0 33 23.5 56.5T480-520Zm0-80Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Destination:</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">
                                            {{ $package?->park?->name ?? '' }},
                                            {{ $package->park?->state?->name ?? '' }}

                                        </p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-wrap mb-3">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M200-640h560v-80H200v80Zm0 0v-80 80Zm0 560q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v227q-19-9-39-15t-41-9v-43H200v400h252q7 22 16.5 42T491-80H200Zm520 40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Zm67-105 28-28-75-75v-112h-40v128l87 87Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Duration:</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark"> {{ $package->end_tour ?? '-' }} Nights
                                            /
                                            {{ $package->start_tour ?? '-' }} Days
                                        </p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-wrap mb-3">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M240-200q-50 0-85-35t-35-85H40v-360q0-33 23.5-56.5T120-760h560l240 240v200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H360q0 50-35 85t-85 35Zm360-360h160L640-680h-40v120Zm-240 0h160v-120H360v120Zm-240 0h160v-120H120v120Zm120 290q21 0 35.5-14.5T290-320q0-21-14.5-35.5T240-370q-21 0-35.5 14.5T190-320q0 21 14.5 35.5T240-270Zm480 0q21 0 35.5-14.5T770-320q0-21-14.5-35.5T720-370q-21 0-35.5 14.5T670-320q0 21 14.5 35.5T720-270ZM120-400h32q17-18 39-29t49-11q27 0 49 11t39 29h304q17-18 39-29t49-11q27 0 49 11t39 29h32v-80H120v80Zm720-80H120h720Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Safari Type:</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">{{ $types ?? 'N/A' }}
                                        </p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-wrap mb-3">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M531-260h96v-3L462-438l1-3h10q54 0 89.5-33t43.5-77h40v-47h-41q-3-15-10.5-28.5T576-653h70v-47H314v57h156q26 0 42.5 13t22.5 32H314v47h222q-6 20-23 34.5T467-502H367v64l164 178ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Starting Price: </p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">₹ {{ $package->min_price_pp ?? 'NA' }}
                                            per person
                                        </p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-wrap mb-3">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M680-120q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Zm-30-280v-80h60v80h-60Zm0 400v-80h60V0h-60Zm165-333-43-42 57-57 42 43-56 56ZM531-49l-42-42 57-57 42 42-57 57Zm309-161v-60h80v60h-80Zm-400 0v-60h80v60h-80ZM829-49l-56-57 42-42 57 56-43 43ZM545-332l-56-57 42-42 57 56-43 43ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v160H200v400h160v80H200Zm0-560h560v-80H200v80Zm0 0v-80 80Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Best Time: </p>
                                        </div>
                                        @php
                                        $BestTime = $package?->park?->parkBestTimes
                                        ? $package->park?->parkBestTimes
                                        ?->pluck('weather.title')
                                        ->filter()
                                        ->implode(', ')
                                        : 'Null';
                                        @endphp
                                        <p class="mb-0 list-paragraph text-dark">
                                            {{ $BestTime }}
                                        </p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-wrap mb-3">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M240-200q-50 0-85-35t-35-85H40v-360q0-33 23.5-56.5T120-760h560l240 240v200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H360q0 50-35 85t-85 35Zm360-360h160L640-680h-40v120Zm-240 0h160v-120H360v120Zm-240 0h160v-120H120v120Zm120 290q21 0 35.5-14.5T290-320q0-21-14.5-35.5T240-370q-21 0-35.5 14.5T190-320q0 21 14.5 35.5T240-270Zm480 0q21 0 35.5-14.5T770-320q0-21-14.5-35.5T720-370q-21 0-35.5 14.5T670-320q0 21 14.5 35.5T720-270ZM120-400h32q17-18 39-29t49-11q27 0 49 11t39 29h304q17-18 39-29t49-11q27 0 49 11t39 29h32v-80H120v80Zm720-80H120h720Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Total Safari:</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">{{ $package->no_of_safari ?? 'Na' }}
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto ms-md-auto mt-auto">

                        <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                            <a href="javascript:void(0)" wire:click="showEnquire"
                                class="btn btn-sm btn-primary blue-btn-hover border-blue blue-border-hover rounded-1">Enquire
                                Now</a>
                            @auth
                            <a href="javascript:void(0)" wire:click="addwishlist({{ $package->id }})"
                                class="btn btn-sm border border-blue blue-border-hover blue-text-hover border-2 rounded-1">{{
                                $wishlistTitle }}</a>
                            @endauth
                        </div>
                        <div class="organizer-name d-flex align-items-center gap-2">
                            @php
                            $type = 'user';
                            if ($this->package->type == 0) {
                            $type = 'admin';
                            } else {
                            $type = 'user';
                            }
                            @endphp
                            <livewire:front.common.interested-people :userList="$organizer" :usertype="$type"
                                :key="'interested-people-' . $organizer" />
                            <div class="d-flex align-items-center">
                                <span class="small me-2">Organized by:</span>
                                <strong>{{ $package->type == 0 ? $organizer->name ?? 'Admin' : $organizer->name ??
                                    'Travel Agent' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div>
            @if ($showEnquireForm)
            <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);" aria-modal="true"
                role="dialog">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Safari Enquiry Form</h5>
                            <button type="button" class="btn-close" wire:click="closeShowForm"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="saveEnquiry">
                                <div class="row">
                                    <!-- Full Name -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" wire:model="name" class="form-control text-capitalize"
                                            placeholder="Your full name" pattern="[A-Za-z\s]+"
                                            title="Only alphabets allowed">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" wire:model="email" class="form-control"
                                            placeholder="Your email" inputmode="email">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Country -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Country</label>
                                        <input type="text" wire:model="country" class="form-control text-capitalize"
                                            placeholder="Your country" pattern="[A-Za-z\s]+"
                                            title="Only alphabets allowed">
                                        @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Mobile Number -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mobile Number</label>
                                        <input type="tel" wire:model="mobile_number" class="form-control"
                                            placeholder="Your phone number" maxlength="10" pattern="[0-9]{10}"
                                            oninput="filterPhoneNumber(this)"
                                            title="Only digits allowed (10 characters)">
                                        @error('mobile_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Travelers -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Travelers</label>
                                        <input type="number" wire:model="travelers" class="form-control"
                                            placeholder="Enter number of travelers" min="1" max="20">
                                        @error('travelers')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Start Date -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" wire:model="start_date" class="form-control datepicker">
                                        @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Message -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Message</label>
                                        <textarea wire:model="message" class="form-control" rows="3"
                                            placeholder="Write your message (optional)" maxlength="1000"></textarea>
                                        @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-grid mt-3">
                                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="saveEnquiry">Submit Enquiry</span>
                                        <span wire:loading wire:target="saveEnquiry">
                                            <span class="spinner-border spinner-border-sm"></span> Saving...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>

        @if (count($package?->detailsTabs->where('status', 1)) > 0)
        <section id="package-details-nav" class="mb-4 border-bottom">
            <div class="container-lg container-inner-padding">
                <nav class="overflow-auto mb-2">
                    <ul class="navbar-nav flex-row flex-nowrap gap-3" id="packageDetailNav"
                        style="white-space: nowrap;">
                        @foreach ($package?->detailsTabs->where('status', 1) as $tabs)
                        <li class="nav-item">
                            <a class="nav-link pb-0 ps-0 fw-semibold" href="#section-{{ $tabs->id }}">{{ $tabs->title
                                }}</a>
                        </li>
                        @endforeach
                        @if ($faqs)
                        <li class="nav-item">
                            <a class="nav-link pb-0 ps-0 fw-semibold" href="#section-{{ $package->park->id }}"> FAQ's
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>

            </div>
        </section>
        @endif

        <section id="package-details" class="mb-sm-5 mb-4" wire:key="package-details-{{ now()->timestamp }}">
            <div class="container-lg container-inner-padding">
                <div class="row">
                    @if (count($package?->detailsTabs->where('status', 1)) > 0)
                    <div class="col-lg-8">
                        @php
                        $itinerary = $package?->detailsTabs
                        ->where('status', 1)
                        ->Where('package_tabs_id', 2)
                        ->first();
                        @endphp
                        @if (!empty($itinerary))
                        @if (count($itineraries) > 0)
                        <div class="secion-itinerary package-accordion mb-4" id="section-{{ $itinerary->id }}">
                            <h3 class="text-blue">Itinerary</h3>
                            <div class="accordion p-3 rounded-3 dark-grey-bg" id="itineraryAccordion">
                                <!-- Day 1 -->
                                @foreach ($itineraries as $Itinerary)
                                <div class="accordion-item mb-3 rounded-3">
                                    <h2 class="accordion-header rounded-top-3" id="day1">
                                        <button class="accordion-button rounded-top-3 rounded-bottom-0" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseDay{{ $loop->iteration }}">
                                            Day {{ $loop->iteration }}:
                                            {{ $Itinerary->short_description }}
                                        </button>
                                    </h2>
                                    <div id="collapseDay{{ $loop->iteration }}" class="accordion-collapse collapse show"
                                        data-bs-parent="#itineraryAccordion">
                                        <div class="accordion-body pt-0">
                                            <ul class="list-unstyled mb-0  package-lists">
                                                @foreach ($Itinerary->packageActivities as $packageActivity)
                                                <li class="mb-2">
                                                    <i class="fa-regular fa-circle-check"></i>
                                                    {{ $packageActivity->activity }}
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>

                        </div>
                        @endif
                        @endif
                        @php
                        $inclusions = $package?->detailsTabs
                        ->where('status', 1)
                        ->Where('package_tabs_id', 3)
                        ->first();
                        @endphp
                        @if (!empty($inclusions))
                        @if (count($dataInclusions) > 0)
                        <h3 class="text-blue">Inclusions</h3>
                        <div class="section-inclusions p-3 rounded-3 dark-grey-bg mb-4"
                            id="section-{{ $inclusions->id }}">
                            <div class="bg-white px-4 py-3 rounded-3">
                                <ul class="list-unstyled mb-0  package-lists ps-3">
                                    @foreach ($dataInclusions as $index => $item)
                                    @php
                                    $title = $item['title'] ?? '';
                                    $icon = $item['icon'] ?? '';
                                    $collapseId = 'faq' . $index;
                                    $headingId = 'heading' . $index;
                                    @endphp

                                    <li class="mb-2">
                                        {!! $icon !!}
                                        {{ $title }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @endif
                        @php
                        $exclusions = $package?->detailsTabs
                        ->where('status', 1)
                        ->Where('package_tabs_id', 4)
                        ->first();
                        @endphp
                        @if (!empty($exclusions))
                        @if (count($dataExclusions) > 0)
                        <h3 class="text-blue">Exclusions</h3>
                        <div class="section-exclusions p-3 rounded-3 dark-grey-bg mb-4"
                            id="section-{{ $exclusions->id }}">
                            <div class="bg-white px-4 py-3 rounded-3">
                                <ul class="list-unstyled mb-0  package-lists ps-3">
                                    @foreach ($dataExclusions as $index => $item)
                                    @php
                                    $title = $item['title'] ?? '';
                                    $icon = $item['icon'] ?? '';
                                    $collapseId = 'faq' . $index;
                                    $headingId = 'heading' . $index;
                                    @endphp

                                    <li class="mb-2">
                                        {!! $icon !!}
                                        {{ $title }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @endif
                        @php
                        $accommodation = $package?->detailsTabs
                        ->where('status', 1)
                        ->Where('package_tabs_id', 5)
                        ->first();
                        @endphp
                        @if (!empty($accommodation))
                        @if ($accommodationData && $accommodationData->accommodation)
                        <h3 class="text-blue mb-3">Accommodation Details:</h3>
                        <div class="section-accommodation p-3 rounded-3 dark-grey-bg mb-4"
                            id="section-{{ $accommodation->id }}">
                            <div class="bg-white px-4 py-3 rounded-3">
                                <!-- Grid for desktop -->
                                <div class="row">
                                    <div class="col-xl-6 mb-xl-0 mb-3 d-sm-block d-none">
                                        <div class="row row-gap-3 gx-3">
                                            @foreach ($accommodationData->accommodation->image->take(4) as $img)
                                            <div class="col-6">
                                                <div class="accommodation-right">
                                                    <img src="{{ asset($img->image) }}" alt="Accommodation Image"
                                                        class="img-fluid w-100 rounded-3">
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-xl-6 mb-xl-0 mb-3 ps-xl-1 d-sm-block d-none">
                                        @if ($accommodationData->accommodation->image->skip(4)->first())
                                        <div class="accommodation-left mb-3">
                                            <img src="{{ asset($accommodationData->accommodation->image->skip(4)->first()->image) }}"
                                                class="img-fluid w-100 rounded-3" alt="Accommodation">
                                        </div>
                                        @endif
                                    </div>
                                    <!-- Owl Carousel for mobile only -->
                                    <div class="col-12 d-sm-none owl-carousel owl-theme mb-3">
                                        @foreach ($accommodationData->accommodation->image->take(5) as $img)
                                        <div class="item">
                                            <img src="{{ asset($img->image) }}" alt="Lodge-1"
                                                class="img-fluid rounded-3 accommodation-mobile-img">
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="col-12">
                                        <div class="lodge-name">
                                            <h3 class="mb-1 text-accent">
                                                {{ $accommodationData->accommodation->title }}
                                            </h3>
                                            @php
                                            $rating = $accommodationData->accommodation->rating ?? 0;
                                            $fullStars = floor($rating);
                                            $halfStar = $rating - $fullStars >= 0.5 ? 1 : 0;
                                            $emptyStars = 5 - ($fullStars + $halfStar);
                                            @endphp

                                            <div class="star-rating d-flex align-items-center gap-1 mb-1">

                                                @for ($i = 0; $i < $fullStars; $i++) <img
                                                    src="{{ asset('front-assets/images/icons/star-fill.png') }}"
                                                    alt="Full Star">
                                                    @endfor
                                                    @if ($halfStar)
                                                    <img src="{{ asset('front-assets/images/icons/half-fill.png') }}"
                                                        alt="Half Star">
                                                    @endif
                                                    @for ($i = 0; $i < $emptyStars; $i++) <img
                                                        src="{{ asset('front-assets/images/icons/star-fill.png') }}"
                                                        alt="Empty Star" style="opacity: 0.3;">
                                                        @endfor
                                            </div>
                                            <div class="category">
                                                <span class="text-dark">Category:</span>
                                                <p class="text-dark d-inline-block">
                                                    {{ $accommodationData->accommodation->category->name ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="amenities-container">
                                            <h3 class="text-blue">Amenities</h3>
                                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                                @foreach ($accommodationData->accommodation->amenity as $amenity)
                                                <div class="amenities me-3">
                                                    {!! $amenity?->amenity->icon !!}
                                                    <span class="text-dark">
                                                        {{ $amenity?->amenity->title ?? 'N/A' }}
                                                    </span>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-12">
                            <p class="text-muted">No Data added yet.</p>
                        </div>
                        @endif
                        @endif
                        @php
                        $rating = $package?->detailsTabs
                        ->where('status', 1)
                        ->Where('package_tabs_id', 6)
                        ->first();
                        @endphp
                        @if (!empty($rating))
                        @if (count($ratingHeading) > 0)
                        <h3 class="text-blue mb-3">Rates:</h3>
                        <div class="section-rates p-3 rounded-3 dark-grey-bg mb-4" id="section-{{ $rating->id }}">
                            <div class="table-responsive mb-md-0 mb-3">
                                <table class="custom-table" cellspacing="10px" id="bestTimeToVisit">
                                    <tbody>

                                        <tr>
                                            <td colspan="{{ count($ratingHeading) + 1 }}"
                                                class="table-header p-3 bg-white border-1">
                                                <h3 class="text-blue fw-semibold m-0">Rates Info Per Person
                                                </h3>
                                            </td>
                                        </tr>


                                        <tr class="table-header p-2">
                                            <td class="p-3 bg-white border-1 fw-bold">Safari Type</td>
                                            @foreach ($ratingHeading as $heading)
                                            <td class="p-3 bg-white border-1 fw-bold">
                                                {{ $heading->heading_label }}</td>
                                            @endforeach
                                        </tr>

                                        @php
                                        $safariTypes = collect();
                                        foreach ($ratingHeading as $heading) {
                                        foreach ($heading->ratings as $rating) {
                                        $safariTypes->push($rating?->safariType?->safari_type);
                                        }
                                        }
                                        $safariTypes = $safariTypes->unique('id');
                                        @endphp

                                        @foreach ($safariTypes as $safariType)
                                        <tr>
                                            <td class="p-3 bg-white border-1 fw-normal">
                                                {{ $safariType?->name }}
                                            </td>
                                            @foreach ($ratingHeading as $heading)
                                            @php
                                            $rating = $heading->ratings->firstWhere(
                                            'safariType.safari_type.id',
                                            $safariType?->id,
                                            );
                                            @endphp
                                            <td class="p-3 bg-white border-1 fw-normal">
                                                Rs. {{ $rating->price ?? '-' }}
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        @endif
                        @endif

                        @php
                        $wahtToCarry = $package?->detailsTabs
                        ->where('status', 1)
                        ->Where('package_tabs_id', 7)
                        ->first();
                        @endphp
                        @if (!empty($wahtToCarry))
                        @if (count($thingsToCarries) > 0)
                        <h3 class="text-blue">Things to Carry</h3>
                        <div class="section-thing-to-carry p-3 rounded-3 dark-grey-bg mb-4"
                            id="section-{{ $wahtToCarry->id }}">
                            <div class="bg-white px-4 py-3 rounded-3">
                                <ul class="list-unstyled mb-0  package-lists ps-3">
                                    @foreach ($thingsToCarries as $thingsToCarry)
                                    <li class="mb-2">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                        <b>{{ $thingsToCarry->title ?? '' }}</b> -
                                        {{ $thingsToCarry->description ?? '' }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @endif

                        @php
                        $tabs = $package?->detailsTabs
                        ->where('status', 1)
                        ->WhereNotIn('package_tabs_id', [1, 2, 3, 4, 5, 6, 7, 8, 9]);
                        @endphp
                        @if (count($tabs) > 0)
                        @foreach ($tabs as $tab)
                        <div class="secion-faq mb-4 package-accordion" id="section-{{ $tab->id }}">
                            <h3 class="text-blue">{{ $tab->title }}</h3>
                            <div class="accordion p-3 rounded-3 dark-grey-bg" id="faqAccordion">
                                @php
                                $contant = $dynamicTabs
                                ->where('package_details_tabs_id', $tab->id)
                                ->first();
                                @endphp

                                @if (!empty($contant->short_description))
                                {!! $contant->short_description !!}
                                @else
                                <span>There is no Data</span>
                                @endif

                            </div>
                        </div>
                        @endforeach
                        @endif

                        @if (!empty($faqs))
                        <div class="secion-faq mb-4 package-accordion" id="section-{{ $package->park->id }}">
                            <h3 class="text-blue">FAQ's</h3>
                            <div class="accordion p-3 rounded-3 dark-grey-bg" id="faqAccordion">
                                @foreach ($faqs as $index => $faq)
                                @php
                                $question = $faq['question'] ?? '';
                                $answer = $faq['answer'] ?? '';
                                $collapseId = 'faq' . $index;
                                $headingId = 'heading' . $index;
                                @endphp

                                <div class="accordion-item mb-3 rounded-3">
                                    <h2 class="accordion-header rounded-top-3" id="{{ $headingId }}">
                                        <button
                                            class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }} rounded-top-3 rounded-bottom-0"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-controls="{{ $collapseId }}">
                                            {{ $question }}
                                        </button>
                                    </h2>
                                    <div id="{{ $collapseId }}"
                                        class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                        aria-labelledby="{{ $headingId }}" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body pt-0">
                                            <ul class="list-unstyled mb-0 package-lists">
                                                <li class="p-0">
                                                    {{ $answer }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>

                        </div>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="park-highlights">
                            <h3 class="text-blue text-center">Park Highlights</h3>
                            <div class="dark-grey-bg quick-info-box p-3 rounded-3 mb-4">
                                <!-- Quick Info -->
                                <div class="quickinfo-container mb-2">
                                    <h4 class="mb-1 pb-2 border-bottom border-accent d-flex gap-1">
                                        <svg class="me-1 d-inline-block align-middle" xmlns="http://www.w3.org/2000/svg"
                                            height="20px" viewBox="0 -960 960 960" width="20px" fill="#696868">
                                            <path
                                                d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Z">
                                            </path>
                                        </svg>Quick Info
                                    </h4>

                                    <ul class="mb-0 quickinfo-list">
                                        <li>
                                            <div class="d-flex align-items-baseline gap-2">
                                                <span class="fw-semibold text-dark text-nowrap"> Location: </span>
                                                <span class="text-dark">
                                                    {{ $package->park->name }},{{ $package->park->state->name }}
                                                </span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-baseline gap-2">
                                                <span class="fw-semibold text-dark text-nowrap">Area:</span>
                                                <span class="text-dark">{{ $package->park->area }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Wildlife -->
                                <div class="wildlife-container mb-2">
                                    <h4 class="mb-1 pb-1 border-bottom border-accent d-flex align-items-center gap-1">
                                        <svg class="me-1 d-inline-block align-middle mb-1"
                                            xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960"
                                            width="20px" fill="#696868">
                                            <path
                                                d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z">
                                            </path>
                                        </svg>
                                        Wildlife You May See
                                    </h4>

                                    @php
                                    $famousFor = $package?->park?->famous_for ?? '';
                                    $Wildlifes = array_filter(
                                    array_map('trim', explode(',', $famousFor)),
                                    );
                                    @endphp

                                    @if (count($Wildlifes) > 0)
                                    <ul class=" mb-0 quickinfo-list">
                                        @foreach ($Wildlifes as $Wildlife)
                                        <li>
                                            <div class="d-flex align-items-baseline gap-2">
                                                <span class="text-dark">{{ $Wildlife }}</span>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                <!-- Safari Zones -->
                                @if (!empty($package?->park?->core_zone) ||
                                !empty($package?->park?->buffer_zone))
                                <div class="zones-container mb-3">
                                    <h4 class="mb-1 pb-2 border-bottom border-accent d-flex align-items-center gap-1">
                                        <svg class="me-1 d-inline-block align-middle" xmlns="http://www.w3.org/2000/svg"
                                            height="20px" viewBox="0 -960 960 960" width="20px" fill="#696868">
                                            <path
                                                d="M480-304 304-480l176-176 176 176-176 176Zm56 199q-11 11-26 17t-30 6q-15 0-30-6t-26-17L105-424q-11-11-17-26t-6-30q0-15 6-30t17-26l318-318q12-12 26.5-18t30.5-6q16 0 30.5 6t26.5 18l318 318q11 11 17 26t6 30q0 15-6 30t-17 26L536-105Zm-56-87 288-288-288-288-288 288 288 288Z">
                                            </path>
                                        </svg>Safari Zones
                                    </h4>

                                    <ul class=" mb-0 quickinfo-list">
                                        @if (!empty($package?->park?->core_zone))
                                        <li>
                                            <div class="d-flex align-items-baseline gap-2">
                                                <span class="fw-semibold text-dark text-nowrap"> Core Zone: </span>
                                                <span class="text-dark">{{ $package->park->core_zone }}</span>
                                            </div>
                                        </li>
                                        @endif
                                        @if (!empty($package?->park?->buffer_zone))
                                        <li>
                                            <div class="d-flex align-items-baseline gap-2">
                                                <span class="fw-semibold text-dark text-nowrap"> Buffer Zone: </span>
                                                <span class="text-dark">{{ $package->park->buffer_zone }}</span>
                                            </div>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                @endif
                                <!-- Safari Options -->
                                <div class="zones-container mb-0">
                                    <h4 class="mb-1 pb-2 border-bottom border-accent d-flex align-items-center gap-1">
                                        <svg class="me-1 d-inline-block align-middle" xmlns="http://www.w3.org/2000/svg"
                                            height="20px" viewBox="0 -960 960 960" width="20px" fill="#696868">
                                            <path
                                                d="M240-200q-50 0-85-35t-35-85H40v-360q0-33 23.5-56.5T120-760h560l240 240v200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H360q0 50-35 85t-85 35Zm360-360h160L640-680h-40v120Zm-240 0h160v-120H360v120Zm-240 0h160v-120H120v120Zm120 290q21 0 35.5-14.5T290-320q0-21-14.5-35.5T240-370q-21 0-35.5 14.5T190-320q0 21 14.5 35.5T240-270Zm480 0q21 0 35.5-14.5T770-320q0-21-14.5-35.5T720-370q-21 0-35.5 14.5T670-320q0 21 14.5 35.5T720-270ZM120-400h32q17-18 39-29t49-11q27 0 49 11t39 29h304q17-18 39-29t49-11q27 0 49 11t39 29h32v-80H120v80Zm720-80H120h720Z">
                                            </path>
                                        </svg>
                                        Safari Options
                                    </h4>

                                    <ul class=" mb-0 quickinfo-list">
                                        @if (!empty($package->park->parkSafariTypes))
                                        <li>
                                            <div class="d-flex align-items-baseline gap-2">
                                                <span class="fw-semibold text-dark text-nowrap"> Safari Types: </span>
                                                <span class="text-dark">
                                                    {{
                                                    collect($package->park->parkSafariTypes)->pluck('safari_type.name')->unique()->implode(',
                                                    ') }}
                                                </span>
                                            </div>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
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
        </section>
        @if ($showReportModal)
        <!-- Report Modal -->
        <div class="modal fade  show d-block" tabindex="-1" style="display:block; background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Report Discussion</h6>
                        <button type="button" class="btn-close" wire:click="$set('showReportModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="resion" class="form-label">Select Reason <span
                                    class="text-danger">*</span></label>
                            <select wire:model="selectedResion" class="form-select">
                                <option value="">-- Choose Reason --</option>
                                @foreach ($reportResions as $resion)
                                <option value="{{ $resion->id }}">{{ $resion->title }}</option>
                                @endforeach
                            </select>
                            @error('selectedResion')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (optional)</label>
                            <textarea wire:model.defer="notes" class="form-control" rows="3"
                                placeholder="Add any additional info..."></textarea>
                            @error('notes')
                            <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm"
                            wire:click="$set('showReportModal', false)">Cancel</button>
                        <button class="btn btn-primary btn-sm" wire:click="submitReport">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if (count($similarPackages) > 0)
        <section id="similar-packages" wire:ignore>
            <div class="container-lg container-inner-padding px-1">
                <div class="heading-text text-center mb-xl-4 mb-3">
                    <div class="">
                        <h2 class="mb-0 text-accent">Similar Packages</h2>
                        <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                            class="vector-border-bottom">
                    </div>
                </div>

                <div class="owl-carousel owl-theme" id="similar-packages-owl">
                    @foreach ($similarPackages as $similarPackage)
                    <div class="item">
                        <div class="owl-slide text-start mx-auto">
                            <div class="join-safari-card-box mb-3 px-sm-2 rounded-3">
                                <div class="card rounded-3">
                                    <!-- Card Image -->
                                    <img class="card-img-top rounded-top-3"
                                        src="{{ asset($similarPackage->display_image) }}" alt="Card image">
                                    <!-- Card Body -->
                                    <div class="card-body p-0">
                                        <div class="card-body-inner border-bottom">
                                            <div class="card-title border-bottom pb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h4 class="mb-0 card-text">
                                                        {{ $similarPackage->title }}
                                                    </h4>
                                                    <div class="count-days px-2 rounded-1">
                                                        <span class="text-white">{{ $similarPackage->end_tour }}N/{{
                                                            $similarPackage->start_tour }}D</span>
                                                    </div>
                                                </div>
                                                <div class="cityplace-text">
                                                    <span>
                                                        {{ $similarPackage->park->name }},{{
                                                        $similarPackage->park->state->name }}</span>
                                                </div>
                                            </div>
                                            <div class="card-text knowfor-list-home">
                                                <!-- Highlights partition -->
                                                <div>
                                                    <ul
                                                        class="highlights highlights-grid knowfor-list ps-0 d-flex flex-wrap align-items-center">
                                                        @php
                                                        $inclusionList = App\Helpers\UserHelper::inclusionList(
                                                        $similarPackage->tour_highlights,
                                                        );
                                                        @endphp
                                                        @if (count($inclusionList) > 0)
                                                        @foreach ($inclusionList as $list)
                                                        <li
                                                            class="card-list-text d-flex align-items-center gap-1 mb-md-0 mb-0">
                                                            @php
                                                            $iconWithSize = str_replace(
                                                            '<i', '<i style="font-size: 10px;"' , $list->icon,
                                                                );
                                                                @endphp
                                                                {!! $iconWithSize !!}
                                                                <p class="mb-0 text-truncate">
                                                                    {{ $list->title }}</p>
                                                        </li>
                                                        @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                                <!-- Known for partition -->
                                                <div class="knowfor-list mt-1 mb-1">
                                                    <h6 class="mb-0">Known For:</h6>
                                                </div>
                                                <ul
                                                    class="highlights highlights-grid knowfor-list ps-0 d-flex flex-wrap align-items-center">
                                                    @php
                                                    $wildlife = $similarPackage?->park?->wildlife ?? [];
                                                    @endphp
                                                    @if (count($wildlife) > 0)
                                                    @foreach ($wildlife as $list)
                                                    <li
                                                        class="card-list-text d-flex align-items-center gap-1 mb-md-0 mb-0">
                                                        <i class="fa fa-circle" style="font-size: 6px;"
                                                            aria-hidden="true"></i>
                                                        <p class="mb-0 text-truncate">
                                                            {{ $list->species->name }}</p>
                                                    </li>
                                                    @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex align-items-center justify-content-between card-body-inner py-2 price-container flex-wrap">
                                            <div class="starting-price">
                                                <p class="mb-0">Starting Price:</p>
                                                <span class="mb-0 text-muted">₹ {{ $similarPackage->min_price_pp ?? 'NA'
                                                    }}

                                                    per person</span>
                                            </div>
                                            <a href="{{ route('safari-package.detail', $similarPackage->slug) }}"
                                                class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">View
                                                Details</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </main>
</div>
@push('scripts')
@if (!empty($faqs) && $faqs->count() > 0)
<script type="application/ld+json">
    {!! json_encode([
                "@context" => "https://schema.org",
                "@type" => "FAQPage",
                "mainEntity" => $faqs->map(function($faq){
                    return [
                        "@type" => "Question",
                        "name" => $faq->question,
                        "acceptedAnswer" => [
                            "@type" => "Answer",
                            "text" => $faq->answer,
                        ],
                    ];
                })->toArray(),
            ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@endif

{{-- <script>
    // owl-carousel top safari parks
        $(document).ready(function() {
            if ($('#similar-packages-owl.owl-carousel .item').length <= 3) {
                $('#similar-packages-owl.owl-carousel').addClass('no-carousel');
            }
            $('#similar-packages-owl.owl-carousel').owlCarousel({
                loop: true,
                rewind: true,
                autoplay: true,
                 margin: 10,
                width: 386,
                nav: false,
                dots: true,
                smartSpeed: 600,
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 2
                    },
                    900: {
                        items: 2.5
                    },
                    992: {
                        items: 3
                    }
                }
            });
        });
</script> --}}

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

            const component = Livewire.find(
                document.querySelector('[wire\\:id]').getAttribute('wire:id')
            );

            component.set('activeTab', tab);
            if (subtab) {
                component.set('overviewActiveTabData', subtabId);
                component.set('overviewActiveTab', subtab);
            }
        }
</script>
@endpush
