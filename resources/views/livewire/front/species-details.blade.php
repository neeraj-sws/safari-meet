<div>
    <!-- Hero Section -->
    <section id="home-hero"
        class="park-home-hero d-flex align-items-center justify-content-center text-center text-white mb-2">
        <div class="container-fluid container-padding">
            <div class="bannertext text-center">
                <h1 class="text-white">Home of Barasingha</h1>
                <h3 class="text-white fw-normal">Kanha National Park</h3>
            </div>
        </div>
    </section>
    <!-- Tabs Navigation -->
    <section id="package-details-nav" class="mb-4 border-bottom">
        <div class="container-lg container-inner-padding">
            <nav class="overflow-auto">
                <ul class="nav nav-pills flex-nowrap flex-sm-nowrap d-flex border-0 gap-2" id="packageTab"
                    role="tablist" style="white-space: nowrap;">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold bg-white {{ $activeTab === 'overview' ? 'active' : '' }}"
                            wire:click="$set('activeTab', 'overview')" type="button" role="tab">
                            Overview
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link fw-semibold rounded-pill {{ $activeTab === 'packages' ? 'active' : '' }}"
                            wire:click="$set('activeTab', 'packages')" type="button" role="tab">
                            Packages
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold rounded-pill {{ $activeTab === 'safaris' ? 'active' : '' }}"
                            wire:click="$set('activeTab', 'safaris')" type="button" role="tab">
                            Shared Safaris
                        </button>
                    </li>
                </ul>
            </nav>

        </div>
    </section>
    <main>
        <div class="container-lg container-inner-padding mb-5">
            <!-- Tabs Content -->
            <div class="tab-content" id="ParkTabContent">
                <div class="tab-pane fade {{ $activeTab === 'overview' ? 'show active' : '' }}" id="overview"
                    role="tabpanel" aria-labelledby="overview-tab">
                    <div class="row gx-3 flex-lg-row flex-column-reverse">

                        <!-- Sidebar Filter -->
                        <aside class="col-12 col-lg-4 col-xl-3">

                            <div class="filter-sidebar-wrapper filter-sidebar-wrapper-park border-0 mb-xl-0 mb-3">
                                <div class="quote-form">
                                    <!-- Safari Quote Request Box -->
                                    <div class="card py-4 px-lg-3 px-sm-4 px-3 rounded-3 shadow-sm border-muted">
                                        <h3 class="fw-bold text-blue text-center mb-3">
                                            Get Free Quotes
                                        </h3>

                                        <form wire:submit.prevent="submit">
                                            <!-- Safaris & Travellers -->
                                            <div class="row gx-3">
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Safaris</label>
                                                    <input type="number" class="form-control" wire:model="safari_name">
                                                    @error('safari_name')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Travellers</label>
                                                    <input type="number" class="form-control" wire:model="travellers">
                                                    @error('travellers')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Accommodation -->
                                            <div class="mb-3">
                                                <label class="form-label mb-1">Accommodation</label>
                                                <select class="form-select" wire:model="accommodation">
                                                    <option value="">Select...</option>
                                                    <option>Budget</option>
                                                    <option>Mid-range</option>
                                                    <option>Luxury</option>
                                                </select>
                                                @error('accommodation')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Dates -->
                                            <div class="row gx-3">
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">Start Date</label>
                                                    <input type="date" wire:model.live="start_date" id="start_date"
                                                        name="start_date" class="form-control"
                                                        min="{{ now()->format('Y-m-d') }}"
                                                        onclick="this.showPicker && this.showPicker()"
                                                        wire:change="$set('end_date', '')">
                                                    @error('start_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 col-sm-6 mb-3">
                                                    <label class="form-label mb-1">End Date</label>
                                                    <input type="date" wire:model="end_date" id="end_date"
                                                        name="end_date" class="form-control"
                                                        min="{{ $start_date ?? now()->format('Y-m-d') }}"
                                                        onclick="this.showPicker && this.showPicker()">
                                                    @error('end_date')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="">
                                                <button type="submit"
                                                    class="btn blue-btn-hover rounded-pill w-100 text-white">
                                                    Send Request
                                                </button>
                                            </div>

                                            <!-- Note -->
                                            <p class="small mt-2 mb-0 text-center text-dark">
                                                *We'll share your request with all operators in the park and send you
                                                their quotes.
                                            </p>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </aside>
                        <!-- Main Content -->
                        <div class="col-12 col-lg-8 col-xl-9 main-content-scroll">
                            <div
                                class="bg-white packagetab-navbar species-detail-tabs rounded-3 px-4 py-1 shadow-sm mb-4">
                                <nav class="">
                                    <ul class="nav nav-pills border-0 flex-nowrap flex-row flex-lg-row justify-content-md-center"
                                        id="parkTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link active fw-normal rounded-pill"
                                                id="legacy-tab" data-bs-toggle="tab" data-bs-target="#legacy"
                                                role="tab" aria-controls="legacy" aria-selected="true">Legacy
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link fw-normal rounded-pill"
                                                id="traits-tab" data-bs-toggle="tab" data-bs-target="#traits"
                                                role="tab" aria-controls="traits" aria-selected="true">Physical
                                                Traits</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link fw-normal rounded-pill"
                                                id="lifestyle-tab" data-bs-toggle="tab" data-bs-target="#lifestyle"
                                                role="tab" aria-controls="lifestyle"
                                                aria-selected="false">Lifestyle</a>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link fw-normal rounded-pill"
                                                id="threats-tab" data-bs-toggle="tab" data-bs-target="#threats"
                                                role="tab" aria-controls="threats"
                                                aria-selected="false">Threats</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link fw-normal rounded-pill"
                                                id="facts-tab" data-bs-toggle="tab" data-bs-target="#facts"
                                                role="tab" aria-controls="facts" aria-selected="false">Intresting
                                                Facts</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="legacy" role="tabpanel"
                                    aria-labelledby="legacy-tab">
                                    <div class="heading-text text-center mb-xl-4 mb-3">
                                        <div class="">
                                            <h2 class="mb-0 text-accent">About Royal Bengal Tiger</h2>
                                            <img src="{{ asset('front-assets/images/blue-border-vector.png') }}"
                                                alt="Vector-Border" class="vector-border-bottom">
                                        </div>
                                    </div>
                                    <div class="about-species mb-0">
                                        <div class="row mb-3 gx-2 align-items-center">
                                            <div class="col-12">
                                                <div class="row flex-md-row flex-column-reverse">
                                                    <div class="col-md-6">
                                                        <p>
                                                            The <strong>Royal Bengal Tiger</strong>, India’s national
                                                            animal, is
                                                            a symbol of
                                                            grace, strength, and power. As the most numerous of all
                                                            tiger
                                                            subspecies, this majestic predator rules over diverse
                                                            landscapes—from the swampy mangroves of the Sundarbans to
                                                            the dense
                                                            sal forests of Central India and the alpine foothills of
                                                            Bhutan. Its
                                                            presence in the wild is not just a spectacle of nature but a
                                                            vital
                                                            sign of ecosystem health. A keystone species, the tiger
                                                            influences
                                                            prey populations and vegetation patterns, indirectly shaping
                                                            entire
                                                            habitats.
                                                            More than a species, it’s a legacy woven into the culture,
                                                            mythology, art, and identity of South Asia.
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="img-1 rounded-3 bg-blue key-info-img">
                                                            <img src="{{ asset('front-assets/images/animal-images/tigerjpg.avif') }}"
                                                                alt="Animal" class="img-fluid rounded-2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <p>
                                                    Today, it is every Nature and Wildlife Travelers bucket-list animal
                                                    to view on safari in India, and India is the only place in the world
                                                    one is likely to see the magnificient Tiger in the Wild. India has
                                                    50 Tiger Reserves today, and with strict Wildlife Laws and
                                                    Protection, they are well protected within the confines of these
                                                    Reserves.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="heading-text text-center mb-xl-4 mb-3">
                                        <div class="">
                                            <h2 class="mb-0 text-accent">Zoological Identity</h2>
                                            <img src="{{ asset('front-assets/images/blue-border-vector.png') }}"
                                                alt="Vector-Border" class="vector-border-bottom">
                                        </div>
                                    </div>
                                    <div class="mb-4 species-facts rounded-3">
                                        <div class="fact-box bg-white rounded-3 p-3">
                                            <div class="fact-title">Category</div>
                                            <div class="fact-value">Mammalia</div>
                                        </div>
                                        <div class="fact-box bg-white rounded-3 p-3">
                                            <div class="fact-title">Family</div>
                                            <div class="fact-value">Felidae</div>
                                        </div>
                                        <div class="fact-box bg-white rounded-3 p-3">
                                            <div class="fact-title">Genus Species</div>
                                            <div class="fact-value">Panthera tigris</div>
                                        </div>
                                        <div class="fact-box bg-white rounded-3 p-3">
                                            <div class="fact-title">Life Span</div>
                                            <div class="fact-value">20–25 Years</div>
                                        </div>
                                        <div class="fact-box bg-white rounded-3 p-3">
                                            <div class="fact-title">Speed</div>
                                            <div class="fact-value">50–90 km/h</div>
                                        </div>
                                        <div class="fact-box bg-white rounded-3 p-3">
                                            <div class="fact-title">Mass</div>
                                            <div class="fact-value">~220 kg</div>
                                        </div>
                                        <div class="fact-box bg-white rounded-3 p-3">
                                            <div class="fact-title">Height</div>
                                            <div class="fact-value">90–110 cm</div>
                                        </div>
                                        <div class="fact-box bg-white rounded-3 p-3">
                                            <div class="fact-title">Length</div>
                                            <div class="fact-value">2.5–3.5 meters</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="traits" role="tabpanel"
                                    aria-labelledby="traits-tab">
                                    <div>
                                        <div class="heading-text text-center mb-xl-4 mb-3">
                                            <div class="">
                                                <h2 class="mb-0 text-accent">Adaptations</h2>
                                                <img src="{{ asset('front-assets/images/blue-border-vector.png') }}"
                                                    alt="Vector-Border" class="vector-border-bottom">
                                            </div>
                                        </div>
                                        <div class="appearance-box">
                                            <div class="text-center mb-4">
                                                <p class="mt-3">Tigers have evolved into apex predators, perfectly
                                                    tuned
                                                    to thrive in diverse habitats. Here's how:</p>
                                            </div>

                                            <div class="row g-4 mb-4">
                                                <!-- Physical Adaptations -->
                                                <div class="col-md-6">
                                                    <div class="card h-100 shadow-sm border-0 rounded-4">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-3 text-blue">
                                                                <i class="fa-solid fa-paw me-1"></i> Physical
                                                                Adaptations
                                                            </h5>
                                                            <ul class="ps-3 mb-0">
                                                                <li><strong>Stripes for Stealth:</strong> Camouflages in
                                                                    forests by blending with light and shadow.</li>
                                                                <li><strong>Muscular Build:</strong> Broad shoulders &
                                                                    limbs allow powerful hunting moves.</li>
                                                                <li><strong>Flexible Spine:</strong> Helps in agile
                                                                    turns while chasing prey.</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Sensory Adaptations -->
                                                <div class="col-md-6">
                                                    <div class="card h-100 shadow-sm border-0 rounded-4">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-3 text-blue">
                                                                <i class="fa-solid fa-paw me-1"></i> Sensory
                                                                Adaptations
                                                            </h5>
                                                            <ul class="ps-3 mb-0">
                                                                <li><strong>Night Vision:</strong> Sees 6× better than
                                                                    humans in the dark.</li>
                                                                <li><strong>Whisker Sensitivity:</strong> Detects air
                                                                    currents in pitch-black surroundings.</li>
                                                                <li><strong>Keen Hearing:</strong> Can hear up to 60 kHz
                                                                    to detect even silent prey.</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Behavioral Adaptations -->
                                                <div class="col-12">
                                                    <div class="card h-100 shadow-sm border-0 rounded-4">
                                                        <div class="card-body">
                                                            <h5 class="card-title mb-3 text-blue"><i
                                                                    class="fa-solid fa-paw me-1"></i> Behavioral
                                                                Adaptations</h5>
                                                            <ul class="ps-3 mb-0">
                                                                <li><strong>Ambush Strategy:</strong> Attacks from
                                                                    behind rather than chasing.</li>
                                                                <li><strong>Solitary Nature:</strong> Maintains its own
                                                                    territory, reduces competition.</li>
                                                                <li><strong>Swimming Skill:</strong> Hunts in water,
                                                                    especially in the Sundarbans.</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="appearance-box">
                                        <div class="heading-text text-center mb-xl-4 mb-3">
                                            <div class="">
                                                <h2 class="mb-0 text-accent">Appearance
                                                </h2>
                                                <img src="{{ asset('front-assets/images/blue-border-vector.png') }}"
                                                    alt="Vector-Border" class="vector-border-bottom">
                                            </div>
                                        </div>
                                        <p>The Royal Bengal Tiger is one of the most visually stunning creatures in the
                                            wild. Its impressive build, vibrant colors, and unique patterns make it
                                            easily
                                            distinguishable among all big cats. Every aspect of its physical form is
                                            designed for survival, power, and stealth in the jungle.
                                        </p>
                                        <div>
                                            <div class="accordion all-accordion p-3 rounded-3 dark-grey-bg mb-4"
                                                id="appearanceAccordion">
                                                <!-- 1. Coat Color & Pattern -->
                                                <div class="accordion-item mb-3 rounded-3">
                                                    <h2 class="accordion-header rounded-top-3" id="headingOne">
                                                        <button class="accordion-button rounded-top-3 rounded-bottom-0"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne" aria-expanded="true">
                                                            Coat Color & Pattern
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        data-bs-parent="#appearanceAccordion">
                                                        <div class="accordion-body pt-0">
                                                            A rich orange coat covered with bold black stripes allows
                                                            the tiger to camouflage perfectly in forest shadows and tall
                                                            grasses.
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 2. Unique Stripe Identity -->
                                                <div class="accordion-item mb-3 rounded-3">
                                                    <h2 class="accordion-header rounded-top-3" id="headingTwo">
                                                        <button
                                                            class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseTwo">
                                                            Unique Stripe Identity
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                                        data-bs-parent="#appearanceAccordion">
                                                        <div class="accordion-body pt-0">
                                                            No two tigers have the same stripe pattern. These unique
                                                            markings help researchers identify individuals in the wild.
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 3. White Underside Contrast -->
                                                <div class="accordion-item mb-3 rounded-3">
                                                    <h2 class="accordion-header rounded-top-3" id="headingThree">
                                                        <button
                                                            class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseThree">
                                                            White Underside Contrast
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse"
                                                        data-bs-parent="#appearanceAccordion">
                                                        <div class="accordion-body pt-0">
                                                            The chest, belly, and inner limbs are white, enhancing the
                                                            contrast with the rest of its orange-black body and
                                                            highlighting its muscular structure.
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 4. Facial Structure & Expression -->
                                                <div class="accordion-item mb-3 rounded-3">
                                                    <h2 class="accordion-header rounded-top-3" id="headingFour">
                                                        <button
                                                            class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseFour">
                                                            Facial Structure & Expression
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFour" class="accordion-collapse collapse"
                                                        data-bs-parent="#appearanceAccordion">
                                                        <div class="accordion-body pt-0">
                                                            The tiger’s broad face, amber eyes, and distinct cheek ruffs
                                                            give it a powerful and regal expression, making its gaze
                                                            both intense and captivating.
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 5. Size and Physical Build -->
                                                <div class="accordion-item mb-3 rounded-3">
                                                    <h2 class="accordion-header rounded-top-3" id="headingFive">
                                                        <button
                                                            class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseFive">
                                                            Size and Physical Build
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFive" class="accordion-collapse collapse"
                                                        data-bs-parent="#appearanceAccordion">
                                                        <div class="accordion-body pt-0">
                                                            Adult males can weigh up to 220 kg and stretch around 10
                                                            feet long, making them among the largest of all tiger
                                                            subspecies. Females are slightly smaller but equally agile.
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 6. Tail for Balance & Communication -->
                                                <div class="accordion-item mb-3 rounded-3">
                                                    <h2 class="accordion-header rounded-top-3" id="headingSix">
                                                        <button
                                                            class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseSix">
                                                            Tail for Balance & Communication
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSix" class="accordion-collapse collapse"
                                                        data-bs-parent="#appearanceAccordion">
                                                        <div class="accordion-body pt-0">
                                                            Its long tail, ringed with black, not only maintains balance
                                                            while running or turning but also plays a role in signaling
                                                            mood and intention.
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 7. Paws & Claws -->
                                                <div class="accordion-item mb-3 rounded-3">
                                                    <h2 class="accordion-header rounded-top-3" id="headingSeven">
                                                        <button
                                                            class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseSeven">
                                                            Paws & Claws
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSeven" class="accordion-collapse collapse"
                                                        data-bs-parent="#appearanceAccordion">
                                                        <div class="accordion-body pt-0">
                                                            Large padded paws ensure silent movement through the forest,
                                                            while strong retractable claws provide deadly grip during
                                                            hunting.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive" id="distance-table">
                                            <table class="table table-bordered table-striped text-center align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Trait</th>
                                                        <th>Male</th>
                                                        <th>Female</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Length</td>
                                                        <td>2.7 to 3.1 meters (with tail)</td>
                                                        <td>2.4 to 2.6 meters</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Weight</td>
                                                        <td>220 to 300 kg</td>
                                                        <td>120 to 180 kg</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Height</td>
                                                        <td>90–110 cm at shoulder</td>
                                                        <td>80–90 cm</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="lifestyle" role="tabpanel"
                                    aria-labelledby="lifestyle-tab">
                                    <div class="">
                                        <div class="heading-text text-center mb-4">
                                            <h2 class="mb-0 text-accent">Diet of Royal Bengal Tiger</h2>
                                            <img src="{{ asset('front-assets/images/blue-border-vector.png') }}"
                                                alt="Vector Border" class="vector-border-bottom">
                                        </div>
                                        <div class="row justify-content-center align-items-center">
                                            <!-- Diet Summary -->
                                            <div class="col-12 mb-4">
                                                <p class="mb-0">
                                                    The Bengal tiger is a <strong>strict carnivore</strong> that
                                                    consumes <strong>10–25 kg of meat</strong> in one sitting
                                                    and can <strong>fast for several days</strong> if food is
                                                    scarce.
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <div class="card shadow-sm border-0 rounded-3 mb-4">
                                                    <!-- Common Prey Column -->
                                                    <div class="row g-0 align-items-center">
                                                        <!-- Image Column -->
                                                        <div class="col-md-5">
                                                            <div class="p-3 h-100 d-flex align-items-center">
                                                                <img src="{{ asset('front-assets/images/animal-images/species-2.png') }}"
                                                                    alt="Animal" class="img-fluid rounded-2 w-100">
                                                            </div>
                                                        </div>
                                                        <!-- Common Prey Column -->
                                                        <div class="col-md-7 appearance-box">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-3">
                                                                    <i class="fa-solid fa-paw me-1"></i> Common Prey
                                                                </h5>
                                                                <ul class="ps-3 mb-0">
                                                                    <li><strong>Ungulates:</strong> Sambar, chital,
                                                                        barasingha, nilgai, gaur</li>
                                                                    <li><strong>Wild Boar:</strong> Highly preferred due
                                                                        to abundance</li>
                                                                    <li><strong>Occasional Diet:</strong> Langurs,
                                                                        peafowl, porcupines, reptiles, sometimes fish or
                                                                        birds</li>
                                                                    <li><strong>Livestock:</strong> In human-dominated
                                                                        fringes, tigers may attack cattle, leading to
                                                                        conflict</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Hunting Strategy -->
                                                    <div class="row g-0 align-items-center">
                                                        <!-- Hunting Strategy Column -->
                                                        <div class="col-md-7 appearance-box">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-3">
                                                                    <i class="fa-solid fa-paw me-1"></i> Hunting
                                                                    Strategy
                                                                </h5>
                                                                <ul class="ps-3 mb-0">
                                                                    <li><strong>Stealth Over Speed:</strong> Stalks prey
                                                                        silently through dense cover</li>
                                                                    <li><strong>Target Zones:</strong> Throat (trachea)
                                                                        or nape
                                                                        (spinal cord)</li>
                                                                    <li><strong>Active Time:</strong> Mostly hunts at
                                                                        night or
                                                                        twilight (crepuscular)</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- Image Column -->
                                                        <div class="col-md-5">
                                                            <div class="p-3 h-100 d-flex align-items-center">
                                                                <img src="{{ asset('front-assets/images/animal-images/species-2.png') }}"
                                                                    alt="Animal" class="img-fluid rounded-2 w-100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="heading-text text-center mb-xl-4 mb-3">
                                            <div class="">
                                                <h2 class="mb-0 text-accent">Habitat of the Royal Bengal Tiger</h2>
                                                <img src="{{ asset('front-assets/images/blue-border-vector.png') }}"
                                                    alt="Vector-Border" class="vector-border-bottom">
                                            </div>
                                        </div>
                                        <div class="appearance-box">
                                            <p>
                                                The Royal Bengal Tiger inhabits a diverse range of environments,
                                                including
                                                tropical forests, grasslands, wetlands, and mangrove swamps. From the
                                                Sundarbans’ dense mangrove deltas to the sal and bamboo forests of
                                                Central
                                                India, these majestic predators prefer areas with thick vegetation,
                                                water
                                                sources, and a healthy population of prey. Tiger reserves and national
                                                parks
                                                offer them safe spaces with minimal human interference, allowing them to
                                                roam, hunt, and breed effectively.
                                            </p>
                                            <div class="row align-items-center">
                                                <div class="col-xl-7 mb-3">
                                                    <!-- Key Habitat Features -->
                                                    <h3 class="-3 text-secondary">Key Features of Tiger Habitat
                                                    </h3>
                                                    <ul class="">
                                                        <li class="mb-2">
                                                            <strong>Thick Vegetation:</strong> Offers camouflage and
                                                            cover
                                                            for
                                                            stalking prey.
                                                        </li>
                                                        <li class="mb-2">
                                                            <strong>Water Sources:</strong> Essential for hydration,
                                                            cooling,
                                                            and
                                                            hunting.
                                                        </li>
                                                        <li class="mb-2">
                                                            <strong>Rich Prey Base:</strong> Includes deer, wild boars,
                                                            and
                                                            antelopes.
                                                        </li>
                                                        <li class="mb-2">
                                                            <strong>Expansive Territory:</strong> Especially for males
                                                            who
                                                            need
                                                            60–100 sq. km.
                                                        </li>
                                                        <li class="mb-2">
                                                            <strong>Minimal Human Activity:</strong> Core zones of
                                                            protected
                                                            reserves are ideal.
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-xl-5 mb-3">
                                                    <div class="vertical-image-col">
                                                        <img src="{{ asset('front-assets/images/park-detail/detail-2.jpg') }}"
                                                            alt="Detail-2" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Habitat Section End -->


                                    </div>

                                </div>

                                <div class="tab-pane fade" id="threats" role="tabpanel"
                                    aria-labelledby="threats-tab">
                                    <div class="heading-text text-center mb-xl-4 mb-3">
                                        <div class="">
                                            <h2 class="mb-0 text-accent">Threats to the Royal Bengal Tiger</h2>
                                            <img src="{{ asset('front-assets/images/blue-border-vector.png') }}"
                                                alt="Vector-Border" class="vector-border-bottom">
                                        </div>
                                    </div>
                                    <!-- Threats Accordion Start -->
                                    <div class="mb-4">
                                        <p>
                                            Despite being apex predators, Royal Bengal Tigers face serious threats
                                            primarily due to human activities and environmental changes. Below are the
                                            key challenges that endanger their survival, explained in detail:
                                        </p>
                                        <div class="row align-items-center mb-lg-4 right-image-col">
                                            <div class="col-xl-7 mb-3">
                                                <div class="accordion all-accordion p-3 rounded-3 dark-grey-bg"
                                                    id="tigerThreatsAccordion">

                                                    <!-- Habitat Loss -->
                                                    <div class="accordion-item mb-3 rounded-3">
                                                        <h2 class="accordion-header rounded-top-3"
                                                            id="threat1-heading">
                                                            <button
                                                                class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#threat1" aria-expanded="false"
                                                                aria-controls="threat1">
                                                                Habitat Loss
                                                            </button>
                                                        </h2>
                                                        <div id="threat1" class="accordion-collapse collapse"
                                                            aria-labelledby="threat1-heading"
                                                            data-bs-parent="#tigerThreatsAccordion">
                                                            <div class="accordion-body pt-0">
                                                                Forests are being rapidly cleared for agriculture,
                                                                mining,
                                                                infrastructure, and urban development. This leads to
                                                                shrinking
                                                                and fragmented tiger territories, making it difficult
                                                                for them
                                                                to find food, shelter, or mates. Isolated populations
                                                                become
                                                                more vulnerable to inbreeding and local extinction.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Poaching & Wildlife Trade -->
                                                    <div class="accordion-item mb-3 rounded-3">
                                                        <h2 class="accordion-header rounded-top-3"
                                                            id="threat2-heading">
                                                            <button
                                                                class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#threat2" aria-expanded="false"
                                                                aria-controls="threat2">
                                                                Poaching & Illegal Wildlife Trade
                                                            </button>
                                                        </h2>
                                                        <div id="threat2" class="accordion-collapse collapse"
                                                            aria-labelledby="threat2-heading"
                                                            data-bs-parent="#tigerThreatsAccordion">
                                                            <div class="accordion-body pt-0">
                                                                Tigers are hunted for their skin, bones, and body parts,
                                                                which
                                                                are in high demand for traditional medicine and luxury
                                                                markets.
                                                                Despite strict laws, black market networks and weak
                                                                enforcement
                                                                continue to threaten their survival.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Human-Wildlife Conflict -->
                                                    <div class="accordion-item mb-3 rounded-3">
                                                        <h2 class="accordion-header rounded-top-3"
                                                            id="threat3-heading">
                                                            <button
                                                                class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#threat3" aria-expanded="false"
                                                                aria-controls="threat3">
                                                                Human-Wildlife Conflict
                                                            </button>
                                                        </h2>
                                                        <div id="threat3" class="accordion-collapse collapse"
                                                            aria-labelledby="threat3-heading"
                                                            data-bs-parent="#tigerThreatsAccordion">
                                                            <div class="accordion-body pt-0">
                                                                When tigers stray into villages near reserves, they
                                                                sometimes
                                                                kill livestock, prompting revenge attacks from farmers.
                                                                Encroachment into buffer zones increases such
                                                                encounters, posing
                                                                a risk to both humans and tigers.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Prey Depletion -->
                                                    <div class="accordion-item mb-3 rounded-3">
                                                        <h2 class="accordion-header rounded-top-3"
                                                            id="threat4-heading">
                                                            <button
                                                                class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#threat4" aria-expanded="false"
                                                                aria-controls="threat4">
                                                                Prey Depletion
                                                            </button>
                                                        </h2>
                                                        <div id="threat4" class="accordion-collapse collapse"
                                                            aria-labelledby="threat4-heading"
                                                            data-bs-parent="#tigerThreatsAccordion">
                                                            <div class="accordion-body pt-0">
                                                                The decline in natural prey such as deer and wild
                                                                boar—due to
                                                                overhunting and habitat degradation—forces tigers to
                                                                roam
                                                                farther, increasing the chance of conflict and
                                                                starvation.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Climate Change -->
                                                    <div class="accordion-item mb-3 rounded-3">
                                                        <h2 class="accordion-header rounded-top-3"
                                                            id="threat5-heading">
                                                            <button
                                                                class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#threat5" aria-expanded="false"
                                                                aria-controls="threat5">
                                                                Climate Change
                                                            </button>
                                                        </h2>
                                                        <div id="threat5" class="accordion-collapse collapse"
                                                            aria-labelledby="threat5-heading"
                                                            data-bs-parent="#tigerThreatsAccordion">
                                                            <div class="accordion-body pt-0">
                                                                In the Sundarbans, rising sea levels and increased
                                                                salinity are
                                                                submerging tiger habitats. Changing rainfall patterns
                                                                and
                                                                extreme weather further degrade ecosystems across India.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Genetic Isolation -->
                                                    <div class="accordion-item mb-3 rounded-3">
                                                        <h2 class="accordion-header rounded-top-3"
                                                            id="threat6-heading">
                                                            <button
                                                                class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#threat6" aria-expanded="false"
                                                                aria-controls="threat6">
                                                                Genetic Isolation
                                                            </button>
                                                        </h2>
                                                        <div id="threat6" class="accordion-collapse collapse"
                                                            aria-labelledby="threat6-heading"
                                                            data-bs-parent="#tigerThreatsAccordion">
                                                            <div class="accordion-body pt-0">
                                                                Fragmented habitats prevent tigers from interbreeding
                                                                across
                                                                regions, leading to low genetic diversity. This can
                                                                weaken
                                                                populations, reduce adaptability, and increase
                                                                susceptibility to
                                                                disease.
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-xl-5 mb-3">
                                                <div class="vertical-image-col">
                                                    <img src="{{ asset('front-assets/images/park-detail/detail-2.jpg') }}"
                                                        alt="Detail-2" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Threats Accordion End -->

                                    <div class="">
                                        <h3 class="text-blue mb-3">Conservation
                                            Efforts</h3>
                                        <ul class="fs-5 ps-3 list-unstyled">
                                            <li class="mt-3 d-flex align-items-start gap-1">
                                                <i class="fa-solid fa-angles-right mt-1 me-1 fs-6"></i>
                                                <p class="mb-2"><strong>Project Tiger:</strong> India’s flagship
                                                    program
                                                    launched in
                                                    1973 to ensure a viable population of Bengal tigers in their natural
                                                    habitats.</p>
                                            </li>
                                            <li class="mt-3 d-flex align-items-start gap-1">
                                                <i class="fa-solid fa-angles-right mt-1 me-1 fs-6"></i>
                                                <p class="mb-2"><strong>Tiger Reserves:</strong> Over 50 protected
                                                    reserves across
                                                    India provide safe breeding and hunting grounds.</p>
                                            </li>
                                            <li class="mt-3 d-flex align-items-start gap-1">
                                                <i class="fa-solid fa-angles-right mt-1 me-1 fs-6"></i>
                                                <p class="mb-2"><strong>Camera Trap Monitoring:</strong> Helps in
                                                    individual tiger
                                                    identification, tracking movement, and estimating population
                                                    density.</p>
                                            </li>
                                            <li class="mt-3 d-flex align-items-start gap-1">
                                                <i class="fa-solid fa-angles-right mt-1 me-1 fs-6"></i>
                                                <p class="mb-2"><strong>Community Participation:</strong> Local
                                                    villagers are
                                                    employed as forest guards and educated to reduce conflict and
                                                    encourage
                                                    coexistence.</p>
                                            </li>
                                            <li class="mt-3 d-flex align-items-start gap-1">
                                                <i class="fa-solid fa-angles-right mt-1 me-1 fs-6"></i>
                                                <p class="mb-2"><strong>Global Cooperation:</strong> India
                                                    collaborates
                                                    with
                                                    countries like Nepal and Bhutan under the Global Tiger Initiative.
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="facts" role="tabpanel"
                                    aria-labelledby="facts-tab">
                                    <div class="heading-text text-center mb-xl-4 mb-3">
                                        <div class="">
                                            <h2 class="mb-0 text-accent">Interesting Facts about the Royal Bengal Tiger
                                            </h2>
                                            <img src="{{ asset('front-assets/images/blue-border-vector.png') }}"
                                                alt="Vector-Border" class="vector-border-bottom">
                                        </div>
                                    </div>
                                    <!-- Interesting Facts Cards Section -->
                                    <div class="species-intrestings-facts">
                                        <p>
                                            Discover fascinating traits and behaviors of the Royal Bengal Tiger through
                                            these bite-sized facts presented as stylish cards.
                                        </p>

                                        <div class="row g-4 mt-4">

                                            <!-- Fact 1 -->
                                            <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4 mt-0 mb-4">
                                                <div
                                                    class="h-100 p-3 bg-white rounded-3 shadow-sm position-relative border-start border-2 border-blue fact-card">
                                                    <h5 class="fw-semibold">Unique Stripe Identity</h5>
                                                    <p class="mb-0">Each tiger has a unique stripe pattern — just
                                                        like
                                                        human fingerprints. It's used by scientists for identification.
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Fact 2 -->
                                            <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4 mt-0 mb-4">
                                                <div
                                                    class="h-100 p-3 bg-white rounded-3 shadow-sm position-relative border-start border-2 border-blue fact-card">
                                                    <h5 class="fw-semibold">Excellent Swimmers</h5>
                                                    <p class="mb-0">Unlike most big cats, Bengal tigers enjoy water
                                                        and
                                                        are powerful swimmers — especially in the Sundarbans.</p>
                                                </div>
                                            </div>

                                            <!-- Fact 3 -->
                                            <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4 mt-0 mb-4">
                                                <div
                                                    class="h-100 p-3 bg-white rounded-3 shadow-sm position-relative border-start border-2 border-blue fact-card">
                                                    <h5 class="fw-semibold">Roar Travels 3 KM</h5>
                                                    <p class="mb-0">A Bengal tiger’s roar can be heard from up to 3
                                                        kilometers away — a vital long-range communication tool.</p>
                                                </div>
                                            </div>

                                            <!-- Fact 4 -->
                                            <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4 mt-0 mb-4">
                                                <div
                                                    class="h-100 p-3 bg-white rounded-3 shadow-sm position-relative border-start border-2 border-blue fact-card">
                                                    <h5 class="fw-semibold">Superior Night Vision</h5>
                                                    <p class="mb-0">Tigers can see 6x better than humans in the dark,
                                                        allowing them to be effective nocturnal hunters.</p>
                                                </div>
                                            </div>

                                            <!-- Fact 5 -->
                                            <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4 mt-0 mb-4">
                                                <div
                                                    class="h-100 p-3 bg-white rounded-3 shadow-sm position-relative border-start border-2 border-blue fact-card">
                                                    <h5 class="fw-semibold">Huge Territories</h5>
                                                    <p class="mb-0">Male Bengal tigers may control territories up to
                                                        100
                                                        sq. km — marking it with scent to avoid clashes.</p>
                                                </div>
                                            </div>

                                            <!-- Fact 6 -->
                                            <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4 mt-0 mb-4">
                                                <div
                                                    class="h-100 p-3 bg-white rounded-3 shadow-sm position-relative border-start border-2 border-blue fact-card">
                                                    <h5 class="fw-semibold">Silent Walkers</h5>
                                                    <p class="mb-0">Tigers’ soft-padded feet allow them to walk
                                                        silently, making them expert ambush hunters in the wild.</p>
                                                </div>
                                            </div>

                                            <!-- Fact 7 -->
                                            <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4 mt-0 mb-4">
                                                <div
                                                    class="h-100 p-3 bg-white rounded-3 shadow-sm position-relative border-start border-2 border-blue fact-card">
                                                    <h5 class="fw-semibold">Powerful Bite</h5>
                                                    <p class="mb-0">With a bite force over 1,000 PSI, Bengal tigers
                                                        can
                                                        crush bone — giving them dominance in the food chain.</p>
                                                </div>
                                            </div>

                                            <!-- Fact 8 -->
                                            <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4 mt-0 mb-4">
                                                <div
                                                    class="h-100 p-3 bg-white rounded-3 shadow-sm position-relative border-start border-2 border-blue fact-card">
                                                    <h5 class="fw-semibold">Conservation Success</h5>
                                                    <p class="mb-0">Project Tiger and protected reserves have helped
                                                        Bengal tigers slowly recover after being pushed toward
                                                        extinction.</p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="tab-pane fade {{ $activeTab === 'packages' ? 'show active' : '' }}" id="packages"
                    role="tabpanel" aria-labelledby="packages-tab">
                    <div class="row g-3 position-relative mb-5" style="min-height: 100vh;">
                        @include('livewire.front.safari-package')
                    </div>
                </div>

                <div class="tab-pane fade {{ $activeTab === 'safaris' ? 'show active' : '' }}" id="safaris"
                    role="tabpanel" aria-labelledby="safaris-tab">
                    <div class="row g-3 position-relative mb-5" style="min-height: 100vh;">
                        @include('livewire.front.shared-safari')
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('formSubmitted', () => {
            document.querySelector('form').reset(); 
        });
    });
</script>
@endpush