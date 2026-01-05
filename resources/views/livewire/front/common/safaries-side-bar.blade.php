<div class="filter-sidebar-wrapper rounded-3 border shadow-sm">
    <div class="filter-sidebar-content rounded-3 p-3">
        <!-- Close Button for Mobile -->
        <div class="d-flex justify-content-end d-lg-none">
            <button class="btn-close" id="closeFilter" aria-label="Close"></button>
        </div>

        <h5 class="filter-title text-blue mb-0">Select Filters</h5>
        <!-- State Selection -->
        @if (count($states) > 0)
        <div class="filter-group py-3 border-bottom mb-0">
            <label for="stateSelect" class="form-label">Select State</label>
            <select wire:model="stateSelect" id="stateSelect" class="form-select select2" placeholder="Select State">
                <option value="">-- Select State --</option>
                @foreach ($states as $stateId => $stateValue)
                <option value="{{ $stateId }}" @selected($stateId==$stateSelect)>
                    {{ ucwords($stateValue) }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <!-- National Parks Selection -->
        @if (count($parks) > 0)
        <div class="filter-group py-3 border-bottom mb-0">
            <label for="speciesSelect" class="form-label">Select Wild Life Sanctuaries</label>
            <select class="form-select select2" id="parkSelect" wire:model.live="parkSelect">
                <option value="">Select Wild Life Sanctuaries</option>
                @foreach ($parks as $parkId => $parkValue)
                <option value="{{ $parkId }}" @selected($parkId==$parkSelect)>
                    {{ ucwords($parkValue) }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="accordion" id="filterAccordion">
            <!-- Budget -->
            @if ($lowestPrice != $highestPrice)
            <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed bg-transparent px-0" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false"
                        aria-controls="collapseFive">
                        Budget
                    </button>
                </h2>
                <div id="collapseFive"
                    class="accordion-collapse collapse {{ $minPrice != $lowestPrice || $maxPrice != $highestPrice ? 'show' : '' }} "
                    aria-labelledby="headingFive" data-bs-parent="#filterAccordion">
                    <div class="accordion-body pt-0">
                        <div class="range-slider position-relative">
                            <div class="slider-track"></div>
                            <input type="range" id="minRange" min="{{ $lowestPrice }}" max="{{ $highestPrice }}"
                                step="5" wire:model.live="minPrice" value="{{ $minPrice }}">
                            <input type="range" id="maxRange" min="{{ $lowestPrice }}" max="{{ $highestPrice }}"
                                step="5" wire:model.live="maxPrice" value="{{ $maxPrice }}">
                        </div>
                        <div class="range-values d-flex justify-content-between mb-2">
                            <span id="minPriceDisplay">₹{{ $minPrice }}</span>
                            <span id="maxPriceDisplay">₹{{ $maxPrice }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Included -->
            @if (count($inclusions) > 0)
            <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed bg-transparent px-0" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                        aria-controls="collapseThree">
                        Included
                    </button>
                </h2>
                <div id="collapseThree"
                    class="accordion-collapse collapse {{ count($inclusion_select) > 0 ? 'show' : '' }} "
                    aria-labelledby="headingThree" data-bs-parent="#filterAccordion">
                    <div class="accordion-body pt-0">
                        @foreach ($inclusions as $id => $item)
                        <div class="form-check" id="inclusionTop-{{ $id }}">
                            <input class="form-check-input" type="checkbox" wire:model.live="inclusion_select"
                                value="{{ $id }}" @selected(in_array($id, $inclusion_select)) id="inclusions-{{ $id }}">
                            <label class="form-check-label" for="inclusions-{{ $id }}">{{ $item }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Total Safari -->
            @if ($lowestSafari != $highestSafari)
            <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                <h2 class="accordion-header" id="headingSafari">
                    <button class="accordion-button collapsed bg-transparent px-0" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseSafari" aria-expanded="false"
                        aria-controls="collapseSafari">
                        Total Safaris
                    </button>
                </h2>
                <div id="collapseSafari"
                    class="accordion-collapse collapse  {{ $minSafari != $lowestSafari || $maxSafari != $highestSafari ? 'show' : '' }} "
                    aria-labelledby="headingSafari" data-bs-parent="#filterAccordion">
                    <div class="accordion-body pt-0">
                        <div class="range-slider position-relative mb-3">
                            <div class="slider-track position-absolute top-50 start-0 w-100 translate-middle-y">
                            </div>
                            <input type="range" id="minSafari" min="{{ $lowestSafari }}" max="{{ $highestSafari }}"
                                step="1" value="{{ $minSafari }}" wire:model.live="minSafari"
                                class="position-absolute w-100">
                            <input type="range" id="maxSafari" min="{{ $lowestSafari }}" max="{{ $highestSafari }}"
                                step="1" wire:model.live="maxSafari" value="{{ $maxSafari }}"
                                class="position-absolute w-100">
                        </div>
                        <div class="range-values d-flex justify-content-between">
                            <span id="minSafariLabel">{{ $minSafari }} Safari</span>
                            <span id="maxSafariLabel">{{ $maxSafari }} Safaris</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- Species Selection -->
        @if (count($species) > 0)
        <div class="filter-group py-3 border-bottom mb-0">
            <label for="speciesSelected" class="form-label">Select Species</label>
            <select class="form-select select2" id="speciesSelected" wire:model.live="speciesSelected">
                <option value="">Select Species</option>
                @foreach ($species as $specieId => $specieValue)
                <option value="{{ $specieId }}" @selected($specieId==$speciesSelected)>
                    {{ ucwords($specieValue) }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <!-- Accordion Filters -->
        <div class="accordion" id="filterAccordion">

            @if (count($bttv_list) > 0)
            <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed bg-transparent px-0" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                        aria-controls="collapseOne">
                        Best time to visit
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse {{ count($bttv_selected) > 0 ? 'show' : '' }}"
                    aria-labelledby="headingOne" data-bs-parent="#filterAccordion">
                    <div class="accordion-body pt-0">
                        @foreach ($bttv_list as $list)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.live="bttv_selected"
                                id="bttv-{{ $list->id }}" value="{{ $list->id }}" @selected(in_array($list->id,
                            $bttv_selected))>

                            <label class="form-check-label" for="bttv-{{ $list->id }}">{{ $list->title }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            <!-- Stay Category -->
            @if (count($stayCategory) > 0)
            <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed bg-transparent px-0" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                        aria-controls="collapseTwo">
                        Stay Category
                    </button>
                </h2>
                <div id="collapseTwo"
                    class="accordion-collapse collapse {{ count($selectedStayCategories) > 0 ? 'show' : '' }} "
                    aria-labelledby="headingTwo" data-bs-parent="#filterAccordion">
                    <div class="accordion-body pt-0">
                        @foreach ($stayCategory as $id => $stay)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="stay-{{ $id }}"
                                wire:model.live="selectedStayCategories" @selected(in_array($id,
                                $selectedStayCategories)) value="{{ $id }}">
                            <label class="form-check-label" for="stay-{{ $id }}">{{ $stay }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            <!-- Theme -->
            @if (count($visitPurposes) > 0)
            <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                <h2 class="accordion-header" id="headingTheme">
                    <button class="accordion-button collapsed bg-transparent px-0" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseTheme" aria-expanded="false"
                        aria-controls="collapseTheme">
                        Theme
                    </button>
                </h2>
                <div id="collapseTheme"
                    class="accordion-collapse collapse {{ count($theme_select) > 0 ? 'show' : '' }} "
                    aria-labelledby="headingTheme" data-bs-parent="#filterAccordion">
                    <div class="accordion-body pt-0">
                        @foreach ($visitPurposes as $id => $visitPurpose)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.live="theme_select"
                                value="{{ $id }}" @selected(in_array($id, $theme_select)) id="photography-{{ $id }}">
                            <label class="form-check-label" for="photography-{{ $id }}">{{ $visitPurpose }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if ($lowestDay != $highestDay)
            <!-- Tour Duration -->
            <div class="accordion-item bg-transparent border-0 border-bottom rounded-0">
                <h2 class="accordion-header" id="headingDuration">
                    <button class="accordion-button collapsed bg-transparent px-0" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseDuration" aria-expanded="false"
                        aria-controls="collapseDuration">
                        Tour Duration
                    </button>
                </h2>
                <div id="collapseDuration"
                    class="accordion-collapse collapse  {{ $minday != $lowestDay || $maxday != $highestDay ? 'show' : '' }}  "
                    aria-labelledby="headingDuration" data-bs-parent="#filterAccordion">
                    <div class="accordion-body pt-0">
                        <div class="range-slider position-relative mb-3">
                            <div class="slider-track position-absolute top-50 start-0 w-100 translate-middle-y">
                            </div>
                            <input type="range" id="minDays" min="{{ $lowestDay }}" max="{{ $highestDay }}" step="1"
                                value="{{ $minday }}" wire:model.live="minday" class="position-absolute w-100"
                                style="pointer-events: none;">
                            <input type="range" id="maxDays" min="{{ $lowestDay }}" max="{{ $highestDay }}" step="1"
                                wire:model.live="maxday" value="{{ $maxday }}" class="position-absolute w-100">
                        </div>
                        <div class="range-values d-flex justify-content-between">
                            <span id="minLabel">{{ $minday }}D</span>
                            <span id="maxLabel">{{ $maxday }}D</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
