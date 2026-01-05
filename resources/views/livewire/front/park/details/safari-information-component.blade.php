<div>
    @if (!empty($safariInformation))
    <div>
        <div class="heading-text text-center mb-xl-4 mb-3">
            <div class="">
                <h2 class="mb-0 text-accent">Safari Information of {{ $parkdetails->name }}
                </h2>
                <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                    class="vector-border-bottom">
            </div>
        </div>
        <!-- Safari Zones or Gates -->
        <div class="row align-items-center mb-4">
            <div class="col-12 mb-3">
                <div class="right-text-box">
                    {!! $safariInformation->information !!}
                </div>
            </div>
            @if (!empty($parkZone))
            <div class="col-12">
                <div class="row">
                    @if (count($parkZone->where('type', 1)) > 0)
                    <div class="col-md-6">
                        <!-- Core Zone -->
                        <div class="table-responsive mb-md-0 mb-3">

                            <table class="custom-table" cellspacing="10px" id="bestTimeToVisit">
                                <!-- First Header Row -->
                                <tr>
                                    <td colspan="3" class="table-header p-2 bg-accent border-0">
                                        <h3 class="text-white fw-medium m-0">Core Zone

                                        </h3>
                                    </td>
                                </tr>

                                <!-- Second Header Row -->
                                <tr class="table-header p-2">
                                    <td class="p-2 bg-white fw-bold">Zone Name</td>
                                    <td class="p-2 bg-white fw-bold">Entry Gate</td>
                                </tr>
                                @foreach ($parkZone->where('type', 1) as $corezone)
                                <tr>
                                    <td class="p-2 bg-white fw-normal">{{ $corezone?->zone_name }}</td>
                                    <td class="p-2 bg-white fw-normal">{{ $corezone?->entry_gate }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    @endif
                    @if (count($parkZone->where('type', 2)) > 0)
                    <div class="col-md-6">
                        <!-- Buffer Zone -->
                        <div class="table-responsive">
                            <table class="custom-table" cellspacing="10px" id="bestTimeToVisit">
                                <!-- First Header Row -->
                                <tr>
                                    <td colspan="3" class="table-header p-2 bg-accent border-0">
                                        <h3 class="text-white fw-medium m-0">Buffer Zone
                                        </h3>
                                    </td>
                                </tr>

                                <!-- Second Header Row -->
                                <tr class="table-header p-2">
                                    <td class="p-2 bg-white fw-bold">Zone Name</td>
                                    <td class="p-2 bg-white fw-bold">Entry Gate</td>
                                </tr>
                                @foreach ($parkZone->where('type', 2) as $corezone)
                                <tr>
                                    <td class="p-2 bg-white fw-normal">{{ $corezone?->zone_name }}</td>
                                    <td class="p-2 bg-white fw-normal">{{ $corezone?->entry_gate }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
        <!-- Kanha Safari Timings -->
        @if (count($parkTimings) > 0)
        <div class="table-responsive mb-4">
            <div class="heading-text text-center mb-xl-4 mb-3">
                <div class="">
                    <h2 class="mb-0 text-accent">{{ $parkdetails->name }} Safari Timings</h2>
                    <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                        class="vector-border-bottom">
                </div>
            </div>
            @foreach ($parkTimings as $timing)
            <table class="custom-table" cellspacing="10px" id="bestTimeToVisit">
                <!-- First Header Row -->
                <tr>
                    <td rowspan="4" class="vertical-text p-3 bg-white">
                        <h3 class="text-blue m-0">{{ $timing->weather->title ?? '' }}</h3>
                    </td>
                    <td colspan="{{ count(array_unique(array_column($timing->details->toArray(), 'month'))) + 1 }}"
                        class="table-header p-3 bg-white">
                        <h3 class="text-blue m-0">{{ $timing->start }} to {{ $timing->end }}</h3>
                    </td>
                </tr>

                <!-- Second Header Row -->
                <tr class="table-header p-3">
                    <td class="p-3 bg-white">Safari Slot v/s Month</td>
                    @foreach (collect($timing->details)->pluck('month')->unique() as $month)
                    <td class="p-3 bg-white">{{ $month }}</td>
                    @endforeach
                </tr>

                <!-- Morning Slot Row -->
                <tr>
                    <td class="table-header p-3 bg-white">Morning Slot</td>
                    @foreach (collect($timing->details)->where('slot_type', 'Morning') as $slot)
                    <td class="p-3 bg-white">{{ $slot->start_time }}</td>
                    @endforeach
                </tr>

                <!-- Evening Slot Row -->
                <tr>
                    <td class="table-header p-3 bg-white">Evening Slot</td>
                    @foreach (collect($timing->details)->where('slot_type', 'Evening') as $slot)
                    <td class="p-3 bg-white">{{ $slot->start_time }}</td>
                    @endforeach
                </tr>
            </table>
            @endforeach
        </div>
        @endif
        @if ($safariInformation->booking_process)
        <!-- Safari Booking Process -->
        <div class="row align-items-center mb-4">
            <div class="col-12">
                <div class="heading-text text-center mb-xl-4 mb-3">
                    <div class="">
                        <h2 class="mb-0 text-accent">Safari Booking Process</h2>
                        <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                            class="vector-border-bottom">
                    </div>
                </div>
            </div>

            <div class="col-xl-12 mb-xl-0 mb-4">
                {!! $safariInformation->booking_process !!}
            </div>
        </div>
        @endif
        <div>
            @if (!empty($safariInformation->rules))
            <div class="heading-text text-center mb-xl-4 mb-3">
                <div class="">
                    <h2 class="mb-0 text-accent">Park Rules
                    </h2>
                    <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                        class="vector-border-bottom">
                </div>
            </div>
            <div>
                {!! $safariInformation->rules !!}
            </div>
            @endif
        </div>

        @if (
        (!empty($safariInformation->dos_description) && !empty($safariInformation->dos_image)) ||
        (!empty($safariInformation->donts_description) && !empty($safariInformation->donts_image)))
        <div class="heading-text text-center mb-xl-4 mb-3">
            <div class="">
                <h2 class="mb-0 text-accent">Park Rules</h2>
                <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                    class="vector-border-bottom">
            </div>
        </div>
        @endif
        @if (!empty($safariInformation->dos_description) && !empty($safariInformation->dos_image))
        <div class="about-section right">
            <div class="img-box">
                <img src="{{ asset($safariInformation->dos_image) }}" alt="Detail-1" class="img-fluid" loading="lazy">
            </div>

            <div class="text-box">
                <h3 class="text-blue">
                    <h3 class="mb-0 text-blue">Do's</h3>
                </h3>
                <div class="">
                    {!! $safariInformation->dos_description !!}
                </div>
            </div>
        </div>
        @endif
        @if (!empty($safariInformation->donts_description) && !empty($safariInformation->donts_image))
        <div class="about-section left">
            <div class="img-box">
                <img src="{{ asset($safariInformation?->donts_image) }}" alt="Detail-1" class="img-fluid"
                    loading="lazy">
            </div>

            <div class="text-box">
                <h3 class="text-blue">
                    <h3 class="mb-0 text-blue">Dont's</h3>
                </h3>
                <div class="">
                    {!! $safariInformation->donts_description !!}
                </div>
            </div>
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
