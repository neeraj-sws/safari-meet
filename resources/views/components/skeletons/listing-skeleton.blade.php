@props(['count' => 6, 'type' => 'safari'])

<section class="skeleton-listing-section">
    <div class="card-container row align-items-stretch justify-content-start gx-3">
        @if ($type === 'safari')
            @for ($i = 0; $i < $count; $i++)
                <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3 d-flex">
                    <div class="skeleton-card">
                        <div class="skeleton-image h-220"></div>
                        <div class="skeleton-card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="skeleton-text title" style="flex: 1; width: 75%;"></div>
                                <div class="skeleton-badge small"></div>
                            </div>
                            <div class="skeleton-text subtitle" style="margin-bottom: 16px;"></div>
                            <div class="skeleton-row align-center mb-3">
                                <div class="skeleton-stat">
                                    <div class="skeleton-text" style="height: 12px; width: 50%; margin: 0 auto 6px;"></div>
                                    <div class="skeleton-text" style="height: 16px; width: 30%; margin: 0 auto;"></div>
                                </div>
                                <div class="skeleton-stat">
                                    <div class="skeleton-text" style="height: 12px; width: 50%; margin: 0 auto 6px;"></div>
                                    <div class="skeleton-text" style="height: 16px; width: 30%; margin: 0 auto;"></div>
                                </div>
                                <div class="skeleton-stat">
                                    <div class="skeleton-text" style="height: 12px; width: 50%; margin: 0 auto 6px;"></div>
                                    <div class="skeleton-text" style="height: 16px; width: 40%; margin: 0 auto;"></div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <div class="skeleton-badge small"></div>
                                <div class="skeleton-badge small"></div>
                                <div class="skeleton-badge small"></div>
                            </div>
                            <div class="skeleton-row align-between mb-3">
                                <div class="skeleton-text" style="height: 14px; width: 35%;"></div>
                                <div class="skeleton-text" style="height: 14px; width: 35%;"></div>
                            </div>
                            <div class="skeleton-button sm" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            @endfor
        @elseif ($type === 'park')
            @for ($i = 0; $i < $count; $i++)
                <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3 d-flex">
                    <div class="skeleton-card">
                        <div class="skeleton-image h-220"></div>
                        <div class="skeleton-card-body">
                            <div class="skeleton-text title" style="margin-bottom: 8px;"></div>
                            <div class="skeleton-text subtitle" style="margin-bottom: 12px;"></div>
                            <div class="skeleton-text line-long" style="margin-bottom: 8px;"></div>
                            <div class="skeleton-text line-medium" style="margin-bottom: 12px;"></div>
                            <div class="mb-3">
                                <div class="skeleton-text" style="height: 12px; width: 60%; margin-bottom: 8px;"></div>
                                <div class="d-flex flex-wrap gap-2">
                                    <div class="skeleton-badge small"></div>
                                    <div class="skeleton-badge small"></div>
                                    <div class="skeleton-badge small"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="skeleton-text" style="height: 12px; width: 60%; margin-bottom: 8px;"></div>
                                <div class="skeleton-text line-medium"></div>
                            </div>
                            <div class="skeleton-button sm" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            @endfor
        @elseif ($type === 'species')
            @for ($i = 0; $i < $count; $i++)
                <div class="col-xl-3 col-md-4 col-sm-6 mb-4 d-flex">
                    <div class="w-100 species-skeleton-card">
                        <!-- Mirror the real `.wildlife-img` structure: image + overlay text -->
                        <div class="wildlife-img" style="position:relative;">
                            <div class="skeleton-image" style="width:100%; aspect-ratio:1/1; border-radius:8px; overflow:hidden;"></div>

                            <!-- Overlay text band (centered) -->
                            <div class="wildlife-text text-center px-4" style="position:absolute; left:0; right:0; bottom:10px; pointer-events:none;">
                                <div class="skeleton-text title" style="height:18px; width:60%; margin:0 auto; border-radius:4px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        @else
            @for ($i = 0; $i < $count; $i++)
                <div class="col-xl-4 col-sm-6 join-safari-card-box mt-3 rounded-3 d-flex">
                    <div class="skeleton-card">
                        <div class="skeleton-image h-220"></div>
                        <div class="skeleton-card-body">
                            <div class="skeleton-text title"></div>
                            <div class="skeleton-text subtitle" style="margin-top: 8px;"></div>
                            <div class="skeleton-text line-long" style="margin-top: 8px;"></div>
                            <div class="skeleton-button sm" style="width: 100%; margin-top: 12px;"></div>
                        </div>
                    </div>
                </div>
            @endfor
        @endif
    </div>
</section>
