<div>
    <style>
        .card-img-top {
            width: 100%;
            height: 220px;
            /* apni zarurat ke hisab se fix height */
            object-fit: cover;
            /* image crop karke fit karega */
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        @media (max-width: 768px) {
            .card-img-top {
                height: 180px;
            }
        }

        @media (max-width: 480px) {
            .card-img-top {
                height: 150px;
            }
        }
    </style>
    @php
    use App\Models\SafariAllottedSeat;
    @endphp
    <div class="">
        <div class="card mb-3 rounded-3">
            <div class="card-body">
                <!-- About -->
                <div class="row">
                    <div class="col-12 d-flex justify-content-between">
                        <h3 class="mb-0">Shared Safari Organized by me</h3>
                        @auth
                        @if (Auth::guard('web')->user()->user_type == 1 && Auth::guard('web')->user()->status == 1)
                        <a href="{{ route('createsaharedshafari') }}"
                            class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">Create Shared Safari</a>
                        @elseif(Auth::guard('web')->user()->user_type == 0)
                        <a href="{{ route('createsaharedshafari') }}"
                            class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">Create Shared Safari</a>
                        @endif
                        @endauth
                    </div>
                    @if (count($shareSafaris) > 0)
                    @foreach ($shareSafaris as $key => $shareSafari)
                    @php
                    $allottedSeatCount = $shareSafari->allottedSeat->sum('number_of_seat');
                    $totalSeat = $shareSafari->share_seats - $allottedSeatCount;
                    @endphp
                    <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3"
                        wire:key="{{ $shareSafari->id }}">
                        <div class="card rounded-3">
                            @if ($shareSafari->is_create_safari_complete == 'incompleted')
                            <small class="top-rated-park text-white bg-danger">Incomplete</small>
                            @elseif($shareSafari->status == 1 && $shareSafari->is_approved == 0 )
                            <small class="top-rated-park text-white bg-warning">Not approved</small>
                            @elseif($shareSafari->status == 1 && $shareSafari->is_approved == 1 && $shareSafari->day !=
                            Date('Y-m-d'))
                            <small class="top-rated-park text-white bg-success">Published </small>
                            @endif
                            @if ($totalSeat == 0 && $shareSafari->is_approved == 1)
                            <small class="limited-availability">Seat Booked</small>
                            @endif
                            <!-- Card Image -->
                            <a href="{{ route('shared-safari.detail', $shareSafari->slug) }}">
                                @if (!empty($shareSafari->display_image))
                                <img class="card-img-top rounded-top-3"
                                    style="width:100%; height:220px; object-fit:cover;"
                                    src="{{ asset($shareSafari->display_image) }}" alt="Card image">
                                @else
                                <img class="card-img-top rounded-top-3"
                                    style="width:100%; height:220px; object-fit:cover;"
                                    src="{{ asset('assets/images/GPT-1.png') }}" alt="Card image">
                                @endif
                            </a>
                            <!-- Card Body -->
                            <div class="card-body p-0">
                                <div class="card-body-inner border-bottom">
                                    <div class="card-title border-bottom pb-1">
                                        <div class="d-flex align-items-center justify-content-around">
                                            <h4 class="mb-0 card-text">
                                                {{ ucwords($shareSafari->title) }}
                                            </h4>
                                        </div>
                                        <div class="cityplace-text">
                                            <span>
                                                {{ ucwords($shareSafari?->park?->name) }},
                                                {{ ucwords($shareSafari?->park?->state?->name) }}</span>
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center">
                                                <p class="mb-0">Safari</p>
                                                <p class="mb-0">{{ $shareSafari->no_of_safari }}</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="mb-0">Seats</p>
                                                <p class="mb-0 fw-bold">{{ $totalSeat }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body-inner py-2 price-container flex-wrap">
                                    <div class="starting-price mb-2 text-center">
                                        <p class="mb-0">Price:
                                            <span class="mb-0 text-muted">₹ {{ $shareSafari->min_price_pp }}
                                                - ₹ {{ $shareSafari->max_price_pp }}</span>
                                        </p>
                                    </div>

                                    @if (count($shareSafari->joinedsafari) == 0)
                                    <div class="text-center" id="{{ $key }}">
                                        <a href="{{ route('edit.saharedshafari', ['slug' => $shareSafari->slug, 'type' => 'basic-info']) }}"
                                            class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">Edit</a>
                                    </div>
                                    @else
                                    <div class="text-center">
                                        <a href="{{ route('shared-safari.detail', $shareSafari->slug) }}"
                                            id="join_safari_{{ $shareSafari->id }}"
                                            class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">
                                            View Details
                                        </a>
                                    </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if ($shareSafaris->count() >= $perPage)
                    <div class="col-12 text-center mt-4 pt-2">
                        <button wire:click="loadMore" class="btn btn-primary blue-btn-hover btn-sm border-0 px-3">
                            Load More
                        </button>
                    </div>
                    @endif
                    @else
                    <div class="col-12">
                        <h3 class="m-2 text-center">No Safari Organized</h3>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- The rest of your HTML for joined safaris remains the same -->
        <div class="card mb-0">
            <div class="card-body">
                <!-- About -->
                <div class="row">
                    @if (count($joinedShareSafaris) > 0)
                    <div class="col-12">
                        <h3 class="mb-0">{{ count($joinedShareSafaris) }} Shared Safari Joined by me</h3>
                    </div>

                    @foreach ($joinedShareSafaris as $shareSafari)
                    <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3"
                        wire:key="{{ $shareSafari->id }}">
                        <div class="card rounded-3">
                            <!-- Card Image -->
                            <a href="{{ route('shared-safari.detail', $shareSafari->slug) }}">
                                @if (!empty($shareSafari->display_image))
                                <img class="card-img-top rounded-top-3"
                                    style="width:100%; height:220px; object-fit:cover;"
                                    src="{{ asset($shareSafari->display_image) }}" alt="Card image">
                                @else
                                <img class="card-img-top rounded-top-3"
                                    style="width:100%; height:220px; object-fit:cover;"
                                    src="{{ asset('assets/images/GPT-1.png') }}" alt="Card image">
                                @endif
                            </a>
                            <!-- Card Body -->
                            <div class="card-body p-0">
                                <div class="card-body-inner border-bottom">
                                    <div class="card-title border-bottom pb-1">
                                        <div class="d-flex align-items-center justify-content-around">
                                            <h4 class="mb-0 card-text">
                                                {{ ucwords($shareSafari->title) }}
                                            </h4>
                                        </div>
                                        <div class="cityplace-text">
                                            <span>
                                                {{ ucwords($shareSafari->park->name) }},
                                                {{ ucwords($shareSafari->park->state->name) }}</span>
                                        </div>
                                    </div>
                                    <div class="card-text">
                                        <div class="d-flex justify-content-between">
                                            <div class="text-center">
                                                <p class="mb-0">Safari</p>
                                                <p class="mb-0">{{ $shareSafari->no_of_safari }}</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="mb-0">Seats</p>
                                                <p class="mb-0 fw-bold">{{ $shareSafari->share_seats }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-around card-body-inner py-2 price-container flex-wrap">
                                    <div class="starting-price mb-2">
                                        <p class="mb-0">Price:
                                            <span class="mb-0 text-muted">₹ {{ $shareSafari->min_price_pp }}
                                                - ₹ {{ $shareSafari->max_price_pp }}</span>
                                        </p>
                                    </div>
                                    @php
                                    $userSeat = '';
                                    $userSeat = SafariAllottedSeat::where(
                                    'shared_safari_id',
                                    $shareSafari->id,
                                    )
                                    ->where('user_id', Auth::guard('web')->id())
                                    ->first();

                                    @endphp


                                    <div class="text-end my-2">
                                        <a href="{{ route('shared-safari.detail', $shareSafari->slug) }}"
                                            id="join_safari_{{ $shareSafari->id }}"
                                            class="btn btn-sm border border-blue blue-border-hover blue-text-hover border-2 rounded-1 text-center">
                                            View Details
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if ($shareSafaris->count() >= $joinPerPage)
                    <div class="col-12 text-center mt-4 pt-2">
                        <button wire:click="joinedLoadMore" class="btn btn-primary blue-btn-hover btn-sm border-0 px-3">
                            Load More
                        </button>
                    </div>
                    @endif
                    @else
                    <div class="col-12 ">
                        <h3 class="m-2 text-center">No Safari Joined</h3>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
