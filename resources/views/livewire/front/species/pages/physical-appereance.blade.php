<div>
    @if (!empty($physicalData))
        <div>
            <div class="heading-text text-center mb-xl-4 mb-3">
                <div class="">
                    <h2 class="mb-0 text-accent">Adaptations</h2>
                    <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                        class="vector-border-bottom">
                </div>
            </div>
            <div class="appearance-box">
                <div class="mb-4">
                    <div>
                        <p>
                            {!! $showFull
                                ? $physicalData->adaptation_description
                                : Str::limit(strip_tags($physicalData->adaptation_description), 300) !!}
                            @if (strlen(strip_tags($physicalData->adaptation_description)) > 300)
                                <a wire:click="$toggle('showFull')" class="text-blue-600 cursor-pointer ">
                                    {{ $showFull ? 'Read Less' : 'Read More' }}
                                </a>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <!-- Physical Adaptations -->
                    @if ($adaptationData->count() > 0)
                        @foreach ($adaptationData as $adaptation)
                            @php
                                $count = $adaptationData->count();
                                $isOdd = $count % 2 !== 0;
                                $isLast = $loop->last;
                                $colClass = $isOdd && $isLast ? 'col-md-12' : 'col-md-6';
                            @endphp
                            <div class="{{ $colClass }}">
                                <div class="card h-100 shadow-sm border-0 rounded-4">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3 text-blue">
                                            <i class="fa-solid fa-paw me-1"></i>{{ $adaptation->title }}
                                        </h5>
                                        @if ($adaptation->short_description)
                                            {!! $adaptation->short_description !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
        @if (!empty($physicalData->appearance_description))
            <div class="appearance-box">
                <div class="heading-text text-center mb-xl-4 mb-3">
                    <div class="">
                        <h2 class="mb-0 text-accent">Appearance
                        </h2>
                        <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                            class="vector-border-bottom">
                    </div>
                </div>
                <p>
                    {!! $physicalData->appearance_description !!}
                </p>
                @if ($traits)
                    <div class="table-responsive" id="distance-table">
                        <table class="table table-bordered table-striped text-center align-middle mb-4">
                            <thead class="table-light">
                                <tr>
                                    <th>Trait</th>
                                    <th>Male</th>
                                    <th>Female</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($traits as $trait => $values)
                                    <tr>
                                        <td>{{ $trait }}</td>
                                        <td>{{ $values['Male'] ?? '-' }}</td>
                                        <td>{{ $values['Female'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif
        @if (!empty($lifestyleData))
            <div>
                <div class="">
                    <div class="heading-text text-center mb-4">
                        <h2 class="mb-0 text-accent">Diet of {{ $species->name }}</h2>
                        <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector Border"
                            class="vector-border-bottom">
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <!-- Diet Summary -->
                        <div class="col-12 mb-4">
                            <p class="mb-0">
                                {!! $showFull
                                    ? $lifestyleData->diet_short_description
                                    : Str::limit(strip_tags($lifestyleData->diet_short_description), 300) !!}
                                @if (strlen(strip_tags($lifestyleData->diet_short_description)) > 300)
                                    <a wire:click="$toggle('showFull')" class="text-blue-600 cursor-pointer ">
                                        {{ $showFull ? 'Read Less' : 'Read More' }}
                                    </a>
                                @endif
                            </p>
                        </div>
                        @if (count($dietData) > 0)
                            <div class="col-12">
                                <div class="row">
                                    @foreach ($dietData as $index => $diet)
                                        <div class="col-12">
                                            <div class="card shadow-sm border-0 rounded-3 mb-4">
                                                <div
                                                    class="row g-0 align-items-center d-flex {{ $index % 2 !== 0 ? 'flex-md-row-reverse' : 'flex-md-row' }}">
                                                    <!-- Image Section (always on top in mobile) -->
                                                    <div class="col-md-5">
                                                        <div class="p-3 h-100 d-flex align-items-center">
                                                            <img src="{{ asset($diet->image) }}"
                                                                alt="{{ $diet->title }}"
                                                                class="img-fluid rounded-2 w-100">
                                                        </div>
                                                    </div>

                                                    <!-- Text Section -->
                                                    <div class="col-md-7 appearance-box" x-data="{ showFull: false }">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-3">
                                                                <i class="fa-solid fa-paw me-1"></i>
                                                                {{ $diet->title }}
                                                            </h5>

                                                            @if (!empty($diet->short_description))
                                                                <div x-show="!showFull">
                                                                    {{ Str::limit(strip_tags($diet->short_description), 500) }}
                                                                </div>
                                                                <div x-show="showFull" x-cloak>
                                                                    {!! $diet->short_description !!}
                                                                </div>

                                                                @if (strlen(strip_tags($diet->short_description)) > 500)
                                                                    <a @click="showFull = !showFull"
                                                                        class="text-blue-600 cursor-pointer">
                                                                        <span x-show="!showFull">Read More</span>
                                                                        <span x-show="showFull">Read Less</span>
                                                                    </a>
                                                                @endif
                                                            @else
                                                                <p>No details available.</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if (!empty($lifestyleData->habitatt_short_description))
                    <div>
                        <div class="heading-text text-center mb-xl-4 mb-3">
                            <div class="">
                                <h2 class="mb-0 text-accent">Habitat of {{ $species->name }}</h2>
                                <img src="{{ asset('front-assets/images/blue-border-vector.png') }}"
                                    alt="Vector-Border" class="vector-border-bottom">
                            </div>
                        </div>
                        <div class="appearance-box">
                            <p>
                                {!! $showFullHabitat
                                    ? $lifestyleData->habitatt_short_description
                                    : Str::limit(strip_tags($lifestyleData->habitatt_short_description), 300) !!}
                                @if (strlen(strip_tags($lifestyleData->habitatt_short_description)) > 300)
                                    <a wire:click="$toggle('showFullHabitat')" class="text-blue-600 cursor-pointer ">
                                        {{ $showFullHabitat ? 'Read Less' : 'Read More' }}
                                    </a>
                                @endif
                            </p>
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



</div>
