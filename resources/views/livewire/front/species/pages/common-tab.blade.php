<div>
    @if (!empty($tabData))
        <div>
            <div class="heading-text text-center mb-xl-4 mb-3">
                <div class="">
                    <h2 class="mb-0 text-accent">{{ $species->name }} {{ $characterstic->title }}
                    </h2>
                    <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                        class="vector-border-bottom">
                </div>
            </div>
            <!-- Interesting Facts Cards Section -->
            <div class="species-intrestings-facts">
                <p>
                    {!! $tabData?->short_description !!}
                </p>
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
