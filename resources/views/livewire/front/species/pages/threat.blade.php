<div>
    @if (!empty($threatData))
    <div>
        <div class="heading-text text-center mb-xl-4 mb-3">
            <div class="">
                <h2 class="mb-0 text-accent">Threats to {{ $species->name }}</h2>
                <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                    class="vector-border-bottom">
            </div>
        </div>
        <!-- Threats Accordion Start -->
        <div class="mb-0">
            <div class="row mb-lg-4">
                <!-- Image Column -->
                <div class="col-xl-5 col-lg-6 mb-3">
                    <img src="{{ asset($threatData->image) }}" class="img-fluid w-100"
                        style="max-height: 365px; object-fit: cover;" alt="Detail-2">
                </div>

                <!-- Text Column -->
                <div class="col-xl-7 col-lg-6 mb-3">
                    <p>
                        {!! $showFull ? $threatData->short_description :
                        Str::limit(strip_tags($threatData->short_description), 1090) !!}

                        @if (strlen(strip_tags($threatData->short_description)) > 1090)
                        <a wire:click="$toggle('showFull')" class="text-blue-600 cursor-pointer">
                            {{ $showFull ? 'Read Less' : 'Read More' }}
                        </a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <!-- Threats Accordion End -->
        @if (!empty($threatData->threat))
        <div class="" style=" padding-top:50px; ">
            <h3 class="text-blue mb-3">Conservation
                Efforts</h3>
            <p>
                {!! $showFullConservation ? $threatData->threat : Str::limit(strip_tags($threatData->threat), 700) !!}
                @if (strlen(strip_tags($threatData->threat)) > 700)
                <a wire:click="$toggle('showFullConservation')" class="text-blue-600 cursor-pointer ">
                    {{ $showFullConservation ? 'Read Less' : 'Read More' }}
                </a>
                @endif
            </p>
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
