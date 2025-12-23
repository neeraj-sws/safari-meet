<div>
    @if (count($howToReach) > 0)
        <div>
            <div class="heading-text text-center mb-xl-4 mb-3">
                <div class="">
                    <h2 class="mb-0 text-accent"> How to Reach the {{ $parkdetails->name }}
                        Park</h2>
                    <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                        class="vector-border-bottom">
                </div>
            </div>
            <div class="row justify-content-center mb-3">
                @foreach ($howToReach as $reach)
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="modes-content text-center">
                            <div class="modes-img">
                                <img src="{{ asset($reach->reachability->display_image ?? 'front-assets/images/default.png') }}"
                                    alt="{{ $reach->reachability->title }}" class="img-fluid">
                            </div>
                            <h3 class="">{{ $reach->reachability->title }}</h3>
                            <p class="mb-0">
                                {!! $reach->description !!}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            @php
                $allCities = collect($howToReach)
                    ->pluck('reachabilityDistance')
                    ->flatten(1)
                    ->pluck('cityData')
                    ->filter()
                    ->unique('id')
                    ->values();
                // dd($allCities->toArray());
            @endphp
            @if (count($allCities) > 0)
                <div class="table-responsive" id="distance-table">
                    <table class="table table-bordered table-striped text-center align-middle">
                        <caption class="text-center text-dark small fw-semibold" style="caption-side: top;">
                            {{ $parkdetails->title }} distance from important cities
                        </caption>
                        <thead class="table-light">
                            <tr>
                                <th>From</th>
                                @foreach ($howToReach as $reach)
                                    <th>{{ $reach->heading ?? $reach->title }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allCities as $city)
                                <tr>
                                    <td>{{ $city['name'] ?? 'N/A' }}</td>
                                    @foreach ($howToReach as $reach)
                                        @php
                                            $distanceItem = collect($reach->reachabilityDistance)->firstWhere(
                                                'city_id',
                                                $city['id'] ?? null,
                                            );
                                        @endphp
                                        <td>{{ $distanceItem['distance'] ?? 'N/A' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
