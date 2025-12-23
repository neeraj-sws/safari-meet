<div>
    @if ($overViewData)
        <div class="tab-pane fade show active" id="legacy" role="tabpanel" aria-labelledby="legacy-tab">
            <div class="heading-text text-center mb-xl-4 mb-3">
                <div class="">
                    <h2 class="mb-0 text-accent">About {{ $species->name }}</h2>
                    <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                        class="vector-border-bottom">
                </div>
            </div>
            <div class="about-species mb-0">
                <div class="row mb-3 gx-2 align-items-center">
                    <div class="col-12">
                        <div class="row flex-md-row flex-column-reverse">
                            <div class="col-md-6">
                                <div>
                                    <p>
                                        {!! $showFull ? $overViewData?->about : Str::limit(strip_tags($overViewData?->about), 800) !!}
                                        @if (strlen(strip_tags($overViewData?->about)) > 800)
                                            <a wire:click="$toggle('showFull')" class="text-blue-600 cursor-pointer ">
                                                {{ $showFull ? 'Read Less' : 'Read More' }}
                                            </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="img-1 rounded-3 bg-blue key-info-img mb-3">
                                    <img src="{{ asset($overViewData?->about_image) }}" alt="Animal"
                                        class="img-fluid rounded-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (
                !empty($overViewData?->category?->name) ||
                    !empty($overViewData?->family?->name) ||
                    !empty($overViewData?->genus?->name) ||
                    !empty($overViewData?->life_span) ||
                    !empty($overViewData?->speed) ||
                    !empty($overViewData?->mass) ||
                    !empty($overViewData?->height) ||
                    !empty($overViewData?->length))
                <div class="heading-text text-center mb-xl-4 mb-3">
                    <div class="">
                        <h2 class="mb-0 text-accent">Zoological Identity</h2>
                        <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                            class="vector-border-bottom">
                    </div>
                </div>
                <div class="mb-4 species-facts rounded-3">
                    @if (!empty($overViewData?->category?->name))
                        <div class="fact-box bg-white rounded-3 p-3">
                            <div class="fact-title">Category</div>
                            <div class="fact-value">{{ $overViewData->category->name }}</div>
                        </div>
                    @endif

                    @if (!empty($overViewData?->family?->name))
                        <div class="fact-box bg-white rounded-3 p-3">
                            <div class="fact-title">Family</div>
                            <div class="fact-value">{{ $overViewData->family->name }}</div>
                        </div>
                    @endif

                    @if (!empty($overViewData?->genus?->name))
                        <div class="fact-box bg-white rounded-3 p-3">
                            <div class="fact-title">Genus Species</div>
                            <div class="fact-value">{{ $overViewData->genus->name }}</div>
                        </div>
                    @endif

                    @if (!empty($overViewData?->life_span))
                        <div class="fact-box bg-white rounded-3 p-3">
                            <div class="fact-title">Life Span</div>
                            <div class="fact-value">{{ $overViewData->life_span }}</div>
                        </div>
                    @endif

                    @if (!empty($overViewData?->speed))
                        <div class="fact-box bg-white rounded-3 p-3">
                            <div class="fact-title">Speed</div>
                            <div class="fact-value">{{ $overViewData->speed }}</div>
                        </div>
                    @endif

                    @if (!empty($overViewData?->mass))
                        <div class="fact-box bg-white rounded-3 p-3">
                            <div class="fact-title">Mass</div>
                            <div class="fact-value">{{ $overViewData->mass }}</div>
                        </div>
                    @endif

                    @if (!empty($overViewData?->height))
                        <div class="fact-box bg-white rounded-3 p-3">
                            <div class="fact-title">Height</div>
                            <div class="fact-value">{{ $overViewData->height }}</div>
                        </div>
                    @endif

                    @if (!empty($overViewData?->length))
                        <div class="fact-box bg-white rounded-3 p-3">
                            <div class="fact-title">Length</div>
                            <div class="fact-value">{{ $overViewData->length }}</div>
                        </div>
                    @endif
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
