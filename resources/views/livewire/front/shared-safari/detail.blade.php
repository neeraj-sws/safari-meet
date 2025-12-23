<div>
    @php
    use App\Helpers\UserHelper;
    use Illuminate\Support\Facades\Auth;
    @endphp
    <main>

        @php
        use Illuminate\Support\Carbon;
        $start = Carbon::parse($shareSafari->day);
        $end = Carbon::parse($shareSafari->night);

        $startFormatted = $start->format('j-M-Y');
        $endFormatted = $end->format('j-M-Y');

        $nights = $start->diffInDays($end);
        $days = $nights + 1;
        @endphp
        <style>
            .discussion-item img {
                object-fit: cover;
            }

            .discussion-item .border-start {
                border-color: #e0e0e0 !important;
            }

            .discussion-thread {
                max-height: 600px;
                overflow-y: auto;
            }

            .park-highlights-wrapper {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            /* Default: Interested box BELOW */
            .park-highlights-wrapper .guest-reviews-section {
                order: 2;
            }

            .park-highlights-wrapper .park-highlights-content {
                order: 1;
            }

        </style>
        <section id="package-carousel-section" wire:ignore>
            <!-- <div class="container-fluid container--padding"> -->
            <!-- <div class="row"> -->
            <div class="pe-md-0">
                <div class="guest-carousel-wrapper position-relative">

                    <div class="carousel-text position-absolute text-white text-center w-100">
                        <h2>{{ $nights }} Night / {{ $days }} Days Stay -
                            {{ $shareSafari->title }}</h2>
                    </div>

                    <div class="slick-slider slick-hero" id="package-detail-slider">
                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="carousel-image">
                                    <img src="{{ asset('front-assets/images/carousel-images/carousel-1.jpg') }}"
                                        alt="Carousel-1" class="img-fluid rounded-0">
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="carousel-image">
                                    <img src="{{ asset('front-assets/images/carousel-images/carousel-2.jpg') }}"
                                        alt="Carousel-2" class="img-fluid rounded-0">
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="carousel-image">
                                    <img src="{{ asset('front-assets/images/carousel-images/carousel-3.jpg') }}"
                                        alt="Carousel-3" class="img-fluid rounded-0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="general-info" class="grey-bg py-5">
            <div class="container-lg container-inner-padding">
                <div class="row gx-3 align-items-center">
                    <div class="col-lg-3">
                        <div class="general-info-img text-md-start text-center mb-lg-0 mb-3">
                            @if (!empty($shareSafari->display_image))
                            <img class="card-img-top rounded-top-3" style="width:100%; height:220px; object-fit:cover;"
                                src="{{ asset($shareSafari->display_image) }}" alt="Card image">
                            @else
                            <img class="card-img-top rounded-top-3" style="width:100%; height:220px; object-fit:cover;"
                                src="{{ asset('assets/images/GPT-1.png') }}" alt="Card image">
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="general-info-list border-start ps-2 border-primary mb-md-0 mb-3">
                            <ul class="list-unstyled mb-0  package-lists ps-3">
                                <li class="mb-2">
                                    <div class="d-flex align-items-start flex-nowrap mb-3">
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M480-80q-106 0-173-33.5T240-200q0-24 14.5-44.5T295-280l63 59q-9 4-19.5 9T322-200q13 16 60 28t98 12q51 0 98.5-12t60.5-28q-7-8-18-13t-21-9l62-60q28 16 43 36.5t15 45.5q0 53-67 86.5T480-80Zm1-220q99-73 149-146.5T680-594q0-102-65-154t-135-52q-70 0-135 52t-65 154q0 67 49 139.5T481-300Zm-1 100Q339-304 269.5-402T200-594q0-71 25.5-124.5T291-808q40-36 90-54t99-18q49 0 99 18t90 54q40 36 65.5 89.5T760-594q0 94-69.5 192T480-200Zm0-320q33 0 56.5-23.5T560-600q0-33-23.5-56.5T480-680q-33 0-56.5 23.5T400-600q0 33 23.5 56.5T480-520Zm0-80Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Destination:</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">
                                            {{ $shareSafari->park->name }},{{ $shareSafari->park->state->name }}
                                        </p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-nowrap mb-3">
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M200-640h560v-80H200v80Zm0 0v-80 80Zm0 560q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v227q-19-9-39-15t-41-9v-43H200v400h252q7 22 16.5 42T491-80H200Zm520 40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Zm67-105 28-28-75-75v-112h-40v128l87 87Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Duration:</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">{{ $nights }} Nights /
                                            {{ $days }} Days</p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-nowrap mb-3">
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M200-640h560v-80H200v80Zm0 0v-80 80Zm0 560q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v227q-19-9-39-15t-41-9v-43H200v400h252q7 22 16.5 42T491-80H200Zm520 40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Zm67-105 28-28-75-75v-112h-40v128l87 87Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Date:</p>
                                        </div>

                                        <p class="mb-0 list-paragraph text-dark">
                                            {{ $startFormatted }} to {{ $endFormatted }}
                                        </p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-nowrap mb-3">
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M240-200q-50 0-85-35t-35-85H40v-360q0-33 23.5-56.5T120-760h560l240 240v200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H360q0 50-35 85t-85 35Zm360-360h160L640-680h-40v120Zm-240 0h160v-120H360v120Zm-240 0h160v-120H120v120Zm120 290q21 0 35.5-14.5T290-320q0-21-14.5-35.5T240-370q-21 0-35.5 14.5T190-320q0 21 14.5 35.5T240-270Zm480 0q21 0 35.5-14.5T770-320q0-21-14.5-35.5T720-370q-21 0-35.5 14.5T670-320q0 21 14.5 35.5T720-270ZM120-400h32q17-18 39-29t49-11q27 0 49 11t39 29h304q17-18 39-29t49-11q27 0 49 11t39 29h32v-80H120v80Zm720-80H120h720Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Safari Type:</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">{{ $types }}
                                        </p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-nowrap mb-3">
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M531-260h96v-3L462-438l1-3h10q54 0 89.5-33t43.5-77h40v-47h-41q-3-15-10.5-28.5T576-653h70v-47H314v57h156q26 0 42.5 13t22.5 32H314v47h222q-6 20-23 34.5T467-502H367v64l164 178ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Starting Price:</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">₹{{ $shareSafari->min_price_pp }} To
                                            ₹{{ $shareSafari->max_price_pp }} per person</p>
                                    </div>
                                </li>
                                @php
                                $BestTime = $shareSafari?->park?->parkBestTimes
                                ? $shareSafari?->park?->parkBestTimes
                                ?->pluck('weather.title')
                                ->filter()
                                ->implode(', ')
                                : 'Null';
                                @endphp
                                @if (!empty($BestTime))
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-nowrap mb-3">
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M680-120q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Zm-30-280v-80h60v80h-60Zm0 400v-80h60V0h-60Zm165-333-43-42 57-57 42 43-56 56ZM531-49l-42-42 57-57 42 42-57 57Zm309-161v-60h80v60h-80Zm-400 0v-60h80v60h-80ZM829-49l-56-57 42-42 57 56-43 43ZM545-332l-56-57 42-42 57 56-43 43ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v160H200v400h160v80H200Zm0-560h560v-80H200v80Zm0 0v-80 80Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Best Time: </p>
                                        </div>


                                        <p class="mb-0 list-paragraph text-dark">
                                            {{ $BestTime }}
                                        </p>
                                    </div>
                                </li>
                                @endif
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-nowrap mb-3">
                                        <div class="d-flex align-items-center flex-nowrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M240-200q-50 0-85-35t-35-85H40v-360q0-33 23.5-56.5T120-760h560l240 240v200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H360q0 50-35 85t-85 35Zm360-360h160L640-680h-40v120Zm-240 0h160v-120H360v120Zm-240 0h160v-120H120v120Zm120 290q21 0 35.5-14.5T290-320q0-21-14.5-35.5T240-370q-21 0-35.5 14.5T190-320q0 21 14.5 35.5T240-270Zm480 0q21 0 35.5-14.5T770-320q0-21-14.5-35.5T720-370q-21 0-35.5 14.5T670-320q0 21 14.5 35.5T720-270ZM120-400h32q17-18 39-29t49-11q27 0 49 11t39 29h304q17-18 39-29t49-11q27 0 49 11t39 29h32v-80H120v80Zm720-80H120h720Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2 text-nowrap">Availavble Seat: </p>
                                        </div>
                                        @php
                                        $allottedSeatCount = $shareSafari->allottedSeat->sum('number_of_seat');
                                        $totalSeat = $shareSafari->share_seats - $allottedSeatCount;
                                        @endphp
                                        <p class="mb-0 list-paragraph text-dark">
                                            {{ $totalSeat }}
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 ms-md-auto my-auto">
                        <div class="d-flex align-items-center flex-nowrap gap-2 mb-3 justify-content-sm-start justify-content-center">
                            {{-- <a href="https://safari-meet.codelive.info/package-detail.html"
                                class="btn btn-sm btn-primary blue-btn-hover border-blue blue-border-hover rounded-1">Enquire
                                Now</a> --}}
                            @auth
                            @php
                            $joinedSafari = $shareSafari->joinedsafari
                            ->where('user_id', Auth::guard('web')->user()?->id)
                            ->first();
                            @endphp

                            @if ($shareSafari->organized_type != 'admin' && $shareSafari->organized_by ==
                            Auth::guard('web')->user()?->id)
                            @if (count($interestedUsers) == 0)
                            <a href="{{ route('edit.saharedshafari', ['slug' => $shareSafari->slug, 'type' => 'basic-info']) }}"
                                class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">Edit</a>
                            @endif
                            @else
                            @if (!empty($joinedSafari))
                            @php
                            $userSeat = '';
                            @endphp
                            @if (!empty($totalallottedSeats))
                            @php
                            $userSeat = $totalallottedSeats
                            ->where('user_id', Auth::guard('web')->id())
                            ->first();

                            @endphp
                            @endif
                            @if (empty($userSeat))
                            <a wire:click="confirmdeletejoinsafari({{ $joinedSafari->id }})"
                                id="leave_safari_{{ $shareSafari->id }}"
                                class="btn btn-sm border border-blue blue-border-hover blue-text-hover border-2 rounded-1">
                                Leave Shared Safari
                            </a>
                            @endif
                            @else
                            @php
                            $allottedSeatCount = $shareSafari->allottedSeat->sum('number_of_seat');
                            $totalSeat = $shareSafari->share_seats - $allottedSeatCount;
                            @endphp
                            @if ($totalSeat > 0)
                            <a wire:click="joinsafari({{ $shareSafari->id }})" id="join_safari_{{ $shareSafari->id }}"
                                class="btn btn-sm border border-blue blue-border-hover blue-text-hover border-2 rounded-1">
                                Join Shared Safari
                            </a>
                            @else
                            <a id="join_safari_{{ $shareSafari->id }}"
                                class="btn btn-sm border border-blue blue-border-hover blue-text-hover border-2 rounded-1"
                                title="Seat Not Available" disabled>
                                Seat Not Available
                            </a>
                            @endif
                            @endif
                            @endif
                            <a href="javascript:void(0)" wire:click="addwishlist({{ $shareSafari->id }})"
                                class="btn btn-sm border border-blue blue-border-hover blue-text-hover border-2 rounded-1">{{
                                $wishlistTitle }}</a>
                            @endauth
                            @guest
                            <a href="{{ route('login') }}"
                                class="btn btn-sm border border-blue blue-border-hover blue-text-hover border-2 rounded-1">
                                Join Now
                            </a>
                            @endguest
                        </div>
                        <div class="organizer-name d-flex align-items-center gap-2">
                            <livewire:front.common.interested-people :userList="$organizer" :usertype="$type"
                                :key="'interested-people-' . $organizer" />
                            <div class="d-flex align-items-center ms-2 flex-nowrap">
                                <span class="small me-2">Organized by:</span>
                                <strong class="flex-nowrap">
                                    {{ $organizer?->name ?? 'Null' }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if (count($shareSafari?->detailsTabs->where('status', 1)) > 0)
        <section id="package-details-nav" class="mb-4 border-bottom">
            <div class="container-lg container-inner-padding">
                <nav class="overflow-auto mb-2">
                    <ul class="navbar-nav flex-row flex-nowrap gap-3" id="packageDetailNav"
                        style="white-space: nowrap;">
                        @php
                        $tabs = $shareSafari?->detailsTabs->where('status', 1)->sortBy('shared_safari_tabs_id');
                        @endphp

                        @foreach ($tabs as $tab)
                        @if ($tab->shared_safari_tabs_id != 5)
                        <li class="nav-item">
                            <a class="nav-link pb-0 ps-0 fw-semibold" wire:click="$set('showChatBox', false)"
                                href="#section-{{ $tab->id }}">{{ $tab->title }}</a>
                        </li>
                        @endif

                        @if ($tab->shared_safari_tabs_id == 5)
                        @if (!empty($faqs))
                        <li class="nav-item">
                            <a class="nav-link pb-0 ps-0 fw-semibold" wire:click="$set('showChatBox', false)"
                                href="#section-{{ $shareSafari->park->id }}"> FAQ's </a>
                        </li>
                        @endif
                        @if (
                        !empty($joinededSafariSafri) ||
                        ($shareSafari->organized_by == Auth::guard('web')->id() && $shareSafari->organized_type !=
                        'admin'))
                        <li class="nav-item">
                            <a class="nav-link pb-0 ps-0 fw-semibold" wire:click="$set('showChatBox', false)"
                                href="#section-{{ $tab->id }}">{{ $tab->title }}</a>
                        </li>
                        @endif
                        @endif
                        @endforeach

                        @auth('web')
                        @if ($shareSafari->organized_by == Auth::guard('web')->id() && $shareSafari->organized_type !=
                        'admin')
                        <li class="nav-item">
                            <a class="nav-link pb-0 ps-0 fw-semibold" wire:click="ShowChatBox()"
                                href="javascript:void(0)">
                                Personal Chat
                            </a>
                        </li>
                        @else
                        @if (!empty($joinededSafariSafri))
                        <li class="nav-item">
                            <a class="nav-link pb-0 ps-0 fw-semibold" wire:click="ShowChatBox()"
                                href="javascript:void(0)">
                                Personal Chat
                            </a>
                        </li>
                        @endif
                        @endif
                        @endauth
                    </ul>
                </nav>
            </div>
        </section>
        @endif

        <section id="package-details" class="mb-sm-5 mb-4">
            <div class="container-lg container-inner-padding">
                <div class="row">
                    @if ($showChatBox)
                    @if ($shareSafari->organized_by == Auth::guard('web')->id() && $shareSafari->organized_type !=
                    'admin')
                    {{--
                    <livewire:front.common.one-to-one-chat-box-organizer :shared="$shareSafari"
                        :key="'organizerchatbox'" /> --}}
                    <livewire:front.common.chat-box :shared="$shareSafari" :creator="true" :key="'organizerchatbox'" />
                    @else
                    <livewire:front.common.chat-box :shared="$shareSafari" :participant="$conversation->id"
                        :key="'OneToOneChat'" />

                    {{--
                    <livewire:front.common.one-to-one-chat-box :shared="$shareSafari" :key="'OneToOneChat'" /> --}}
                    @endif
                    @else
                    @if (count($shareSafari?->detailsTabs->where('status', 1)) > 0)
                    <div class="col-lg-8">
                        @php
                        $inclusions = $shareSafari?->detailsTabs
                        ->where('status', 1)
                        ->Where('shared_safari_tabs_id', 1)
                        ->first();
                        @endphp
                        @if (!empty($inclusions))
                        <h3 class="text-blue">Inclusions</h3>
                        <div class="section-inclusions p-3 rounded-3 dark-grey-bg mb-4"
                            id="section-{{ $inclusions->id }}">
                            <div class="bg-white px-4 py-3 rounded-3">
                                <ul class="list-unstyled mb-0  package-lists">
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
                        @php
                        $exclusions = $shareSafari?->detailsTabs
                        ->where('status', 1)
                        ->Where('shared_safari_tabs_id', 2)
                        ->first();
                        @endphp
                        @if (!empty($exclusions))
                        <h3 class="text-blue">Exclusions</h3>
                        <div class="section-exclusions p-3 rounded-3 dark-grey-bg mb-4"
                            id="section-{{ $exclusions->id }}">
                            <div class="bg-white px-4 py-3 rounded-3">
                                <ul class="list-unstyled mb-0  package-lists">
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

                        @php
                        $wahtToCarry = $shareSafari?->detailsTabs
                        ->where('status', 1)
                        ->Where('shared_safari_tabs_id', 3)
                        ->first();
                        @endphp
                        @if (!empty($wahtToCarry))
                        <h3 class="text-blue">Things to Carry</h3>
                        <div class="section-thing-to-carry p-3 rounded-3 dark-grey-bg mb-4"
                            id="section-{{ $wahtToCarry->id }}">
                            <div class="bg-white px-4 py-3 rounded-3">
                                <ul class="list-unstyled mb-0  package-lists">
                                    @foreach ($thingsToCarries as $thingsToCarry)
                                    <li class="mb-2">
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                        <b>{{ $thingsToCarry->title ?? '' }}</b>: <br>
                                        {{ $thingsToCarry->description ?? '' }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        @if (!empty($faqs))
                        <div class="secion-faq mb-4 package-accordion" id="section-{{ $shareSafari->park->id }}">
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
                        @php
                        $tabs = $shareSafari?->detailsTabs
                        ->where('status', 1)
                        ->WhereNotIn('shared_safari_tabs_id', [1, 2, 3, 4, 5]);

                        @endphp
                        @if (count($tabs) > 0)
                        @foreach ($tabs as $tab)
                        <div class="secion-faq mb-4 package-accordion" id="section-{{ $tab->id }}">
                            <h3 class="text-blue">{{ $tab->title }}</h3>
                            <div class="accordion p-3 rounded-3 dark-grey-bg" id="faqAccordion">
                                @php
                                $contant = $dynamicTabs
                                ->where('shared_shafari_details_tabs_id', $tab->id)
                                ->first();
                                @endphp
                                @if ($contant)
                                {!! $contant->short_description !!}
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="col-lg-4">
                        @php
                        $visibleUsers = $userCountList->take(10);
                        $extraCount = $userCountList->count() - $visibleUsers->count();
                        @endphp
                        <div
                            class="park-highlights park-highlights-wrapper
                                    {{ auth()->check() && in_array($shareSafari->organized_type, ['user', 'agent']) && (isset($visibleUsers) && $visibleUsers->count() > 0) && $shareSafari->organized_by === auth()->id() ? 'user-owned mt-4' : '' }}">


                            @if ($userCountList->count() > 0)
                            <div class="guest-reviews-section">
                                <div class="card" style="cursor: pointer;">
                                    <div class="card-header" wire:click="showUserLists()">
                                        <i class="fa-solid fa-users"></i>
                                        Interested - {{ $userCountList->count() }}
                                    </div>

                                    <div class="card-body">
                                        <div class="users_profile d-flex gap-2 align-items-center flex-wrap"
                                            wire:click="showUserLists()">
                                            @foreach ($visibleUsers as $interestedUser)
                                            <livewire:front.common.interested-people :userList="$interestedUser?->user"
                                                :key="'interested-people-' .
                                                                    $interestedUser->user_id" />
                                            @endforeach
                                            @if ($extraCount > 0)
                                            <div class="profileavtar d-flex justify-content-center align-items-center rounded-circle bg-secondary text-white fw-bold"
                                                style="width: 40px; height: 40px;">
                                                +{{ $extraCount }}
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="park-highlights-content">
                                <h3 class="text-blue text-center">Park Highlights</h3>
                                <div class="dark-grey-bg quick-info-box p-3 rounded-3 mb-4">
                                    <!-- Quick Info -->
                                    <div class="quickinfo-container mb-2">
                                        <h4
                                            class="mb-1 pb-2 border-bottom border-accent d-flex gap-1">
                                            <svg class="me-1 d-inline-block align-middle" xmlns="http://www.w3.org/2000/svg" height="20px"
                                                viewBox="0 -960 960 960" width="20px" fill="#696868">
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
                                                        {{ $shareSafari->park->name }},
                                                        {{ $shareSafari->park->state->name }}
                                                    </span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex align-items-baseline gap-2">
                                                    <span class="fw-semibold text-dark text-nowrap">Area:</span>
                                                    <span class="text-dark">{{ $shareSafari->park->area }}</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Wildlife -->
                                    <div class="wildlife-container mb-2">
                                        <h4
                                            class="mb-1 pb-1 border-bottom border-accent d-flex align-items-center gap-1">
                                            <svg class="me-1 d-inline-block align-middle mb-1" xmlns="http://www.w3.org/2000/svg" height="20px"
                                                viewBox="0 -960 960 960" width="20px" fill="#696868">
                                                <path
                                                    d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z">
                                                </path>
                                            </svg>
                                            Wildlife You May See
                                        </h4>

                                        @php
                                        $famousFor = $shareSafari?->park?->famous_for ?? '';
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
                                    @if (!empty($shareSafari?->park?->core_zone) ||
                                    !empty($shareSafari?->park?->buffer_zone))
                                    <div class="zones-container mb-3">
                                        <h4
                                            class="mb-1 pb-2 border-bottom border-accent d-flex align-items-center gap-1">
                                            <svg class="me-1 d-inline-block align-middle" xmlns="http://www.w3.org/2000/svg" height="20px"
                                                viewBox="0 -960 960 960" width="20px" fill="#696868">
                                                <path
                                                    d="M480-304 304-480l176-176 176 176-176 176Zm56 199q-11 11-26 17t-30 6q-15 0-30-6t-26-17L105-424q-11-11-17-26t-6-30q0-15 6-30t17-26l318-318q12-12 26.5-18t30.5-6q16 0 30.5 6t26.5 18l318 318q11 11 17 26t6 30q0 15-6 30t-17 26L536-105Zm-56-87 288-288-288-288-288 288 288 288Z">
                                                </path>
                                            </svg>Safari Zones
                                        </h4>

                                        <ul class=" mb-0 quickinfo-list">
                                            @if (!empty($shareSafari?->park?->core_zone))
                                            <li>
                                                <div class="d-flex align-items-baseline gap-2">
                                                    <span class="fw-semibold text-dark text-nowrap"> Core Zone: </span>
                                                    <span class="text-dark">{{ $shareSafari->park->core_zone }}</span>
                                                </div>
                                            </li>
                                            @endif
                                            @if (!empty($shareSafari?->park?->buffer_zone))
                                            <li>
                                                <div class="d-flex align-items-baseline gap-2">
                                                    <span class="fw-semibold text-dark text-nowrap">Buffer Zone:</span>
                                                    <span class="text-dark">{{ $shareSafari->park->buffer_zone }}</span>
                                                </div>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                    @endif
                                    <!-- Safari Options -->
                                    <div class="zones-container mb-0">
                                        <h4
                                            class="mb-1 pb-2 border-bottom border-accent d-flex align-items-center gap-1">
                                            <svg class="me-1 d-inline-block align-middle" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#696868">
                                                <path d="M240-200q-50 0-85-35t-35-85H40v-360q0-33 23.5-56.5T120-760h560l240 240v200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H360q0 50-35 85t-85 35Zm360-360h160L640-680h-40v120Zm-240 0h160v-120H360v120Zm-240 0h160v-120H120v120Zm120 290q21 0 35.5-14.5T290-320q0-21-14.5-35.5T240-370q-21 0-35.5 14.5T190-320q0 21 14.5 35.5T240-270Zm480 0q21 0 35.5-14.5T770-320q0-21-14.5-35.5T720-370q-21 0-35.5 14.5T670-320q0 21 14.5 35.5T720-270ZM120-400h32q17-18 39-29t49-11q27 0 49 11t39 29h304q17-18 39-29t49-11q27 0 49 11t39 29h32v-80H120v80Zm720-80H120h720Z">
                                                </path>
                                            </svg>
                                            Safari Options
                                        </h4>

                                        <ul class=" mb-0 quickinfo-list">
                                            @if (!empty($shareSafari->park->parkSafariTypes))
                                            <li>
                                                <div class="d-flex align-items-baseline gap-2">
                                                    <span class="fw-semibold text-dark"><b> Safari Types: </b></span>
                                                    <span class="text-dark">
                                                        {{
                                                        collect($shareSafari->park->parkSafariTypes)->pluck('safari_type.name')->unique()->implode(',
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
                    </div>
                    @if (
                    !empty($joinededSafariSafri) ||
                    ($shareSafari->organized_by == Auth::guard('web')->id() && $shareSafari->organized_type != 'admin'))
                    <div class="col-12 mt-2">
                        @php
                        $discussionModel = $shareSafari?->detailsTabs
                        ->where('status', 1)
                        ->Where('shared_safari_tabs_id', 5)
                        ->first();
                        @endphp
                        @if (!empty($discussionModel))
                        <div class="section-discussions p-3 rounded-3 bg-light mb-4">
                            <div class="bg-white shadow-sm rounded-3 p-4">
                                <h4 class="text-primary fw-bold mb-4">💬 Group Discussion</h4>

                                <!-- Discussion Thread -->
                                <div class="discussion-thread">
                                    @forelse ($discussions as $discussion)
                                    @include('livewire.partials.discussion-item', [
                                    'discussion' => $discussion,
                                    'level' => 1,
                                    ])
                                    @empty
                                    <p class="text-muted">No discussions yet. Be the first to
                                        comment!
                                    </p>
                                    @endforelse
                                </div>

                                <!-- Comment Box -->
                                <div class="mt-4 border-top pt-3">
                                    <form wire:submit.prevent="save({{ $replyBox ?? 'null' }})">
                                        @if ($replyBox)
                                        @php
                                        $parent =
                                        $discussions->find($replyBox) ??
                                        \App\Models\SafariDiscussion::with([
                                        'user',
                                        'admin',
                                        ])->find($replyBox);
                                        @endphp
                                        @if ($parent)
                                        <div
                                            class="reply-preview bg-light p-2 rounded mb-2 d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="fw-bold">{{ $parent->is_admin ? $parent->admin->name ??
                                                    'Admin' : $parent->user->name ?? 'User' }}</small>
                                                <p class="mb-0 text-muted small">
                                                    {{ Str::limit($parent->content, 80) }}</p>
                                            </div>
                                            <button type="button" wire:click="$set('replyBox', null)"
                                                class="btn-close btn-sm"></button>
                                        </div>
                                        @endif
                                        @endif

                                        @if ($replyBox)
                                        <textarea wire:key="reply-textarea-{{ $replyBox }}"
                                            wire:model="replyContent.{{ $replyBox }}" class="form-control mb-2" rows="3"
                                            placeholder="Write a reply..."></textarea>
                                        @else
                                        <textarea wire:key="main-textarea" wire:model="content"
                                            class="form-control mb-2" rows="3"
                                            placeholder="Write a comment..."></textarea>
                                        @endif

                                        @error('content')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @if ($replyBox && isset($replyContent[$replyBox]))
                                        @error('replyContent.' . $replyBox)
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @endif

                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <small class="text-muted">Your comment will be visible to
                                                everyone viewing this safari.</small>
                                            @auth('web')
                                            <button type="submit"
                                                class="btn btn-sm btn-primary rounded-pill px-4 mt-2 {{ $shareSafari->is_approved == 0 ? 'disabled' : '' }}">
                                                <i class="fa fa-paper-plane me-1"></i> Post Comment
                                            </button>
                                            @endauth
                                            @guest
                                            <a href="{{ route('login') }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-4 mt-2">
                                                Login to Comment
                                            </a>
                                            @endguest
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    @else
                    <div class="text-center">
                        <img src="{{ asset('front-assets/images/cat-with-magnifying-glass-illustration-svg-png-download-11511372.png') }}"
                            class="freepikimg" style="width:350px;">
                        <h6>Data Not Found</h6>
                    </div>
                    @endif
                    @endif


                </div>
            </div>
        </section>
        <!-- Report Modal -->
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

        @if ($showUsersList)
        <div class="modal fade show" id="exampleExtraLargeModal" tabindex="-1" style="display: block;" aria-modal="true"
            role="dialog">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Interested List</h5>
                        <button type="button" class="btn-close" wire:click="closeUserLists" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Join At</th>
                                        @auth('web')
                                        @if ($shareSafari->organized_by == Auth::guard('web')->id() &&
                                        $shareSafari->organized_type != 'admin')
                                        <th>Seat</th>
                                        @endif
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($interestedUsers as $index => $interestedUser)
                                    <tr>
                                        <td>{{ $interestedUsers->total() - ($interestedUsers->firstItem() + $index) + 1
                                            }}
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <livewire:front.common.interested-people
                                                    :userList="$interestedUser?->user" :key="$index" />

                                                <span class="ms-2">
                                                    {{ $interestedUser->user->name }}
                                                </span>

                                            </div>

                                        </td>
                                        <td>
                                            {{ $interestedUser->created_at->format('M-d-Y') }}
                                            @auth('web')
                                            @if (!empty($totalallottedSeats))
                                            @php
                                            $userSeat = $totalallottedSeats
                                            ->where('user_id', $interestedUser->user->user_id)
                                            ->first();

                                            @endphp
                                            @if (!empty($userSeat) && $userSeat->user_id == Auth::guard('web')->id())
                                            <span class="badge rounded-pill text-bg-secondary"
                                                style="cursor: pointer;">{{ $userSeat->number_of_seat }}
                                            </span>
                                            <span class="badge rounded-pill text-bg-secondary" style="cursor: pointer;">
                                                Seat Allotted</span>
                                            @endif
                                            @endif
                                            @endauth
                                        </td>
                                        @auth('web')
                                        @if ($shareSafari->organized_by == Auth::guard('web')->id() &&
                                        $shareSafari->organized_type != 'admin')
                                        <td>
                                            @php
                                            $userSeat = $totalallottedSeats
                                            ?->where('user_id', $interestedUser->user->user_id)
                                            ?->first();
                                            @endphp

                                            @if ($selectedUserId === $interestedUser->user->user_id && $allotSlot)
                                            <div class="mb-3">
                                                <label for="" class="form-label">Seat</label>
                                                <input type="number" class="form-control" wire:model="seat_number"
                                                    min="1" />
                                                <button
                                                    wire:click="submitAllotedSeat({{ $interestedUser->user->user_id }})"
                                                    class="mt-2 btn btn-sm btn-success float-end">Submit</button>
                                                <button wire:click="$set('allotSlot', false)"
                                                    class="mt-2 btn btn-sm btn-secondary float-end me-2">Cancel</button>
                                            </div>
                                            @else
                                            @if ($userSeat)
                                            <span class="badge bg-secondary" style="cursor: pointer;"
                                                wire:click="showAllotSlot({{ $interestedUser->user->user_id }})">
                                                {{ $userSeat->number_of_seat }} Seat(s)
                                            </span>
                                            <button wire:click="deleteAllotedSeat({{ $interestedUser->user->user_id }})"
                                                class="btn btn-sm btn-danger ms-2">Delete</button>
                                            @else
                                            <button wire:click="showAllotSlot({{ $interestedUser->user->user_id }})"
                                                class="btn btn-sm btn-primary">Allot Seat</button>
                                            @endif
                                            @endif
                                        </td>
                                        @else
                                        @endif
                                        @endauth
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($interestedUsers->hasPages())
                            <div class="modal-footer">
                                <div
                                    class="card-footer d-flex justify-content-between align-Speciescharacterstic-center">
                                    <div>
                                        Showing {{ $interestedUsers->firstItem() }} to
                                        {{ $interestedUsers->lastItem() }} of
                                        {{ $interestedUsers->total() }} entries
                                    </div>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center justify-content-md-end">
                                            <li class="page-item {{ $interestedUsers->onFirstPage() ? 'disabled' : '' }}">
                                                <button class="page-link" wire:click="previousPage" {{ $interestedUsers->onFirstPage() ? 'disabled' : '' }}>Previous</button>
                                            </li>

                                            @php
                                                $start = max(1, $interestedUsers->currentPage() - 2);
                                                $end = min($interestedUsers->lastPage(), $interestedUsers->currentPage() + 2);
                                            @endphp

                                            @if ($start > 1)
                                                <li class="page-item">
                                                    <button class="page-link" wire:click="gotoPage(1)">1</button>
                                                </li>
                                                @if ($start > 2)
                                                    <li class="page-item disabled">
                                                        <span class="page-link">...</span>
                                                    </li>
                                                @endif
                                            @endif

                                            @for ($page = $start; $page <= $end; $page++)
                                                <li class="page-item {{ $interestedUsers->currentPage() == $page ? 'active' : '' }}">
                                                    <button class="page-link" wire:click="gotoPage({{ $page }})">
                                                        {{ $page }}
                                                    </button>
                                                </li>
                                            @endfor

                                            @if ($end < $interestedUsers->lastPage())
                                                @if ($end < $interestedUsers->lastPage() - 1)
                                                    <li class="page-item disabled">
                                                        <span class="page-link">...</span>
                                                    </li>
                                                @endif
                                                <li class="page-item">
                                                    <button class="page-link" wire:click="gotoPage({{ $interestedUsers->lastPage() }})">
                                                        {{ $interestedUsers->lastPage() }}
                                                    </button>
                                                </li>
                                            @endif

                                            <li class="page-item {{ !$interestedUsers->hasMorePages() ? 'disabled' : '' }}">
                                                <button class="page-link" wire:click="nextPage" {{ !$interestedUsers->hasMorePages() ? 'disabled' : '' }}>Next</button>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (count($similarPackages))
        <section id="similar-packages" wire:ignore>
            <div class="container-lg container-inner-padding px-1">
                <div class="heading-text text-center mb-xl-4 mb-3">
                    <div class="">
                        <h2 class="mb-0 text-accent">Similar Packages</h2>
                        <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                            class="vector-border-bottom">
                    </div>
                </div>

                <div class="similar-packages-wrapper">
                    <div class="slick-slider" id="similar-packages-owl">
                    @foreach ($similarPackages as $similarPackage)
                    <div class="item">
                        <div class="owl-slide text-start mx-auto">
                            <div class="join-safari-card-box mb-3 px-sm-2 rounded-3">
                                <div class="card rounded-3">
                                    <!-- Card Image -->
                                    @if (!empty($similarPackage->display_image))
                                    <img class="card-img-top rounded-top-3"
                                        style="width:100%; height:220px; object-fit:cover;"
                                        src="{{ asset($similarPackage->display_image) }}" alt="Card image">
                                    @else
                                    <img class="card-img-top rounded-top-3"
                                        style="width:100%; height:220px; object-fit:cover;"
                                        src="{{ asset('assets/images/GPT-1.png') }}" alt="Card image">
                                    @endif
                                    <!-- Card Body -->
                                    <div class="card-body p-0">
                                        <div class="card-body-inner border-bottom">
                                            <div class="card-title border-bottom pb-1">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h4 class="mb-0 card-text">
                                                        {{ $similarPackage->title }}
                                                    </h4>
                                                </div>
                                                <div class="cityplace-text">
                                                    <span>
                                                        {{ $shareSafari->park->name }},{{
                                                        $shareSafari->park->state->name }}</span>
                                                </div>
                                            </div>
                                            <div class="card-text">
                                                <div class="d-flex justify-content-between">
                                                    <div class="text-center">
                                                        <p class="mb-0">Safari</p>
                                                        <p class="mb-0">{{ $shareSafari->no_of_safari }}
                                                        </p>
                                                    </div>
                                                    <div class="text-center">
                                                        <p class="mb-0">Seats</p>
                                                        <p class="mb-0 fw-bold">
                                                            {{ $shareSafari->share_seats }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex align-items-center justify-content-between card-body-inner py-2 price-container flex-wrap">
                                            <div class="starting-price">
                                                <p class="mb-0">Starting Price:</p>
                                                <span class="mb-0 text-muted">₹ {{ $shareSafari->min_price_pp }}
                                                    - ₹ {{ $shareSafari->max_price_pp }}</span>
                                            </div>
                                            <a href="{{ route('shared-safari.detail', $similarPackage->slug) }}"
                                                class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">Enquire
                                                Now</a>
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
@push('scripts')@if (!empty($faqs) && count($faqs) > 0)
<script type="application/ld+json">
    {!! json_encode([
                "@context" => "https://schema.org",
                "@type" => "FAQPage",
                "mainEntity" => collect($faqs)->map(function ($faq) {
                    $question = trim($faq['question'] ?? '');
                    $answer   = trim($faq['answer'] ?? '');

                    return [
                        "@type" => "Question",
                        "name" => $question,
                        "acceptedAnswer" => [
                            "@type" => "Answer",
                            // Google requires text inside <p> if multi-line or HTML
                            "text" => "<p>" . e($answer) . "</p>",
                        ],
                    ];
                })->values()->toArray(),
            ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@endif
@endpush
