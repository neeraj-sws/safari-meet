<div>
    @if (!empty($parkdetails))
        <div class="tab-pane fade show active" id="keyinfo" role="tabpanel" aria-labelledby="keyinfo-tab">
            <div class="heading-text text-center mb-xl-4 mb-3">
                <div class="">
                    <h2 class="mb-0 text-accent">Key Information</h2>
                    <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                        class="vector-border-bottom">
                </div>
                <h3 class="text-center fw-bold text-blue mb-sm-5 mb-3">
                    {{ $parkdetails->name }} </h3>
            </div>
            <div class="mb-4">
                <div class="row mb-3 gx-2 align-items-center flex-md-row flex-column-reverse">
                    <div class="col-md-7">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body">
                                <h5 class="mb-2 link-text text-dark"><i
                                        class="fa-solid fa-leaf me-2 text-dark fs-6"></i>Park
                                    Overview</h5>
                                <ul class="list-unstyled small mb-0">
                                    @if (!empty($parkdetails?->state))
                                        <li><strong class="primary-color-muted">Location:</strong>
                                            {{ $parkdetails?->name }},{{ $parkdetails?->state?->name }}
                                        </li>
                                    @endif
                                    @if (!empty($parkdetails?->established))
                                        <li>
                                            <strong class="primary-color-muted">Established:</strong>
                                            {{ \Carbon\Carbon::parse($parkdetails->established)->format('jS F Y') }}
                                        </li>
                                    @endif

                                    @if (!empty($parkdetails?->area))
                                        <li><strong class="primary-color-muted">Area:</strong>
                                            {{ $parkdetails->area }}</li>
                                    @endif
                                    @if (!empty($parkdetails?->famous_for))
                                        <li><strong class="primary-color-muted">Famous
                                                For:</strong>
                                            {{ $parkdetails->famous_for }}
                                        </li>
                                    @endif
                                    @php
                                        $BestTime = $parkdetails?->parkBestTimes
                                            ? $parkdetails?->parkBestTimes
                                                ?->pluck('weather.title')
                                                ->filter()
                                                ->implode(', ')
                                            : 'Null';
                                    @endphp
                                    @if (!empty($BestTime))
                                        <li><strong class="primary-color-muted">Best Time:</strong>
                                            {{ $BestTime }}
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 mb-md-0 mb-3">
                        <div class="img-1 rounded-3 bg-blue  key-info-img">
                            @if (!empty($keyInfo->overview_image))
                                <img src="{{ asset($keyInfo->overview_image) }}" alt="Animal"
                                    class="img-fluid rounded-2">
                            @else
                                <img src="{{ asset('front-assets/images/animal-images/blog-1.png') }}" alt="Animal"
                                    class="img-fluid rounded-2">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3 gx-2 align-items-center">
                    <div class="col-md-5 mb-md-0 mb-3">
                        <div class="img-1 rounded-3 bg-blue  key-info-img">
                            @if (!empty($keyInfo->travel_info_image))
                                <img src="{{ asset($keyInfo->travel_info_image) }}" alt="Animal"
                                    class="img-fluid rounded-2">
                            @else
                                <img src="{{ asset('front-assets/images/animal-images/species-2.png') }}"
                                    alt="Animal" class="img-fluid rounded-2">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body">
                                <h5 class="mb-2 link-text text-dark"><i
                                        class="fa-solid fa-car me-2 text-dark fs-6"></i>Safari
                                    and Travel Info</h5>
                                <ul class="list-unstyled small mb-0">
                                    @if (!empty($parkdetails->parkSafariTypes))
                                        <li><strong class="primary-color-muted">Safari
                                                Types:</strong>
                                            {{ collect($parkdetails->parkSafariTypes)->pluck('safari_type.name')->unique()->implode(', ') }}
                                        </li>
                                    @endif
                                    @if (!empty($parkdetails->core_zone))
                                        <li><strong class="primary-color-muted">Core
                                                Zones:</strong>
                                            {{ $parkdetails?->core_zone }}
                                        </li>
                                    @endif
                                    @if (!empty($parkdetails->entry_gates))
                                        <li><strong class="primary-color-muted">Entry
                                                Gates:</strong>{{ $parkdetails?->entry_gates }}
                                        </li>
                                    @endif
                                    @if (!empty($parkdetails->nearest_railway))
                                        <li><strong class="primary-color-muted">Nearest Railway
                                                Station:</strong>
                                            {{ $parkdetails?->nearest_railway }}
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 gx-2 align-items-center flex-md-row flex-column-reverse">
                    <div class="col-md-7">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body">
                                <h5 class="mb-2 link-text text-dark"><i
                                        class="fa-solid fa-clock me-2 text-dark fs-6"></i>Timings & Cost</h5>
                                <ul class="list-unstyled small mb-2">
                                    <li><strong class="primary-color-muted">Safari Timings:</strong><br>
                                        Morning: {{ $parkdetails?->morning_time }}<br>
                                        Afternoon: {{ $parkdetails?->afternoon_time }}</li>
                                </ul>
                                @if (!empty($parkdetails?->core_zone_price) && !empty($parkdetails?->buffer_zone_price))
                                    <p class="small mb-0">
                                        <strong class="primary-color-muted">Cost:</strong>
                                        {{ !empty($parkdetails?->core_zone_price) ? $parkdetails?->core_zone_price . '(Core),' : '' }}
                                        {{ !empty($parkdetails?->buffer_zone_price) ? $parkdetails?->buffer_zone_price . '(Buffer)' : '' }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 mb-md-0 mb-3">
                        <div class="img-1 rounded-3 bg-blue  key-info-img">
                            @if (!empty($keyInfo->timing_cost_image))
                                <img src="{{ asset($keyInfo?->timing_cost_image) }}" alt="Animal"
                                    class="img-fluid rounded-2">
                            @else
                                <img src="{{ asset('front-assets/images/animal-images/bird-1.png') }}" alt="Animal"
                                    class="img-fluid rounded-2">
                            @endif
                        </div>
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
