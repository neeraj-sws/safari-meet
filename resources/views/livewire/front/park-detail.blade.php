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
                   <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold bg-white {{ $activeTab === 'overview' ? 'active' : '' }}"
                                wire:click="$set('activeTab', 'overview')"
                                type="button" role="tab">
                            Overview
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold rounded-pill {{ $activeTab === 'packages' ? 'active' : '' }}"
                                wire:click="$set('activeTab', 'packages')"
                                type="button" role="tab">
                            Packages
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold rounded-pill {{ $activeTab === 'safaris' ? 'active' : '' }}"
                                wire:click="$set('activeTab', 'safaris')"
                                type="button" role="tab">
                            Shared Safaris
                        </button>
                    </li>
                </ul>

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

                                        <form wire:submit.prevent="store">
                                            <!-- Safaris & Travelers -->
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
                                                    <option selected>Select-Accommodation</option>
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
                                                <button type="submit" class="btn blue-btn-hover rounded-pill w-100 text-white">Send
                                                    Request</button>
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
                            <div class="bg-white packagetab-navbar rounded-3 px-4 py-1 shadow-sm mb-4">
                                <nav class="">
                                    <ul class="nav nav-pills border-0 flex-nowrap flex-row flex-lg-row" id="parkTab"
                                        role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link active fw-normal rounded-pill"
                                                id="keyinfo-tab" data-bs-toggle="tab" data-bs-target="#keyinfo"
                                                role="tab" aria-controls="keyinfo" aria-selected="true">Key Info</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link fw-normal rounded-pill"
                                                id="about-tab" data-bs-toggle="tab" data-bs-target="#about" role="tab"
                                                aria-controls="about" aria-selected="false">About the Park</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link fw-normal rounded-pill"
                                                id="safari-tab" data-bs-toggle="tab" data-bs-target="#safari" role="tab"
                                                aria-controls="safari" aria-selected="false">Safari Information</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link fw-normal rounded-pill"
                                                id="accommodation-tab" data-bs-toggle="tab"
                                                data-bs-target="#accommodation" role="tab" aria-controls="accommodation"
                                                aria-selected="false">Accommodation Options</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link fw-normal rounded-pill"
                                                id="wildlife-tab" data-bs-toggle="tab" data-bs-target="#wildlife"
                                                role="tab" aria-controls="wildlife" aria-selected="false">Wildlife You
                                                May See</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link fw-normal rounded-pill"
                                                id="reach-tab" data-bs-toggle="tab" data-bs-target="#reach" role="tab"
                                                aria-controls="reach" aria-selected="false">How to Reach</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="javascript:void(0)" class="nav-link fw-normal rounded-pill"
                                                id="tips-tab" data-bs-toggle="tab" data-bs-target="#tips" role="tab"
                                                aria-controls="tips" aria-selected="false">Travel Tips</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="keyinfo" role="tabpanel"
                                    aria-labelledby="keyinfo-tab">
                                    <div class="heading-text text-center mb-xl-4 mb-3">
                                        <div class="">
                                            <h2 class="mb-0 text-accent">Key Information</h2>
                                            <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                class="vector-border-bottom">
                                        </div>
                                        <h3 class="text-center fw-bold text-blue mb-sm-5 mb-3">{{ $parkDetails->title}} </h3>
                                    </div>
                                    <div class="mb-4">
                                        <div class="row mb-3 gx-2 align-items-center flex-md-row flex-column-reverse">
                                            <div class="col-md-7">
                                                <div class="card shadow-sm rounded-3">
                                                    <div class="card-body">
                                                        <h5 class="mb-2 link-text text-dark"><i
                                                                class="fa-solid fa-leaf me-2 text-dark fs-6"></i>Park
                                                            Overview</h5>
                                                        <ul class="list--unstyled small mb-0">
                                                            <li><strong class="primary-color-muted">Location:</strong>
                                                                Madhya Pradesh, Central India
                                                            </li>
                                                            <li><strong
                                                                    class="primary-color-muted">Established:</strong>
                                                                1st June 1955</li>
                                                            <li><strong class="primary-color-muted">Area:</strong> 1,949
                                                                sq.km</li>
                                                            <li><strong class="primary-color-muted">Famous For:</strong>
                                                                Barasingha, Bengal Tigers
                                                            </li>
                                                            <li><strong class="primary-color-muted">Best Time:</strong>
                                                                October to February, March to June
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-md-0 mb-3">
                                                <div class="img-1 rounded-3 bg-blue  key-info-img">
                                                    <img src="{{ asset('front-assets/images/animal-images/blog-1.png')}}" alt="Animal"
                                                        class="img-fluid rounded-2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3 gx-2 align-items-center">
                                            <div class="col-md-5 mb-md-0 mb-3">
                                                <div class="img-1 rounded-3 bg-blue  key-info-img">
                                                    <img src="{{ asset('front-assets/images/animal-images/species-2.png')}}" alt="Animal"
                                                        class="img-fluid rounded-2">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card shadow-sm rounded-3">
                                                    <div class="card-body">
                                                        <h5 class="mb-2 link-text text-dark"><i
                                                                class="fa-solid fa-car me-2 text-dark fs-6"></i>Safari
                                                            and Travel Info</h5>
                                                        <ul class="list--unstyled small mb-0">
                                                            <li><strong class="primary-color-muted">Safari
                                                                    Types:</strong> Jeep, Canter, Boat</li>
                                                            <li><strong class="primary-color-muted">Core Zones:</strong>
                                                                Kanha, Mukki, Kisli, Sarhi
                                                            </li>
                                                            <li><strong class="primary-color-muted">Buffer
                                                                    Zones:</strong>
                                                                Khatia, Khapa, Phen, Sijora
                                                            </li>
                                                            <li><strong class="primary-color-muted">Entry
                                                                    Gates:</strong> Khatia, Mukki, Khatia, Sarhi</li>
                                                            <li><strong class="primary-color-muted">Nearest Railway
                                                                    Station:</strong> Gondia,
                                                                Jabalpur
                                                            </li>
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
                                                                class="fa-solid fa-clock me-2 text-dark fs-6"></i>Timings
                                                            &
                                                            Cost</h5>
                                                        <ul class="list-unstyled small mb-4">
                                                            <li><strong class="primary-color-muted">Safari
                                                                    Timings:</strong><br> Morning: 6:00 AM –
                                                                11:30
                                                                AM<br>
                                                                Afternoon: 3:00 PM – 6:00 PM</li>
                                                        </ul>
                                                        <p class="small mb-0">
                                                            <strong class="primary-color-muted">Cost:</strong>
                                                            ₹7,500–₹8,500 (Core), ₹6,000–₹6,500
                                                            (Buffer)
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-md-0 mb-3">
                                                <div class="img-1 rounded-3 bg-blue  key-info-img">
                                                    <img src="{{ asset('front-assets/images/animal-images/bird-1.png')}}" alt="Animal"
                                                        class="img-fluid rounded-2">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                                    <div class="heading-text text-center mb-xl-4 mb-3">
                                        <div class="">
                                            <h2 class="mb-0 text-accent">About Kanha National Park</h2>
                                            <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                class="vector-border-bottom">
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-lg-4 left-image-col">
                                        <div class="col-xl-5 mb-3">
                                            <div class="vertical-image-col">
                                                <img src="{{ asset('front-assets/images/park-detail/detail-1.jpg')}}" alt="Detail-1"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="col-xl-7 mb-3">
                                            <div class="right-text-box">
                                                <h3 class="text-blue">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#1D4358">
                                                        <path
                                                            d="M320-440h320v-80H320v80Zm0 120h320v-80H320v80Zm0 120h200v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
                                                    </svg> Introduction
                                                </h3>
                                                <div class="">
                                                    <p>Named after the pristine <strong>Pench River, Pench Tiger
                                                            Reserve</strong> is located in the Chhindwara and Seoni
                                                        districts of Madhya Pradesh which border on the state of
                                                        Maharashtra.</p>

                                                    <p>The Pench river flows right through the middle of the park.
                                                        It
                                                        descends from north to south, thereby dividing the reserve
                                                        into
                                                        equal eastern and western parts. The place is more popularly
                                                        known as <strong>Pench National Park</strong> since the
                                                        identity
                                                        of a <strong>tiger reserve </strong>was granted to it later
                                                        in
                                                        the year 1992.</p>

                                                    <p><strong>Pench Tiger Reserve</strong> is the joint pride of
                                                        both
                                                        <strong><a href="javascript:void(0)"
                                                                class="text-decoration-none">Madhya
                                                                Pradesh</a></strong>
                                                        and <strong><a href="javascript:void(0)"
                                                                class="text-decoration-none">Maharashtra</a></strong>.
                                                        Its unique location makes it accessible from both states, as
                                                        entry gates open into each of the two states.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-lg-4 right-image-col">
                                        <div class="col-xl-7 mb-3">
                                            <div class="right-text-box">
                                                <h3 class="text-blue">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#1D4358">
                                                        <path
                                                            d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z" />
                                                    </svg> Fauna
                                                </h3>
                                                <div class="">
                                                    <p>Kanha National Park is the land of the
                                                        <strong>herbivorous</strong> and the
                                                        <strong>carnivorous</strong> animals. The varieties of
                                                        animals
                                                        can be discovered in abundance at this amazing reserve. It
                                                        is
                                                        the only habitat of the rare hard ground Barasingha, often
                                                        referred as <strong> “the jewel of Kanha” </strong> and most
                                                        famed the Indian Tigers. The major faunas to be found in the
                                                        vast serenity of the Kanha National Park are:
                                                    </p>
                                                    <h4 class="park-detail-title">Main Species: </h4>
                                                    <div class="accordion p-3 rounded-3 dark-grey-bg"
                                                        id="mainspeciesAccordian">
                                                        <!-- Mammals -->
                                                        <div class="accordion-item mb-3 rounded-3">
                                                            <h2 class="accordion-header rounded-top-3"
                                                                id="heading-mammals">
                                                                <button
                                                                    class="accordion-button rounded-top-3 rounded-bottom-0"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#collapse-mammals"
                                                                    aria-expanded="true"
                                                                    aria-controls="collapse-mammals">
                                                                    Mammals:
                                                                </button>
                                                            </h2>
                                                            <div id="collapse-mammals"
                                                                class="accordion-collapse collapse show"
                                                                aria-labelledby="heading-mammals"
                                                                data-bs-parent="#mainspeciesAccordian">
                                                                <div class="accordion-body pt-0">
                                                                    <ul class="list-unstyled mb-0 package-lists">
                                                                        <li><i class="fa-regular fa-circle-check"></i>
                                                                            Tiger, Panther, Chital, Sambar,
                                                                            Barasingha,
                                                                            Black buck, Barking deer, Chousingha,
                                                                            Gaur,
                                                                            Langur, Wild pig, Jackal, Sloth bear,
                                                                            Wild
                                                                            dog.</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Reptiles -->
                                                        <div class="accordion-item mb-3 rounded-3">
                                                            <h2 class="accordion-header rounded-top-3"
                                                                id="heading-reptiles">
                                                                <button
                                                                    class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#collapse-reptiles"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapse-reptiles">
                                                                    Reptiles
                                                                </button>
                                                            </h2>
                                                            <div id="collapse-reptiles"
                                                                class="accordion-collapse collapse"
                                                                aria-labelledby="heading-reptiles"
                                                                data-bs-parent="#mainspeciesAccordian">
                                                                <div class="accordion-body pt-0">
                                                                    <ul class="list-unstyled mb-0 package-lists">
                                                                        <li><i class="fa-regular fa-circle-check"></i>
                                                                            Common reptiles found in the region
                                                                            include
                                                                            Monitor lizards, various snakes,
                                                                            crocodiles,
                                                                            etc.</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Fishes -->
                                                        <div class="accordion-item mb-0 rounded-3">
                                                            <h2 class="accordion-header rounded-top-3"
                                                                id="heading-fishes">
                                                                <button
                                                                    class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#collapse-fishes"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapse-fishes">
                                                                    Fishes:
                                                                </button>
                                                            </h2>
                                                            <div id="collapse-fishes"
                                                                class="accordion-collapse collapse"
                                                                aria-labelledby="heading-fishes"
                                                                data-bs-parent="#mainspeciesAccordian">
                                                                <div class="accordion-body pt-0">
                                                                    <ul class="list-unstyled mb-0 package-lists">
                                                                        <li><i class="fa-regular fa-circle-check"></i>
                                                                            Rohu, Catla, and other freshwater
                                                                            species
                                                                            are commonly seen in rivers and lakes.
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5 mb-3">
                                            <div class="vertical-image-col">
                                                <img src="{{ asset('front-assets/images/park-detail/detail-2.jpg')}}" alt="Detail-2"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-lg-4 left-image-col">
                                        <div class="col-xl-5 mb-3">
                                            <div class="vertical-image-col">
                                                <img src="{{ asset('front-assets/images/park-detail/detail-3.jpg')}}" alt="Detail-3"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="col-xl-7 mb-3">
                                            <div class="right-text-box">
                                                <h3 class="text-blue"><svg xmlns="http://www.w3.org/2000/svg"
                                                        height="24px" viewBox="0 -960 960 960" width="24px"
                                                        fill="#1D4358">
                                                        <path
                                                            d="M480-600q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 240q-39 0-70.5-21.5T364-438q-5 0-9 .5t-9 .5q-52 0-89-37t-37-89q0-21 7-40.5t21-36.5q-13-17-20-36.5t-7-40.5q0-52 36.5-89t88.5-37q5 0 9 .5t9 .5q14-35 45.5-56.5T480-920q39 0 70.5 21.5T596-842q5 0 9-.5t9-.5q52 0 88.5 37t36.5 89q0 21-6.5 40.5T712-640q13 17 20 36.5t7 40.5q0 52-36.5 89T614-437q-5 0-9-.5t-9-.5q-14 35-45.5 56.5T480-360Zm0 280q0-74 28.5-139.5T586-334q49-49 114.5-77.5T840-440q0 74-28.5 139.5T734-186q-49 49-114.5 77.5T480-80Zm98-98q57-21 100-64t64-100q-57 21-100 64t-64 100Zm-98 98q0-74-28.5-139.5T374-334q-49-49-114.5-77.5T120-440q0 74 28.5 139.5T226-186q49 49 114.5 77.5T480-80Zm-98-98q-57-21-100-64t-64-100q57 21 100 64t64 100Zm196 0Zm-196 0Zm232-339q19 0 32.5-13.5T660-563q0-14-7.5-24.5T633-604l-35-17q-2 11-6 21.5t-9 19.5q-5 9-12 17t-15 15l32 23q5 4 11.5 6t14.5 2Zm-16-142 35-17q12-6 19-17t7-24q0-19-13-32.5T614-763q-8 0-14 2t-12 6l-33 23q8 7 15.5 15t12.5 17q5 9 9 19.5t6 21.5Zm-159-93q10-4 20-6t21-2q11 0 21 2t20 6l5-44q2-18-12.5-31T480-840q-19 0-33.5 13T434-796l5 44Zm41 312q19 0 33.5-13t12.5-31l-5-44q-10 4-20 6t-21 2q-11 0-21-2t-20-6l-5 44q-2 18 12.5 31t33.5 13ZM362-659q2-11 6-21.5t9-19.5q5-9 12-17t15-15l-32-23q-5-4-11.5-6t-14.5-2q-19 0-32.5 13.5T300-717q0 13 7.5 24t19.5 17l35 17Zm-16 141q8 0 14-1.5t12-6.5l33-22q-8-7-15.5-15T377-580q-5-9-9-19.5t-6-21.5l-35 17q-12 6-19 17t-7 24q1 19 13.5 32t31.5 13Zm237-62Zm0-120Zm-103-60Zm0 240ZM377-700Zm0 120Z" />
                                                    </svg> Flora</h3>
                                                <div class="">
                                                    <p>Kanha National Park is the only woodland in the country that
                                                        brings so much of vividness in nature and is amazingly a
                                                        home to
                                                        over 200 species of flowering plants. It is a low land
                                                        forest
                                                        that brings a mixture of Sal (Shorea robusta) and other
                                                        mixed
                                                        forest trees, mingled with meadows. The moderate and
                                                        favorable
                                                        climate and varied topography supports the growth of a rich
                                                        and
                                                        varied flora in the Park. Over 70 species of trees are found
                                                        in
                                                        Kanha.
                                                    </p>
                                                    <div>
                                                        <p><strong>
                                                                The types of forest area found in the Kanha Tiger
                                                                Reserve
                                                                are:
                                                            </strong></p>
                                                        <ul>
                                                            <li>Moist Peninsular Sal Forests (3C/C2)</li>
                                                            <li>Southern Tropical Moist Mixed Deciduous Forest (3
                                                                A/C
                                                                2a)
                                                            </li>
                                                            <li>Southern Tropical Dry Deciduous Mixed Forest (5
                                                                A/C-3)
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="mb-3">
                                                        <p class="mb-0"><strong>
                                                                The major floras discovered in Kanha Reserve:
                                                            </strong>
                                                        </p>
                                                        <span>Sal, Saja, Lendia, Dhawa, Tendu, Palas, Bija, Mahua,
                                                            Aonla,
                                                            Achar and Bamboo. Besides, there are many species of
                                                            climbers,
                                                            forbs and grass can also be found here.</span>
                                                    </div>
                                                    <p>There are many species of grass witnessed at Kanha for the
                                                        survival of the featured species of Barasingha(Cervus
                                                        duvauceli
                                                        branderi) in the reserve. Along with that some aquatic
                                                        plants in
                                                        numerous “tal” (lakes) are life line for migratory and
                                                        wetland
                                                        species of birds.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-lg-4 right-image-col">
                                        <div class="col-xl-7 mb-3">
                                            <div class="right-text-box">
                                                <h3 class="text-blue">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#1D4358">
                                                        <path
                                                            d="M240-280h240v-80H240v80Zm120-160h240v-80H360v80Zm120-160h240v-80H480v80ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z" />
                                                    </svg> History
                                                </h3>
                                                <div class="">
                                                    <p><strong>Kanha National Park</strong> covering the land
                                                        between
                                                        the Mandla and the Kalaghat districts is the <strong>largest
                                                            national park in State Madhya Pradesh</strong>
                                                        spanning 2051.791 sq km of the area including core area
                                                        (917.43
                                                        sq km) and buffer area (1134.361 sq km).  It also boasts to
                                                        be
                                                        the major contributor to the conservation of Barasingha,
                                                        Gaur,
                                                        and Tigers in neighboring reserves.
                                                    </p>
                                                    <p>Protected by the Maikal range of Satpuras, Kanha is blessed
                                                        with beautiful nature and amazing wildlife. Since its full
                                                        establishment in 1955.</p>
                                                    <p><strong>Kanha National Park</strong> has been home to a
                                                        variety
                                                        of wildlife including big cats, mammals, bird species, and
                                                        reptiles.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5 mb-3">
                                            <div class="vertical-image-col">
                                                <img src="{{ asset('front-assets/images/park-detail/detail-4.jpg')}}" alt="Detail-4"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-lg-4 left-image-col">
                                        <div class="col-xl-5 mb-3">
                                            <div class="vertical-image-col">
                                                <img src="{{ asset('front-assets/images/park-detail/detail-5.jpg')}}" alt="Detail-5"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="col-xl-7 mb-3">
                                            <div class="right-text-box">
                                                <h3 class="text-blue">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#1D4358">
                                                        <path
                                                            d="M216-176q-45-45-70.5-104T120-402q0-63 24-124.5T222-642q35-35 86.5-60t122-39.5Q501-756 591.5-759t202.5 7q8 106 5 195t-16.5 160.5q-13.5 71.5-38 125T684-182q-53 53-112.5 77.5T450-80q-65 0-127-25.5T216-176Zm112-16q29 17 59.5 24.5T450-160q46 0 91-18.5t86-59.5q18-18 36.5-50.5t32-85Q709-426 716-500.5t2-177.5q-49-2-110.5-1.5T485-670q-61 9-116 29t-90 55q-45 45-62 89t-17 85q0 59 22.5 103.5T262-246q42-80 111-153.5T534-520q-72 63-125.5 142.5T328-192Zm0 0Zm0 0Z" />
                                                    </svg> Landscape & Geography
                                                </h3>
                                                <div class="">
                                                    <p>Kanha National Park lies in the Maikal range of the Satpuras
                                                        in
                                                        central India. The terrain is a mix of:
                                                    </p>
                                                    <div>
                                                        <p class="list-heading"><svg xmlns="http://www.w3.org/2000/svg"
                                                                height="24px" viewBox="0 -960 960 960" width="24px"
                                                                fill="#1D4358">
                                                                <path
                                                                    d="M280-80v-160H0l154-240H80l280-400 120 172 120-172 280 400h-74l154 240H680v160H520v-160h-80v160H280Zm389-240h145L659-560h67L600-740l-71 101 111 159h-74l103 160Zm-523 0h428L419-560h67L360-740 234-560h67L146-320Zm0 0h155-67 252-67 155-428Zm523 0H566h74-111 197-67 155-145Zm-149 80h160-160Zm201 0Z" />
                                                            </svg> Forest Types:</p>
                                                        <ul>
                                                            <li>Sal (Shorea robusta) Forests dominate the central
                                                                highlands.
                                                            </li>
                                                            <li>Sal (Shorea robusta) Forests dominate the central
                                                                highlands.
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div>
                                                        <p class="list-heading"><svg xmlns="http://www.w3.org/2000/svg"
                                                                height="24px" viewBox="0 -960 960 960" width="24px"
                                                                fill="#1D4358">
                                                                <path
                                                                    d="M80-160v-80h230q-22-85-83.5-146.5T80-470q20-5 39.5-7.5T160-480q134 0 227 93t93 227H80Zm480 0q0-42-9-83.5T525-323q42-71 114.5-114T800-480q21 0 40.5 2.5T880-470q-85 22-146 83.5T650-240h230v80H560Zm-80-239q0-65 24-122t66-100.5q42-43.5 98.5-69.5T789-719q-56 35-98 86t-65 114q-44 21-80.5 51.5T480-399Zm-73-75q-12-9-24-17t-25-16q0-6 1-12.5t1-12.5q0-76-24-144t-68-124q66 27 114.5 77.5T457-606q-18 30-31 63.5T407-474Z" />
                                                            </svg> Meadows & Grasslands:</p>
                                                        <ul>
                                                            <li>Known for its stunning "maidans" (meadows), such as
                                                                Sonf, Bishanpura, and Kanha Meadow, which are prime
                                                                wildlife viewing areas.
                                                            </li>
                                                            <li>These grasslands were once villages relocated for
                                                                conservation and now serve as excellent grazing and
                                                                sighting zones for herbivores and carnivores alike.
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div>
                                                        <p class="list-heading"><svg xmlns="http://www.w3.org/2000/svg"
                                                                height="24px" viewBox="0 -960 960 960" width="24px"
                                                                fill="#1D4358">
                                                                <path
                                                                    d="M80-40v-80h40q32 0 62-10t58-30q28 20 58 30t62 10q32 0 62.5-10t57.5-30q28 20 58 30t62 10q32 0 62.5-10t57.5-30q27 20 57.5 30t62.5 10h40v80h-40q-31 0-61-7.5T720-70q-29 15-59 22.5T600-40q-31 0-61-7.5T480-70q-29 15-59 22.5T360-40q-31 0-61-7.5T240-70q-29 15-59 22.5T120-40H80Zm280-160q-36 0-67-17t-53-43q-17 18-37.5 32.5T157-205q-41-11-83-26T0-260q54-23 132-47t153-36l54-167q11-34 41.5-45t57.5 3l102 52 113-60 66-148-20-53 53-119 128 57-53 119-53 20-148 334q93 11 186.5 38T960-260q-29 13-73.5 28.5T803-205q-25-7-45.5-21.5T720-260q-22 26-53 43t-67 17q-36 0-67-17t-53-43q-22 26-53 43t-67 17Zm203-157 38-85-61 32-70-36-28 86h38q21 0 42 .5t41 2.5Zm-83-223q-33 0-56.5-23.5T400-660q0-33 23.5-56.5T480-740q33 0 56.5 23.5T560-660q0 33-23.5 56.5T480-580Z" />
                                                            </svg> Rivers & Valleys:</p>
                                                        <ul>
                                                            <li>Banjar and Halon Rivers flow through the park,
                                                                providing
                                                                critical water sources.</li>
                                                            <li>Gentle undulating hills and plateaus interspersed
                                                                with
                                                                riverine valleys give it a uniquely lush and varied
                                                                topography.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-lg-4 gx-3 justify-content-center">
                                        <div class="col-12 text-center">
                                            <div class="heading-text text-center mb-xl-4 mb-3">
                                                <div class="">
                                                    <h2 class="mb-0 text-blue">Interesting Fact – Kanha National
                                                        Park
                                                    </h2>
                                                    <img src="{{ asset('front-assets/images/Vector.png')}}" alt="Vector-Border"
                                                        class="vector-border-bottom">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 mb-xl-0 mb-3">
                                            <!-- Bootstrap 5 Card Style -->
                                            <div class="card text-center border rounded-4">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <!-- Icon Image -->
                                                        <img src="{{ asset('front-assets/images/interesting-fact.svg')}}" alt="Predator Icon"
                                                            class="img-fluid interesting-fact-icon">
                                                    </div>
                                                    <div class="interesting-fact-text">
                                                        <h6 class="mb-2">Prime Predators</h6>
                                                        <p class="mb-0 text-dark">
                                                            Big Cats like Bengal Tigers and Indian Leopards are the
                                                            prime
                                                            predators in Kanha National Park
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 mb-xl-0 mb-3">
                                            <!-- Bootstrap 5 Card Style -->
                                            <div class="card text-center border rounded-4">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <!-- Icon Image -->
                                                        <img src="{{ asset('front-assets/images/interesting-fact.svg')}}" alt="Predator Icon"
                                                            class="img-fluid interesting-fact-icon">
                                                    </div>
                                                    <div class="interesting-fact-text">
                                                        <h6 class="mb-2">Prime Predators</h6>
                                                        <p class="mb-0 text-dark">
                                                            Big Cats like Bengal Tigers and Indian Leopards are the
                                                            prime
                                                            predators in Kanha National Park
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 mb-xl-0 mb-3">
                                            <!-- Bootstrap 5 Card Style -->
                                            <div class="card text-center border rounded-4">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <!-- Icon Image -->
                                                        <img src="{{ asset('front-assets/images/interesting-fact.svg')}}" alt="Predator Icon"
                                                            class="img-fluid interesting-fact-icon">
                                                    </div>
                                                    <div class="interesting-fact-text">
                                                        <h6 class="mb-2">Prime Predators</h6>
                                                        <p class="mb-0 text-dark">
                                                            Big Cats like Bengal Tigers and Indian Leopards are the
                                                            prime
                                                            predators in Kanha National Park
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="safari" role="tabpanel" aria-labelledby="safari-tab">
                                    <div class="heading-text text-center mb-xl-4 mb-3">
                                        <div class="">
                                            <h2 class="mb-0 text-accent">Safari Information of Kanha National Park
                                            </h2>
                                            <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                class="vector-border-bottom">
                                        </div>
                                    </div>
                                    <!-- Safari Zones or Gates -->
                                    <div class="row align-items-center mb-4">
                                        <div class="col-12 mb-3">
                                            <div class="right-text-box">
                                                <h3 class="text-blue">Safari Zones or Gates</h3>
                                                <div class="">
                                                    <p>Kanha boasts 8 safari zones that include 4 gates of the
                                                        buffer
                                                        zone (Khapa, Khatia, Phen, and Sijora) and 4 gates of the
                                                        core
                                                        zone (Kanha, Kisli, Sarhi, and Mukki). The total number of
                                                        jeeps
                                                        allowed to enter the forest is 125 in the morning and
                                                        afternoon
                                                        each.
                                                    </p>
                                                    <div class="row align-items-center">
                                                        <div class="col-xl-8">
                                                            <div class="accordion p-3 rounded-3 dark-grey-bg"
                                                                id="zoneAccordian">
                                                                <!-- Kanha Zone: -->
                                                                <div class="accordion-item mb-3 rounded-3">
                                                                    <h2 class="accordion-header rounded-top-3"
                                                                        id="heading-kanha-zone">
                                                                        <button
                                                                            class="accordion-button rounded-top-3 rounded-bottom-0"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse-kanha-zone"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapse-kanha-zone">
                                                                            Kanha Zone:
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapse-kanha-zone"
                                                                        class="accordion-collapse collapse show"
                                                                        aria-labelledby="heading-kanha-zone"
                                                                        data-bs-parent="#zoneAccordian">
                                                                        <div class="accordion-body pt-0">
                                                                            <ul
                                                                                class="list-unstyled mb-0 package-lists">
                                                                                <li><i
                                                                                        class="fa-regular fa-circle-check"></i>
                                                                                    Adorned with open meadows and bamboo
                                                                                    trees, the Kanha gate has a unique
                                                                                    historical background. A maximum of
                                                                                    40 jeeps can enter through the Kanha
                                                                                    gate. Shravan Taal and Kanha Museum
                                                                                    are also tourist attractions here.
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Sarhi Zone -->
                                                                <div class="accordion-item mb-3 rounded-3">
                                                                    <h2 class="accordion-header rounded-top-3"
                                                                        id="heading-sarhi-zone">
                                                                        <button
                                                                            class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse-sarhi-zone"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapse-sarhi-zone">
                                                                            Sarhi Zone
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapse-sarhi-zone"
                                                                        class="accordion-collapse collapse"
                                                                        aria-labelledby="heading-sarhi-zone"
                                                                        data-bs-parent="#zoneAccordian">
                                                                        <div class="accordion-body pt-0">
                                                                            <ul
                                                                                class="list-unstyled mb-0 package-lists">
                                                                                <li><i
                                                                                        class="fa-regular fa-circle-check"></i>
                                                                                    Sarhi zone is popular for the Saunf
                                                                                    Meadow for spotting Barasingha for
                                                                                    the first time in 1966. Sarhi zone
                                                                                    allows entry of maximum 27 jeeps. In
                                                                                    the dry deciduous forests, one can
                                                                                    sight tigers easily.</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Mukki Zone -->
                                                                <div class="accordion-item mb-3 rounded-3">
                                                                    <h2 class="accordion-header rounded-top-3"
                                                                        id="heading-mukki-zone">
                                                                        <button
                                                                            class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse-mukki-zone"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapse-mukki-zone">
                                                                            Mukki Zone:
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapse-mukki-zone"
                                                                        class="accordion-collapse collapse"
                                                                        aria-labelledby="heading-mukki-zone"
                                                                        data-bs-parent="#zoneAccordian">
                                                                        <div class="accordion-body pt-0">
                                                                            <ul
                                                                                class="list-unstyled mb-0 package-lists">
                                                                                <li><i
                                                                                        class="fa-regular fa-circle-check"></i>
                                                                                    Mukki Zone also has Saal, bamboo,
                                                                                    and lush grasslands that help good
                                                                                    tiger sightings. This zone allows
                                                                                    the entry of a maximum of 40 jeeps.
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Kisli Zone -->
                                                                <div class="accordion-item mb-0 rounded-3">
                                                                    <h2 class="accordion-header rounded-top-3"
                                                                        id="heading-kisli-zone">
                                                                        <button
                                                                            class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                                                            type="button" data-bs-toggle="collapse"
                                                                            data-bs-target="#collapse-kisli-zone"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapse-kisli-zone">
                                                                            Kisli Zone:
                                                                        </button>
                                                                    </h2>
                                                                    <div id="collapse-kisli-zone"
                                                                        class="accordion-collapse collapse"
                                                                        aria-labelledby="heading-kisli-zone"
                                                                        data-bs-parent="#zoneAccordian">
                                                                        <div class="accordion-body pt-0">
                                                                            <ul
                                                                                class="list-unstyled mb-0 package-lists">
                                                                                <li><i
                                                                                        class="fa-regular fa-circle-check"></i>
                                                                                    Bamboo vegetation, picturesque
                                                                                    grasslands, and deep Saal forests –
                                                                                    Kisli zone also is well-known for
                                                                                    tiger sightings. The maximum number
                                                                                    of jeeps allowed is 18.
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 d-xl-block d-none">
                                                            <div class="vertical-image-col zone-image">
                                                                <img src="{{ asset('front-assets/images/park-detail/tiger-1.jpg')}}" alt="Tiger-1"
                                                                    class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- Core Zone -->
                                                    <div class="table-responsive mb-md-0 mb-3">
                                                        <table class="custom-table" cellspacing="10px"
                                                            id="bestTimeToVisit">
                                                            <!-- First Header Row -->
                                                            <tr>
                                                                <td colspan="3"
                                                                    class="table-header p-2 bg-accent border-0">
                                                                    <h3 class="text-white fw-medium m-0">Core Zone

                                                                    </h3>
                                                                </td>
                                                            </tr>

                                                            <!-- Second Header Row -->
                                                            <tr class="table-header p-2">
                                                                <td class="p-2 bg-white fw-bold">Zone Name</td>
                                                                <td class="p-2 bg-white fw-bold">Entry Gate</td>
                                                            </tr>

                                                            <!-- Row 1 -->
                                                            <tr>
                                                                <td class="p-2 bg-white fw-normal">Kanha</td>
                                                                <td class="p-2 bg-white fw-normal">Khatiya</td>
                                                            </tr>

                                                            <!-- Row 2 -->
                                                            <tr>
                                                                <td class="p-2 bg-white fw-normal">Kisli</td>
                                                                <td class="p-2 bg-white fw-normal">Khatiya</td>
                                                            </tr>

                                                            <!-- Row 3 -->
                                                            <tr>
                                                                <td class="p-2 bg-white fw-normal">Mukki</td>
                                                                <td class="p-2 bg-white fw-normal">Mukki</td>
                                                            </tr>

                                                            <!-- Row 4 -->
                                                            <tr>
                                                                <td class="p-2 bg-white fw-normal">Sarhi</td>
                                                                <td class="p-2 bg-white fw-normal">Sarhi</td>
                                                            </tr>


                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <!-- Buffer Zone -->
                                                    <div class="table-responsive">
                                                        <table class="custom-table" cellspacing="10px"
                                                            id="bestTimeToVisit">
                                                            <!-- First Header Row -->
                                                            <tr>
                                                                <td colspan="3"
                                                                    class="table-header p-2 bg-accent border-0">
                                                                    <h3 class="text-white fw-medium m-0">Buffer Zone
                                                                    </h3>
                                                                </td>
                                                            </tr>

                                                            <!-- Second Header Row -->
                                                            <tr class="table-header p-2">
                                                                <td class="p-2 bg-white fw-bold">Zone Name</td>
                                                                <td class="p-2 bg-white fw-bold">Entry Gate</td>
                                                            </tr>

                                                            <!-- Row 1 -->
                                                            <tr>
                                                                <td class="p-2 bg-white fw-normal">Khapa</td>
                                                                <td class="p-2 bg-white fw-normal">Mukki</td>
                                                            </tr>

                                                            <!-- Row 2 -->
                                                            <tr>
                                                                <td class="p-2 bg-white fw-normal">Khatia</td>
                                                                <td class="p-2 bg-white fw-normal">Khatia</td>
                                                            </tr>

                                                            <!-- Row 3 -->
                                                            <tr>
                                                                <td class="p-2 bg-white fw-normal">Phen</td>
                                                                <td class="p-2 bg-white fw-normal">Ghuri Barrier /
                                                                    Mukki
                                                                </td>
                                                            </tr>

                                                            <!-- Row 4 -->
                                                            <tr>
                                                                <td class="p-2 bg-white fw-normal">Sijora</td>
                                                                <td class="p-2 bg-white fw-normal">Sarhi</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Kanha Safari Timings -->
                                    <div class="table-responsive mb-4">
                                        <div class="heading-text text-center mb-xl-4 mb-3">
                                            <div class="">
                                                <h2 class="mb-0 text-accent">Kanha Safari Timings</h2>
                                                <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                    class="vector-border-bottom">
                                            </div>
                                        </div>
                                        <table class="custom-table" cellspacing="10px" id="bestTimeToVisit">
                                            <!-- First Header Row -->
                                            <tr>
                                                <td rowspan="4" class="vertical-text p-3 bg-white">
                                                    <h3 class="text-blue m-0">Pre-Winter</h3>
                                                </td>
                                                <td colspan="3" class="table-header p-3 bg-white">
                                                    <h3 class="text-blue m-0">October to November</h3>
                                                </td>
                                            </tr>

                                            <!-- Second Header Row -->
                                            <tr class="table-header p-3">
                                                <td class="p-3 bg-white">Safari Slot v/s Month</td>
                                                <td class="p-3 bg-white">October</td>
                                                <td class="p-3 bg-white">November</td>
                                            </tr>

                                            <!-- Morning Slot -->
                                            <tr>
                                                <td class="table-header p-3 bg-white">Morning Slot</td>
                                                <td class="p-3 bg-white">06:00 AM to 11:30 AM</td>
                                                <td class="p-3 bg-white">06:15 AM to 11:30 AM</td>
                                            </tr>

                                            <!-- Evening Slot -->
                                            <tr>
                                                <td class="table-header p-3 bg-white">Evening Slot</td>
                                                <td class="p-3 bg-white">03:00 PM to 06:00 PM</td>
                                                <td class="p-3 bg-white">03:00 PM to 05:45 PM</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!-- Safari Booking Process -->
                                    <div class="row align-items-center mb-4">
                                        <div class="col-12">
                                            <div class="heading-text text-center mb-xl-4 mb-3">
                                                <div class="">
                                                    <h2 class="mb-0 text-accent">Safari Booking Process</h2>
                                                    <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                        class="vector-border-bottom">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-8 mb-xl-0 mb-4">
                                            <div class="left-image-col">
                                                <p>To book an end-to-end safari package in Kanha National Park
                                                    including
                                                    airport transfer, accommodation, meals, and internal transfer,
                                                    you
                                                    may contact <strong>Safari Meet</strong>, or schedule a free
                                                    discussion with our experts to understand the best safari zone
                                                    to
                                                    book, based on your area of interest.</p>
                                                <p>It is advised to plan your safari well in advance to get the best
                                                    zones for sightings. </p>
                                                <p>If you are not sure which gate(s) to choose from, you can contact
                                                     <strong>Safari Meet</strong> or message us for any assistance
                                                    in
                                                    booking your safari in Kanha.</p>
                                                <p class="mb-0">You can also book <a href="javascript:void(0)"
                                                        class="text-decoration-none">Kanha Safari online</a> from
                                                    the mp
                                                    tourism website where you can also see the exact entry fee, jeep
                                                    safari fee, elephant safari cost, and guide fee. However, this
                                                    website only books your safari permits, not the accommodation,
                                                    food,
                                                    and internal transfer to the reserve gates.</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="vertical-image-col">
                                                <img src="{{ asset('front-assets/images/park-detail/trees.jpg')}}" alt="Trees" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Park Rules Do's and Dont's -->
                                    <div class="">
                                        <div class="heading-text text-center mb-xl-4 mb-3">
                                            <div class="">
                                                <h2 class="mb-0 text-accent">Park Rules</h2>
                                                <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                    class="vector-border-bottom">
                                            </div>
                                        </div>
                                        <!-- Park Rules Do's -->
                                        <div class="row align-items-center park-donts-right">
                                            <div class="col-xl-4 mb-4">
                                                <div class="vertical-image-col">
                                                    <img src="{{ asset('front-assets/images/park-detail/tiger-1.jpg')}}" alt="Tiger-1"
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="right-text-box">
                                                    <div
                                                        class="heading-text d-flex align-items-center justify-content-between flex-wrap mb-xl-4 mb-3">
                                                        <div class="">
                                                            <h3 class="mb-0 text-blue">Do's</h3>
                                                        </div>
                                                        <div class="viewall-link">
                                                            <a href="javascript:void(0)"
                                                                class="text-decoration-none">View
                                                                All <i class="fa-solid fa-arrow-right"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <ul class="ps-4">
                                                            <li class="mb-3">Permits are necessary for entering the
                                                                Kanha
                                                                Tiger Reserve so please enter the park only after
                                                                getting
                                                                the permit.</li>
                                                            <li class="mb-3">Tourists are required to carry a litter
                                                                bag
                                                                while entering the park and bring back their
                                                                non-biodegradable garbage like plastic, bottle,
                                                                metal
                                                                foils,
                                                                tin can, etc. outside the park.</li>
                                                            <li class="mb-3">Get an officially registered Nature
                                                                guide
                                                                that
                                                                will help you in spotting wildlife and ensure that
                                                                you
                                                                do
                                                                not lose your way in the forest.</li>
                                                            <li class="mb-3">Speak softly to avoid disturbing
                                                                wildlife
                                                                and
                                                                ensure better sightings.</li>
                                                            <li class="mb-3">Always obey your guide and driver –
                                                                they
                                                                are
                                                                trained and responsible for your safety.</li>
                                                            <li class="mb-3">Buy souvenirs or hire local guides to
                                                                support
                                                                eco-tourism and tribal communities.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Park Rules Dont's -->
                                        <div class="row align-items-center">
                                            <div class="col-xl-8">
                                                <div class="right-text-box">
                                                    <div
                                                        class="heading-text d-flex align-items-center justify-content-between flex-wrap mb-xl-4 mb-3">
                                                        <div class="">
                                                            <h3 class="mb-0 text-blue">Dont's</h3>
                                                        </div>
                                                        <div class="viewall-link">
                                                            <a href="javascript:void(0)"
                                                                class="text-decoration-none">View
                                                                All <i class="fa-solid fa-arrow-right"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <ul class="ps-4 mb-0">
                                                            <li class="mb-3">Do not carry any kind of firearms
                                                                within
                                                                the
                                                                Tiger Reserve, it is strictly prohibited.</li>
                                                            <li class="mb-3">No Bluetooth speakers, music, or
                                                                ringtones
                                                                – it
                                                                disrupts the jungle silence.</li>
                                                            <li class="mb-3">Don’t feed animals, it’s illegal and
                                                                dangerous.
                                                                Wild animals should remain wild.</li>

                                                            <li class="mb-3">Don’t tease or provoke wildlife,
                                                                respect all species – even monkeys or birds. Avoid
                                                                making
                                                                gestures or sounds.</li>
                                                            <li class="mb-3">Don’t stray from safari route,
                                                                stick to official trails – off-roading is not
                                                                allowed in
                                                                Kanha.</li>
                                                            <li class="mb-3">Don’t use flash photography, flash
                                                                disturbs
                                                                and
                                                                startles animals, especially nocturnal species.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 mb-xl-0 mb-3">
                                                <div class="vertical-image-col">
                                                    <img src="{{ asset('front-assets/images/park-detail/tiger-2.jpg')}}" alt="Tiger-2"
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="accommodation" role="tabpanel"
                                    aria-labelledby="accommodation-tab">
                                    <div class="heading-text text-center mb-xl-4 mb-3">
                                        <div class="">
                                            <h2 class="mb-0 text-accent">Accommodation Options</h2>
                                            <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                class="vector-border-bottom">
                                        </div>
                                    </div>
                                    <div class="row mb-3 gx-3">
                                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 mb-3">
                                            <div
                                                class="promo-card p-3 rounded-4 bg-white overflow-hidden d-flex align-items-center">
                                                <!-- Top Row: Rating + Icon -->
                                                <div class="w-100">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div
                                                            class="rating-pill-dark d-flex align-items-center gap-1 rounded-pill text-white">
                                                            <i class="fa-solid fa-star"></i> 4.5 Star
                                                        </div>
                                                        <a href="#">
                                                            <div
                                                                class="rounded-icon d-flex align-items-center justify-content-center rounded-circle p-2 dark-grey-bg">
                                                                <i
                                                                    class="fa-solid fa-arrow-up-right-from-square small"></i>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <!-- Title -->
                                                    <h6 class="fw-bold mb-1">Kingfisher Resort</h6>

                                                    <!-- Subtitle & Location -->
                                                    <div class="accommodation-subtitle">
                                                        <p class="text-muted mb-0">4-Star Resort </p>
                                                        <p class="text-muted mb-3">
                                                            <i class="fa-solid fa-location-dot me-1"></i>
                                                            Only 7 km from Kanha Tiger Reserve
                                                        </p>
                                                    </div>
                                                </div>
                                                <!-- Image -->
                                                <img src="{{ asset('front-assets/images/park-detail/accommodation-1.webp')}}"
                                                    alt="Kingfisher Resort" class="promo-img rounded-4 img-fluid">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 mb-3">
                                            <div
                                                class="promo-card p-3 rounded-4 bg-white overflow-hidden d-flex align-items-center">
                                                <!-- Top Row: Rating + Icon -->
                                                <div class="w-100">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div
                                                            class="rating-pill-dark d-flex align-items-center gap-1 rounded-pill text-white">
                                                            <i class="fa-solid fa-star"></i> 4.5 Star
                                                        </div>
                                                        <a href="#">
                                                            <div
                                                                class="rounded-icon d-flex align-items-center justify-content-center rounded-circle p-2 dark-grey-bg">
                                                                <i
                                                                    class="fa-solid fa-arrow-up-right-from-square small"></i>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <!-- Title -->
                                                    <h6 class="fw-bold mb-1">Kingfisher Resort</h6>

                                                    <!-- Subtitle & Location -->
                                                    <div class="accommodation-subtitle">
                                                        <p class="text-muted mb-0">4-Star Resort </p>
                                                        <p class="text-muted mb-3">
                                                            <i class="fa-solid fa-location-dot me-1"></i>
                                                            Only 7 km from Kanha Tiger Reserve
                                                        </p>
                                                    </div>
                                                </div>
                                                <!-- Image -->
                                                <img src="{{ asset('front-assets/images/park-detail/accommodation-1.webp')}}"
                                                    alt="Kingfisher Resort" class="promo-img rounded-4 img-fluid">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 mb-3">
                                            <div
                                                class="promo-card p-3 rounded-4 bg-white overflow-hidden d-flex align-items-center">
                                                <!-- Top Row: Rating + Icon -->
                                                <div class="w-100">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div
                                                            class="rating-pill-dark d-flex align-items-center gap-1 rounded-pill text-white">
                                                            <i class="fa-solid fa-star"></i> 4.5 Star
                                                        </div>
                                                        <a href="#">
                                                            <div
                                                                class="rounded-icon d-flex align-items-center justify-content-center rounded-circle p-2 dark-grey-bg">
                                                                <i
                                                                    class="fa-solid fa-arrow-up-right-from-square small"></i>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <!-- Title -->
                                                    <h6 class="fw-bold mb-1">Kingfisher Resort</h6>

                                                    <!-- Subtitle & Location -->
                                                    <div class="accommodation-subtitle">
                                                        <p class="text-muted mb-0">4-Star Resort </p>
                                                        <p class="text-muted mb-3">
                                                            <i class="fa-solid fa-location-dot me-1"></i>
                                                            Only 7 km from Kanha Tiger Reserve
                                                        </p>
                                                    </div>
                                                </div>
                                                <!-- Image -->
                                                <img src="{{ asset('front-assets/images/park-detail/accommodation-1.webp')}}"
                                                    alt="Kingfisher Resort" class="promo-img rounded-4 img-fluid">
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="text-center">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1 px-4 rounded-1">Load
                                                    More</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="wildlife" role="tabpanel" aria-labelledby="wildlife-tab">
                                    <div class="heading-text text-center mb-xl-4 mb-3">
                                        <div class="">
                                            <h2 class="mb-0 text-accent">Wildlife You May See !!!</h2>
                                            <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                class="vector-border-bottom">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 mb-4">
                                            <a href="javascript:void" class="text-decoration-none fw-bold">
                                                <div class="wildlife-img">
                                                    <img src="{{ asset('front-assets/images/wildlife/wildlife-1.jpg')}}" alt="Wildlife 1"
                                                        class="img-fluid">
                                                    <div class="wildlife-text text-center px-4">
                                                        <h6>Bengal Tigers</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-4">
                                            <a href="javascript:void" class="text-decoration-none fw-bold">
                                                <div class="wildlife-img">
                                                    <img src="{{ asset('front-assets/images/wildlife/wildlife-2.jpg')}}" alt="Wildlife 2"
                                                        class="img-fluid">
                                                    <div class="wildlife-text text-center px-4">
                                                        <h6>Leopard</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-4">
                                            <a href="javascript:void" class="text-decoration-none fw-bold">
                                                <div class="wildlife-img">
                                                    <img src="{{ asset('front-assets/images/wildlife/wildlife-3.jpg')}}" alt="Wildlife 3"
                                                        class="img-fluid">
                                                    <div class="wildlife-text text-center px-4">
                                                        <h6>Chital</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-4">
                                            <a href="javascript:void" class="text-decoration-none fw-bold">
                                                <div class="wildlife-img">
                                                    <img src="{{ asset('front-assets/images/wildlife/wildlife-4.jpg')}}" alt="Wildlife 4"
                                                        class="img-fluid">
                                                    <div class="wildlife-text text-center px-4">
                                                        <h6>Sambar</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-4">
                                            <a href="javascript:void" class="text-decoration-none fw-bold">
                                                <div class="wildlife-img">
                                                    <img src="{{ asset('front-assets/images/wildlife/wildlife-5.jpg')}}" alt="Wildlife 5"
                                                        class="img-fluid">
                                                    <div class="wildlife-text text-center px-4">
                                                        <h6>Jackal</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-4">
                                            <a href="javascript:void" class="text-decoration-none fw-bold">
                                                <div class="wildlife-img">
                                                    <img src="{{ asset('front-assets/images/wildlife/wildlife-6.jpg')}}" alt="Wildlife 6"
                                                        class="img-fluid">
                                                    <div class="wildlife-text text-center px-4">
                                                        <h6>Langur</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="reach" role="tabpanel" aria-labelledby="reach-tab">
                                    <div class="heading-text text-center mb-xl-4 mb-3">
                                        <div class="">
                                            <h2 class="mb-0 text-accent"> How to Reach the Kanha National Park</h2>
                                            <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                class="vector-border-bottom">
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mb-3">
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <div class="modes-content text-center">
                                                <div class="modes-img">
                                                    <img src="{{ asset('front-assets/images/modes-to-travel/ByAir.png')}}" alt="Air"
                                                        class="img-fluid">
                                                </div>
                                                <h3 class="">By Air</h3>
                                                <p class="mb-0">Jabalpur & Nagpur airport is easily accessible from
                                                    Kanha if you are planning for air travel. Jabalpur is approx 160
                                                    Km
                                                    where as Nagpur is around 265 Km from Kanha</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <div class="modes-content text-center">
                                                <div class="modes-img">
                                                    <img src="{{ asset('front-assets/images/modes-to-travel/ByRoad.png')}}" alt="Road"
                                                        class="img-fluid">
                                                </div>
                                                <h3 class="">By Road</h3>
                                                <p class="mb-0">Kanha National Park is well connected with all the
                                                    major
                                                    cities by road. However, <a href="javascript:void(0)"
                                                        class="text-decoration-none">Nagpur</a>, Jabalpur & Raipur
                                                    is
                                                    easily accessible from Kanha.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <div class="modes-content text-center">
                                                <div class="modes-img">
                                                    <img src="{{ asset('front-assets/images/modes-to-travel/ByRail.png')}}" alt="Rail"
                                                        class="img-fluid">
                                                </div>
                                                <h3 class="">By Rail</h3>
                                                <p class="mb-0">The nearest railhead is Gondia & Jabalpur. Which is
                                                    well
                                                    connected to many cities across India. Nagpur and Raipur are
                                                    other
                                                    options if you are looking for one.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" id="distance-table">
                                        <table class="table table-bordered table-striped text-center align-middle">
                                            <caption class="text-center text-dark small fw-semibold"
                                                style="caption-side: top;">
                                                Kanha National Park's distance from
                                                important
                                                cities</caption>
                                            <thead class="table-light">
                                                <tr>
                                                    <th>From</th>
                                                    <th>By Air + Road (hrs)</th>
                                                    <th>By Road (km)</th>
                                                    <th>By Rail + Road (hrs)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>New Delhi </td>
                                                    <td>1.5 Air + 5.00 Road </td>
                                                    <td>17.5 Hrs </td>
                                                    <td>19.00 Rail + 2.00 Road</td>
                                                </tr>
                                                <tr>
                                                    <td>Nagpur</td>
                                                    <td>NA </td>
                                                    <td>5.30 Hrs</td>
                                                    <td>3.00 + 1.5 Road</td>
                                                </tr>
                                                <tr>
                                                    <td>Raipur</td>
                                                    <td>1 hr Air + 5 hrs Road</td>
                                                    <td>215</td>
                                                    <td>5 – 5.5 hrs (train + taxi)</td>
                                                </tr>
                                                <tr>
                                                    <td>Bhopal</td>
                                                    <td>1.5 hr Air + 9 hrs Road</td>
                                                    <td>425</td>
                                                    <td>12 hrs approx</td>
                                                </tr>
                                                <tr>
                                                    <td>Indore</td>
                                                    <td>2 hr Air + 12 hrs Road</td>
                                                    <td>600</td>
                                                    <td>13 – 14 hrs</td>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tips" role="tabpanel" aria-labelledby="tips-tab">
                                    <div class="mb-4">
                                        <div class="heading-text text-center mb-xl-4 mb-3">
                                            <div class="">
                                                <h2 class="mb-0 text-accent"> Best Time to Visit Kanha National Park
                                                </h2>
                                                <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                    class="vector-border-bottom">
                                            </div>
                                        </div>
                                        <h3 class="maintime text-center mb-3">Plan your safari between October and
                                            June
                                            for
                                            the best experience.</h3>

                                        <div class="row">
                                            <!-- October to February -->
                                            <div class="col-xl-6 col-lg-12 col-md-6 mb-3">
                                                <div
                                                    class="season-card rounded-3 border-success border-start bg-white border-5 p-3 h-100">
                                                    <h6 class="season-header text-success">October to February: Cool
                                                        &
                                                        Comfortable
                                                    </h6>
                                                    <p><strong>Temperature:</strong> 10°C to 25°C</p>
                                                    <ul>
                                                        <li>Lush post-monsoon greenery</li>
                                                        <li>Perfect for family safaris & bird watching</li>
                                                        <li>Comfortable weather conditions</li>
                                                    </ul>
                                                    <p class="mb-0"><strong>Pro Tip:</strong> Opt for morning or
                                                        evening
                                                        safaris for
                                                        best sightings.</p>
                                                </div>
                                            </div>

                                            <!-- March to June -->
                                            <div class="col-xl-6 col-lg-12 col-md-6 mb-3">
                                                <div
                                                    class="season-card rounded-3 border-success border-start bg-white border-5 p-3 h-100">
                                                    <h6 class="season-header text-success">March to June: Hot but
                                                        High
                                                        Tiger
                                                        Sightings</h6>
                                                    <p><strong>Temperature:</strong> 25°C to 43°C</p>
                                                    <ul>
                                                        <li>High chances of tiger sightings</li>
                                                        <li>Animals gather around waterholes</li>
                                                        <li>Great time for wildlife photography</li>
                                                    </ul>
                                                    <p class="mb-0"><strong>Pro Tip:</strong> Dress light & stay
                                                        hydrated!</p>
                                                </div>
                                            </div>

                                            <!-- July to October (Closed) -->
                                            <div class="col-xl-6 col-lg-12 col-md-6 mb-3">
                                                <div
                                                    class="season-card rounded-3 border-start border-danger border-5 bg-white closed-season p-3">
                                                    <h6 class="season-header text-danger">July to Mid-October: Park
                                                        Closed (Monsoon)</h6>
                                                    <ul>
                                                        <li>Heavy rainfall – no safaris available</li>
                                                        <li>Park closed for forest rejuvenation and road repairs
                                                        </li>
                                                        <li>Prepares the ecosystem for next season</li>
                                                    </ul>
                                                    <p class="mb-0"><strong>Note:</strong> Travel is not allowed
                                                        during
                                                        this period.
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- Quick Tips -->
                                            <div class="col-xl-6 col-lg-12 col-md-6 mb-3">
                                                <div
                                                    class="season-card rounded-3 border-start border-accent border-5 bg-white p-3">
                                                    <h6 class="season-header text-accent"> Quick Tips</h6>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"><i
                                                                class="fa-solid fa-square-check me-1"></i>
                                                            <strong>Best
                                                                Overall Months:</strong>
                                                            November to March
                                                        </li>
                                                        <li class="list-group-item"><i
                                                                class="fa-solid fa-camera me-1"></i>
                                                            <strong>For
                                                                Photographers:</strong> April
                                                            to June
                                                        </li>
                                                        <li class="list-group-item"><i class="fa-solid fa-ban me-1"></i>
                                                            <strong>Avoid:</strong> July
                                                            to Mid-October (Park Closed)
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="heading-text text-center mb-xl-4 mb-3">
                                            <div class="">
                                                <h2 class="mb-0 text-accent"> Weather in Kanha National Park
                                                </h2>
                                                <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                    class="vector-border-bottom">
                                            </div>
                                        </div>
                                        <div class="">
                                            <p>Kanha National Park experiences a diverse climate throughout the
                                                year.
                                                January and February are cool and dry, with temperatures ranging
                                                from
                                                2°C to 22°C (36°F to 72°F).</p>
                                            <p>March to June brings the onset of summer, with temperatures rising
                                                between 20°C to 40°C (68°F to 104°F). The monsoon season, from July
                                                to
                                                September, is marked by heavy rainfall, creating a lush, vibrant
                                                environment.</p>
                                            <p>Post-monsoon (October to November) offers pleasant weather, with
                                                temperatures ranging from 10°C to 32°C (50°F to 90°F).</p>
                                            <p>December brings cool and dry conditions, with temperatures between
                                                2°C to
                                                22°C (36°F to 72°F).</p>
                                            <p>Each season in Kanha National Park provides a unique backdrop for
                                                wildlife exploration and nature enthusiasts.</p>
                                        </div>
                                        <div class="table-responsive" id="weather-table">
                                            <table class="table table-bordered text-center align-middle">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>Jan</th>
                                                        <th>Feb</th>
                                                        <th>Mar</th>
                                                        <th>Apr</th>
                                                        <th>May</th>
                                                        <th>Jun</th>
                                                        <th>Jul</th>
                                                        <th>Aug</th>
                                                        <th>Sep</th>
                                                        <th>Oct</th>
                                                        <th>Nov</th>
                                                        <th>Dec</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th class="table-info">Min (°C)</th>
                                                        <td>1</td>
                                                        <td>10</td>
                                                        <td>22</td>
                                                        <td>30</td>
                                                        <td>35</td>
                                                        <td>25</td>
                                                        <td>20</td>
                                                        <td>19</td>
                                                        <td>19</td>
                                                        <td>12</td>
                                                        <td>6</td>
                                                        <td>3</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="table-info">Max (°C)</th>
                                                        <td>15</td>
                                                        <td>25</td>
                                                        <td>35</td>
                                                        <td>40</td>
                                                        <td>42</td>
                                                        <td>41</td>
                                                        <td>34</td>
                                                        <td>30</td>
                                                        <td>31</td>
                                                        <td>29</td>
                                                        <td>27</td>
                                                        <td>25</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="heading-text text-center mb-xl-4 mb-3">
                                            <div class="">
                                                <h2 class="mb-0 text-accent"> Safari Essentials –
                                                    What to Carry
                                                </h2>
                                                <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                    class="vector-border-bottom">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="d-sm-flex d-none mb-5 row gx-3 gy-4">

                                                <!-- Binoculars -->
                                                <div class="col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch">
                                                    <div
                                                        class="card carry-item-card text-center border-0 shadow-sm rounded-4 w-100 h-100">
                                                        <div class="card-body essential-note">
                                                            <i
                                                                class="fa-solid fa-binoculars fa-2x text-primary mb-2"></i>
                                                            <h6 class="fw-semibold mb-1 text-blue">Binoculars</h6>
                                                            <p class="small text-dark mb-0">For spotting distant
                                                                wildlife like tigers and birds.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Water Bottle -->
                                                <div class="col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch">
                                                    <div
                                                        class="card carry-item-card text-center border-0 shadow-sm rounded-4 w-100 h-100">
                                                        <div class="card-body essential-note">
                                                            <i
                                                                class="fa-solid fa-bottle-water fa-2x text-info mb-2"></i>
                                                            <h6 class="fw-semibold mb-1 text-blue">Water Bottle</h6>
                                                            <p class="small text-dark mb-0">Stay hydrated throughout
                                                                the safari.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Hat / Cap -->
                                                <div class="col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch">
                                                    <div
                                                        class="card carry-item-card text-center border-0 shadow-sm rounded-4 w-100 h-100">
                                                        <div class="card-body essential-note">
                                                            <i
                                                                class="fa-solid fa-hat-cowboy fa-2x text-warning mb-2"></i>
                                                            <h6 class="fw-semibold mb-1 text-blue">Hat / Cap</h6>
                                                            <p class="small text-dark mb-0">Helps shield your face
                                                                during hot mid-day safaris.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Insect Repellent -->
                                                <div class="col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch">
                                                    <div
                                                        class="card carry-item-card text-center border-0 shadow-sm rounded-4 w-100 h-100">
                                                        <div class="card-body essential-note">
                                                            <i class="fa-solid fa-bug fa-2x text-success mb-2"></i>
                                                            <h6 class="fw-semibold mb-1 text-blue">Insect Repellent
                                                            </h6>
                                                            <p class="small text-dark mb-0">Avoid mosquito and
                                                                insect
                                                                bites, especially near water.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Light Jacket -->
                                                <div class="col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch">
                                                    <div
                                                        class="card carry-item-card text-center border-0 shadow-sm rounded-4 w-100 h-100">
                                                        <div class="card-body essential-note">
                                                            <i
                                                                class="fa-solid fa-person-walking fa-2x text-secondary mb-2"></i>
                                                            <h6 class="fw-semibold mb-1 text-blue">Light Jacket</h6>
                                                            <p class="small text-dark mb-0">Mornings can be chilly,
                                                                especially in winter.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Valid ID Proof -->
                                                <div class="col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch">
                                                    <div
                                                        class="card carry-item-card text-center border-0 shadow-sm rounded-4 w-100 h-100">
                                                        <div class="card-body essential-note">
                                                            <i class="fa-solid fa-id-card fa-2x text-danger mb-2"></i>
                                                            <h6 class="fw-semibold mb-1 text-blue">Valid ID Proof
                                                            </h6>
                                                            <p class="small text-dark mb-0">Mandatory for park entry
                                                                and safari verification.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Safari Ticket Copy -->
                                                <div class="col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch">
                                                    <div
                                                        class="card carry-item-card text-center border-0 shadow-sm rounded-4 w-100 h-100">
                                                        <div class="card-body essential-note">
                                                            <i
                                                                class="fa-solid fa-file-lines fa-2x text-primary mb-2"></i>
                                                            <h6 class="fw-semibold mb-1 text-blue">Safari Ticket
                                                                Copy
                                                            </h6>
                                                            <p class="small text-dark mb-0">Required to show at the
                                                                entry gate before boarding gypsy.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Comfortable Shoes -->
                                                <div class="col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch">
                                                    <div
                                                        class="card carry-item-card text-center border-0 shadow-sm rounded-4 w-100 h-100">
                                                        <div class="card-body essential-note">
                                                            <i
                                                                class="fa-solid fa-shoe-prints fa-2x text-primary mb-2"></i>
                                                            <h6 class="fw-semibold mb-1 text-blue">Comfortable Shoes
                                                            </h6>
                                                            <p class="small text-dark mb-0">Good for jungle walks
                                                                and
                                                                exploring buffer zones.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="d-sm-none mb-5">
                                                <div class="owl-carousel owl-theme" id="thing-to-carry">

                                                    <!-- Slide 1 -->
                                                    <div class="item">
                                                        <div class="card text-center shadow-sm rounded-4 p-3">
                                                            <i
                                                                class="fa-solid fa-binoculars fa-2x text-primary mb-2"></i>
                                                            <h6 class="fw-semibold text-blue mb-1">Binoculars</h6>
                                                            <p class="small text-muted">For spotting distant
                                                                wildlife
                                                                like tigers and birds.</p>
                                                        </div>
                                                    </div>

                                                    <!-- Slide 2 -->
                                                    <div class="item">
                                                        <div class="card text-center shadow-sm rounded-4 p-3">
                                                            <i
                                                                class="fa-solid fa-bottle-water fa-2x text-info mb-2"></i>
                                                            <h6 class="fw-semibold text-blue mb-1">Water Bottle</h6>
                                                            <p class="small text-muted">Stay hydrated throughout the
                                                                safari.</p>
                                                        </div>
                                                    </div>

                                                    <!-- Slide 3 -->
                                                    <div class="item">
                                                        <div class="card text-center shadow-sm rounded-4 p-3">
                                                            <i
                                                                class="fa-solid fa-hat-cowboy fa-2x text-warning mb-2"></i>
                                                            <h6 class="fw-semibold text-blue mb-1">Hat / Cap</h6>
                                                            <p class="small text-muted">Helps shield your face
                                                                during
                                                                hot mid-day safaris.</p>
                                                        </div>
                                                    </div>

                                                    <!-- Slide 4 -->
                                                    <div class="item">
                                                        <div class="card text-center shadow-sm rounded-4 p-3">
                                                            <i class="fa-solid fa-bug fa-2x text-success mb-2"></i>
                                                            <h6 class="fw-semibold text-blue mb-1">Insect Repellent
                                                            </h6>
                                                            <p class="small text-muted">Avoid mosquito and insect
                                                                bites,
                                                                especially near water.</p>
                                                        </div>
                                                    </div>

                                                    <!-- Slide 5 -->
                                                    <div class="item">
                                                        <div class="card text-center shadow-sm rounded-4 p-3">
                                                            <i
                                                                class="fa-solid fa-person-walking fa-2x text-secondary mb-2"></i>
                                                            <h6 class="fw-semibold text-blue mb-1">Light Jacket</h6>
                                                            <p class="small text-muted">Mornings can be chilly,
                                                                especially in winter.</p>
                                                        </div>
                                                    </div>

                                                    <!-- Slide 6 -->
                                                    <div class="item">
                                                        <div class="card text-center shadow-sm rounded-4 p-3">
                                                            <i class="fa-solid fa-id-card fa-2x text-danger mb-2"></i>
                                                            <h6 class="fw-semibold text-blue mb-1">Valid ID Proof
                                                            </h6>
                                                            <p class="small text-muted">Mandatory for park entry and
                                                                safari verification.</p>
                                                        </div>
                                                    </div>

                                                    <!-- Slide 7 -->
                                                    <div class="item">
                                                        <div class="card text-center shadow-sm rounded-4 p-3">
                                                            <i
                                                                class="fa-solid fa-file-lines fa-2x text-primary mb-2"></i>
                                                            <h6 class="fw-semibold text-blue mb-1">Safari Ticket
                                                                Copy
                                                            </h6>
                                                            <p class="small text-muted">Required to show at the
                                                                entry
                                                                gate before boarding gypsy.</p>
                                                        </div>
                                                    </div>

                                                    <!-- Slide 8 -->
                                                    <div class="item">
                                                        <div class="card text-center shadow-sm rounded-4 p-3">
                                                            <i
                                                                class="fa-solid fa-shoe-prints fa-2x text-primary mb-2"></i>
                                                            <h6 class="fw-semibold text-blue mb-1">Comfortable Shoes
                                                            </h6>
                                                            <p class="small text-muted">Good for jungle walks and
                                                                exploring buffer zones.</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="heading-text text-center mb-xl-4 mb-3">
                                            <div class="">
                                                <h2 class="mb-0 text-accent"> Safety Tips</h2>
                                                <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border"
                                                    class="vector-border-bottom">
                                            </div>
                                        </div>
                                        <div class="">
                                            <ul class="ps-sm-4 ps-0 mb-0">
                                                <li class="d-flex align-items-start gap-3 mb-3">
                                                    <i class="fa-regular fa-hand-point-right me-1 mt-1"></i>
                                                    <div>
                                                        <h6 class="fw-semibold mb-1">Stay Inside Vehicle</h6>
                                                        <p class="small text-muted mb-0">Never step out of the
                                                            safari jeep inside the park zone.</p>
                                                    </div>
                                                </li>

                                                <li class="d-flex align-items-start gap-3 mb-3">
                                                    <i class="fa-regular fa-hand-point-right me-1 mt-1"></i>
                                                    <div>
                                                        <h6 class="fw-semibold mb-1">Maintain Silence</h6>
                                                        <p class="small text-muted mb-0">Avoid loud talking or
                                                            playing music; it disturbs the wildlife.</p>
                                                    </div>
                                                </li>

                                                <li class="d-flex align-items-start gap-3 mb-3">
                                                    <i class="fa-regular fa-hand-point-right me-1 mt-1"></i>
                                                    <div>
                                                        <h6 class="fw-semibold mb-1">Don’t Litter</h6>
                                                        <p class="small text-muted mb-0">Keep the park clean — carry
                                                            your trash out with you.</p>
                                                    </div>
                                                </li>

                                                <li class="d-flex align-items-start gap-3 mb-3">
                                                    <i class="fa-regular fa-hand-point-right me-1 mt-1"></i>
                                                    <div>
                                                        <h6 class="fw-semibold mb-1">No Smoking or Fire</h6>
                                                        <p class="small text-muted mb-0">Smoking and fire are
                                                            strictly prohibited within the park.</p>
                                                    </div>
                                                </li>

                                                <li class="d-flex align-items-start gap-3 mb-3">
                                                    <i class="fa-regular fa-hand-point-right me-1 mt-1"></i>
                                                    <div>
                                                        <h6 class="fw-semibold mb-1">Follow Guide Instructions</h6>
                                                        <p class="small text-muted mb-0">Always listen to your
                                                            naturalist or driver during the safari.</p>
                                                    </div>
                                                </li>

                                                <li class="d-flex align-items-start gap-3 mb-3">
                                                    <i class="fa-regular fa-hand-point-right me-1 mt-1"></i>
                                                    <div>
                                                        <h6 class="fw-semibold mb-1">Wear Earthy Colors</h6>
                                                        <p class="small text-muted mb-0">Choose greens and browns —
                                                            avoid bright colors.</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                  <div class="tab-pane fade {{ $activeTab === 'packages' ? 'show active' : '' }}"
                       id="packages" role="tabpanel" aria-labelledby="packages-tab">
                    <div class="row g-3 position-relative mb-5" style="min-height: 100vh;">
                        @include('livewire.front.safari-package')
                    </div>
                </div>
                
                <div class="tab-pane fade {{ $activeTab === 'safaris' ? 'show active' : '' }}"
                   id="safaris" role="tabpanel" aria-labelledby="safaris-tab">
                    <div class="row g-3 position-relative mb-5" style="min-height: 100vh;">
                        @include('livewire.front.shared-safari')
                    </div>
                </div>
            </div>
            <!-- Top Rated Park  -->
            <div id="top-rated-park" class="mt-3">
                <div class="container-lg container-inner-padding">
                    <div class="heading-text text-center mb-xl-4 mb-3">
                        <div class="">
                            <h2 class="mb-0 text-accent">Top Rated Parks</h2>
                            <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border" class="vector-border-bottom">
                        </div>
                    </div>
                    <div class="owl-carousel owl-theme" id="top-rated-park-owl">
                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="card park-card border-0 shadow-sm position-relative overflow-hidden">
                                    <img src="{{ asset('front-assets/images/animal-images/lion.jpg')}}" class="img-fluid"
                                        alt="Corbett Tiger Reserve">
                                    <!-- Initial Name Bar -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-center py-2 park-name transition">
                                        <h3 class="top-park-title mb-0"> Corbett Tiger Reserve
                                        </h3>
                                    </div>
                                    <!-- Hidden Description Panel -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-start px-2 py-3 park-info transition ps-3">
                                        <div class="">
                                            <h5 class="fw-semibold top-park-title">Corbett Tiger
                                                Reserve
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between gap-1">
                                            <div class="">
                                                <p class="mb-0 small">A popular destination in
                                                    Uttarakhand, home
                                                    to tigers, elephants, and rich biodiversity.
                                                </p>
                                            </div>
                                            <a href="javascript:void(0)" class="readmorearrow text-decoration-none">
                                                <i
                                                    class="fa-solid fa-arrow-right text-white p-1 border blue-border-hover rounded-circle border-white border-3"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="card park-card border-0 shadow-sm position-relative overflow-hidden">
                                    <img src="{{ asset('front-assets/images/animal-images/lion.jpg')}}" class="img-fluid"
                                        alt="Corbett Tiger Reserve">
                                    <!-- Initial Name Bar -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-center py-2 park-name transition">
                                        <h3 class="top-park-title mb-0"> Corbett Tiger Reserve
                                        </h3>
                                    </div>
                                    <!-- Hidden Description Panel -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-start px-2 py-3 park-info transition ps-3">
                                        <div class="">
                                            <h5 class="fw-semibold top-park-title">Corbett Tiger
                                                Reserve
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between gap-1">
                                            <div class="">
                                                <p class="mb-0 small">A popular destination in
                                                    Uttarakhand, home
                                                    to tigers, elephants, and rich biodiversity.
                                                </p>
                                            </div>
                                            <a href="javascript:void(0)" class="readmorearrow text-decoration-none">
                                                <i
                                                    class="fa-solid fa-arrow-right text-white p-1 border blue-border-hover rounded-circle border-white border-3"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="card park-card border-0 shadow-sm position-relative overflow-hidden">
                                    <img src="{{ asset('front-assets/images/animal-images/lion.jpg')}}" class="img-fluid"
                                        alt="Corbett Tiger Reserve">
                                    <!-- Initial Name Bar -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-center py-2 park-name transition">
                                        <h3 class="top-park-title mb-0"> Corbett Tiger Reserve
                                        </h3>
                                    </div>
                                    <!-- Hidden Description Panel -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-start px-2 py-3 park-info transition ps-3">
                                        <div class="">
                                            <h5 class="fw-semibold top-park-title">Corbett Tiger
                                                Reserve
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between gap-1">
                                            <div class="">
                                                <p class="mb-0 small">A popular destination in
                                                    Uttarakhand, home
                                                    to tigers, elephants, and rich biodiversity.
                                                </p>
                                            </div>
                                            <a href="javascript:void(0)" class="readmorearrow text-decoration-none">
                                                <i
                                                    class="fa-solid fa-arrow-right text-white p-1 border blue-border-hover rounded-circle border-white border-3"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="card park-card border-0 shadow-sm position-relative overflow-hidden">
                                    <img src="{{ asset('front-assets/images/animal-images/lion.jpg')}}" class="img-fluid"
                                        alt="Corbett Tiger Reserve">
                                    <!-- Initial Name Bar -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-center py-2 park-name transition">
                                        <h3 class="top-park-title mb-0"> Corbett Tiger Reserve
                                        </h3>
                                    </div>
                                    <!-- Hidden Description Panel -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-start px-2 py-3 park-info transition ps-3">
                                        <div class="">
                                            <h5 class="fw-semibold top-park-title">Corbett Tiger
                                                Reserve
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between gap-1">
                                            <div class="">
                                                <p class="mb-0 small">A popular destination in
                                                    Uttarakhand, home
                                                    to tigers, elephants, and rich biodiversity.
                                                </p>
                                            </div>
                                            <a href="javascript:void(0)" class="readmorearrow text-decoration-none">
                                                <i
                                                    class="fa-solid fa-arrow-right text-white p-1 border blue-border-hover rounded-circle border-white border-3"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="card park-card border-0 shadow-sm position-relative overflow-hidden">
                                    <img src="{{ asset('front-assets/images/animal-images/lion.jpg')}}" class="img-fluid"
                                        alt="Corbett Tiger Reserve">
                                    <!-- Initial Name Bar -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-center py-2 park-name transition">
                                        <h3 class="top-park-title mb-0"> Corbett Tiger Reserve
                                        </h3>
                                    </div>
                                    <!-- Hidden Description Panel -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-start px-2 py-3 park-info transition ps-3">
                                        <div class="">
                                            <h5 class="fw-semibold top-park-title">Corbett Tiger
                                                Reserve
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between gap-1">
                                            <div class="">
                                                <p class="mb-0 small">A popular destination in
                                                    Uttarakhand, home
                                                    to tigers, elephants, and rich biodiversity.
                                                </p>
                                            </div>
                                            <a href="javascript:void(0)" class="readmorearrow text-decoration-none">
                                                <i
                                                    class="fa-solid fa-arrow-right text-white p-1 border blue-border-hover rounded-circle border-white border-3"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="card park-card border-0 shadow-sm position-relative overflow-hidden">
                                    <img src="{{ asset('front-assets/images/animal-images/lion.jpg')}}" class="img-fluid"
                                        alt="Corbett Tiger Reserve">
                                    <!-- Initial Name Bar -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-center py-2 park-name transition">
                                        <h3 class="top-park-title mb-0"> Corbett Tiger Reserve
                                        </h3>
                                    </div>
                                    <!-- Hidden Description Panel -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-start px-2 py-3 park-info transition ps-3">
                                        <div class="">
                                            <h5 class="fw-semibold top-park-title">Corbett Tiger
                                                Reserve
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between gap-1">
                                            <div class="">
                                                <p class="mb-0 small">A popular destination in
                                                    Uttarakhand, home
                                                    to tigers, elephants, and rich biodiversity.
                                                </p>
                                            </div>
                                            <a href="javascript:void(0)" class="readmorearrow text-decoration-none">
                                                <i
                                                    class="fa-solid fa-arrow-right text-white p-1 border blue-border-hover rounded-circle border-white border-3"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="card park-card border-0 shadow-sm position-relative overflow-hidden">
                                    <img src="{{ asset('front-assets/images/animal-images/lion.jpg')}}" class="img-fluid"
                                        alt="Corbett Tiger Reserve">
                                    <!-- Initial Name Bar -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-center py-2 park-name transition">
                                        <h3 class="top-park-title mb-0"> Corbett Tiger Reserve
                                        </h3>
                                    </div>
                                    <!-- Hidden Description Panel -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-start px-2 py-3 park-info transition ps-3">
                                        <div class="">
                                            <h5 class="fw-semibold top-park-title">Corbett Tiger
                                                Reserve
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between gap-1">
                                            <div class="">
                                                <p class="mb-0 small">A popular destination in
                                                    Uttarakhand, home
                                                    to tigers, elephants, and rich biodiversity.
                                                </p>
                                            </div>
                                            <a href="javascript:void(0)" class="readmorearrow text-decoration-none">
                                                <i
                                                    class="fa-solid fa-arrow-right text-white p-1 border blue-border-hover rounded-circle border-white border-3"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="card park-card border-0 shadow-sm position-relative overflow-hidden">
                                    <img src="{{ asset('front-assets/images/animal-images/lion.jpg')}}" class="img-fluid"
                                        alt="Corbett Tiger Reserve">
                                    <!-- Initial Name Bar -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-center py-2 park-name transition">
                                        <h3 class="top-park-title mb-0"> Corbett Tiger Reserve
                                        </h3>
                                    </div>
                                    <!-- Hidden Description Panel -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-start px-2 py-3 park-info transition ps-3">
                                        <div class="">
                                            <h5 class="fw-semibold top-park-title">Corbett Tiger
                                                Reserve
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between gap-1">
                                            <div class="">
                                                <p class="mb-0 small">A popular destination in
                                                    Uttarakhand, home
                                                    to tigers, elephants, and rich biodiversity.
                                                </p>
                                            </div>
                                            <a href="javascript:void(0)" class="readmorearrow text-decoration-none">
                                                <i
                                                    class="fa-solid fa-arrow-right text-white p-1 border blue-border-hover rounded-circle border-white border-3"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="card park-card border-0 shadow-sm position-relative overflow-hidden">
                                    <img src="{{ asset('front-assets/images/animal-images/lion.jpg')}}" class="img-fluid"
                                        alt="Corbett Tiger Reserve">
                                    <!-- Initial Name Bar -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-center py-2 park-name transition">
                                        <h3 class="top-park-title mb-0"> Corbett Tiger Reserve
                                        </h3>
                                    </div>
                                    <!-- Hidden Description Panel -->
                                    <div
                                        class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75 text-white text-start px-2 py-3 park-info transition ps-3">
                                        <div class="">
                                            <h5 class="fw-semibold top-park-title">Corbett Tiger
                                                Reserve
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between gap-1">
                                            <div class="">
                                                <p class="mb-0 small">A popular destination in
                                                    Uttarakhand, home
                                                    to tigers, elephants, and rich biodiversity.
                                                </p>
                                            </div>
                                            <a href="javascript:void(0)" class="readmorearrow text-decoration-none">
                                                <i
                                                    class="fa-solid fa-arrow-right text-white p-1 border blue-border-hover rounded-circle border-white border-3"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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