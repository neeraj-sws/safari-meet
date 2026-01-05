<div>
    <main>
        <section id="package-carousel-section" class="">
            <!-- <div class="container-fluid container--padding"> -->
            <!-- <div class="row"> -->
            <div class="pe-md-0">
                <div class="guest-carousel-wrapper position-relative">

                    <!-- ✅ TEXT OVERLAY -->
                    <div class="carousel-text position-absolute text-white text-center w-100">
                        <h2>3 Night / 4 Days Stay - Ranthambore</h2>
                    </div>

                    <div class="owl-carousel owl-theme" id="package-detail-slider">
                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="carousel-image">
                                    <img src="{{ asset('front-assets/images/carousel-images/carousel-1.jpg')}}" alt="Carousel-1"
                                        class="img-fluid rounded--4">
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="carousel-image">
                                    <img src="{{ asset('front-assets/images/carousel-images/carousel-2.jpg')}}" alt="Carousel-2"
                                        class="img-fluid rounded--4">
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="owl-slide text-center mx-auto">
                                <div class="carousel-image">
                                    <img src="{{ asset('front-assets/images/carousel-images/carousel-3.jpg')}}" alt="Carousel-3"
                                        class="img-fluid rounded--4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="general-info" class="grey-bg py-5">
            <div class="container-lg container-inner-padding">
                <div class="row gx-3 align-items-center">
                    <div class="col-md-3">
                        <div class="general-info-img text-md-start text-center mb-md-0 mb-3">
                            <img src="{{ asset($shareSafari->display_image)}}" alt="Pathway-image"
                                class="img-fluid rounded-3">
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="general-info-list border-start ps-2 border-primary mb-md-0 mb-3">
                            <ul class="list-unstyled mb-0  package-lists">
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-wrap mb-3">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M480-80q-106 0-173-33.5T240-200q0-24 14.5-44.5T295-280l63 59q-9 4-19.5 9T322-200q13 16 60 28t98 12q51 0 98.5-12t60.5-28q-7-8-18-13t-21-9l62-60q28 16 43 36.5t15 45.5q0 53-67 86.5T480-80Zm1-220q99-73 149-146.5T680-594q0-102-65-154t-135-52q-70 0-135 52t-65 154q0 67 49 139.5T481-300Zm-1 100Q339-304 269.5-402T200-594q0-71 25.5-124.5T291-808q40-36 90-54t99-18q49 0 99 18t90 54q40 36 65.5 89.5T760-594q0 94-69.5 192T480-200Zm0-320q33 0 56.5-23.5T560-600q0-33-23.5-56.5T480-680q-33 0-56.5 23.5T400-600q0 33 23.5 56.5T480-520Zm0-80Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2">Destination:</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">{{$shareSafari->park->title}},{{$shareSafari->park->state->name}}
                                        </p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-wrap mb-3">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M200-640h560v-80H200v80Zm0 0v-80 80Zm0 560q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v227q-19-9-39-15t-41-9v-43H200v400h252q7 22 16.5 42T491-80H200Zm520 40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Zm67-105 28-28-75-75v-112h-40v128l87 87Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2">Duration:</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">{{$durationText}}</p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-wrap mb-3">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M240-200q-50 0-85-35t-35-85H40v-360q0-33 23.5-56.5T120-760h560l240 240v200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H360q0 50-35 85t-85 35Zm360-360h160L640-680h-40v120Zm-240 0h160v-120H360v120Zm-240 0h160v-120H120v120Zm120 290q21 0 35.5-14.5T290-320q0-21-14.5-35.5T240-370q-21 0-35.5 14.5T190-320q0 21 14.5 35.5T240-270Zm480 0q21 0 35.5-14.5T770-320q0-21-14.5-35.5T720-370q-21 0-35.5 14.5T670-320q0 21 14.5 35.5T720-270ZM120-400h32q17-18 39-29t49-11q27 0 49 11t39 29h304q17-18 39-29t49-11q27 0 49 11t39 29h32v-80H120v80Zm720-80H120h720Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2">Safari Type: :</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">Jeep Safari</p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-wrap mb-3">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M531-260h96v-3L462-438l1-3h10q54 0 89.5-33t43.5-77h40v-47h-41q-3-15-10.5-28.5T576-653h70v-47H314v57h156q26 0 42.5 13t22.5 32H314v47h222q-6 20-23 34.5T467-502H367v64l164 178ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2">Starting Price: :</p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">₹{{$shareSafari->min_price_pp}} To ₹{{$shareSafari->max_price_pp}} per person</p>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                <path
                                                    d="M680-120q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Zm-30-280v-80h60v80h-60Zm0 400v-80h60V0h-60Zm165-333-43-42 57-57 42 43-56 56ZM531-49l-42-42 57-57 42 42-57 57Zm309-161v-60h80v60h-80Zm-400 0v-60h80v60h-80ZM829-49l-56-57 42-42 57 56-43 43ZM545-332l-56-57 42-42 57 56-43 43ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v160H200v400h160v80H200Zm0-560h560v-80H200v80Zm0 0v-80 80Z" />
                                            </svg>
                                            <p class="mb-0 list-name grey-text me-2">Best Time: </p>
                                        </div>
                                        <p class="mb-0 list-paragraph text-dark">October – June</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto ms-md-auto mt-auto">
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                            <a href="https://safari-meet.codelive.info/package-detail.html"
                                class="btn btn-sm btn-primary blue-btn-hover border-blue blue-border-hover rounded-1">Enquire
                                Now</a>
 
                            <a href="#"
                                class="btn btn-sm border border-blue blue-border-hover blue-text-hover border-2 rounded-1">Join
                                Shared
                                Safari</a>
                        </div>
                        <div class="organizer-name d-flex align-items-center gap-2">
                            <img src="{{ asset('front-assets/images/icons/user-img.jpeg')}}" alt="dummy-user" class="img-fluid rounded-circle">
                            <div class="d-flex align-items-center">
                                <span class="small me-2">Organized by:</span>
                                <strong>
                                    John Deo
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="package-details-nav" class="mb-4 border-bottom">
            <div class="container-lg container-inner-padding">
                <nav class="overflow-auto mb-3">
                    <ul class="navbar-nav flex-row flex-nowrap gap-3" id="packageDetailNav"
                        style="white-space: nowrap;">
                        <li class="nav-item">
                            <a class="nav-link pb-0 ps-0 fw-semibold" href="#secion-itinerary">Itinerary</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pb-0 fw-semibold" href="#section-inclusions">Inclusions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pb-0 fw-semibold" href="#section-exclusions">Exclusions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pb-0 fw-semibold" href="#section-accommodation">Accommodation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pb-0 fw-semibold" href="#section-rates">Rates</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pb-0 fw-semibold" href="#section-thing-to-carry">Things to Carry</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pb-0 fw-semibold" href="#section-faq">FAQ’s</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </section>

        <section id="package-details" class="mb-sm-5 mb-4">
            <div class="container-lg container-inner-padding">
                <div class="row">
                    <div class="col-md-8">
                        <div class="secion-itinerary package-accordion mb-4" id="secion-itinerary">
                            <h3 class="text-blue">Itinerary</h3>
                            <div class="accordion p-3 rounded-3 dark-grey-bg" id="itineraryAccordion">
                                <!-- Day 1 -->
                                <div class="accordion-item mb-3 rounded-3">
                                    <h2 class="accordion-header rounded-top-3" id="day1">
                                        <button class="accordion-button rounded-top-3 rounded-bottom-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseDay1">
                                            Day 1: Arrival at Sawai Madhopur & Check-in
                                        </button>
                                    </h2>
                                    <div id="collapseDay1" class="accordion-collapse collapse show"
                                        data-bs-parent="#itineraryAccordion">
                                        <div class="accordion-body pt-0">
                                            <ul class="list-unstyled mb-0  package-lists">
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Early
                                                    morning
                                                    jeep
                                                    safari in core
                                                    zone</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Return for
                                                    breakfast
                                                    & relax</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Lunch at the
                                                    lodge
                                                </li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Afternoon
                                                    safari
                                                    in
                                                    a different
                                                    zone</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Dinner &
                                                    overnight
                                                    stay</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Day 2 -->
                                <div class="accordion-item mb-3 rounded-3">
                                    <h2 class="accordion-header rounded-top-3" id="day2">
                                        <button class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseDay2">
                                            Day 2: Morning & Afternoon Safari
                                        </button>
                                    </h2>
                                    <div id="collapseDay2" class="accordion-collapse collapse"
                                        data-bs-parent="#itineraryAccordion">
                                        <div class="accordion-body pt-0">
                                            <ul class="list-unstyled mb-0  package-lists">
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Early
                                                    morning
                                                    jeep
                                                    safari in core
                                                    zone</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Return for
                                                    breakfast
                                                    & relax</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Lunch at the
                                                    lodge
                                                </li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Afternoon
                                                    safari
                                                    in
                                                    a different
                                                    zone</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Dinner &
                                                    overnight
                                                    stay</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Day 3 -->
                                <div class="accordion-item mb-3 rounded-3">
                                    <h2 class="accordion-header rounded-top-3" id="day3">
                                        <button class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseDay3">
                                            Day 3: Optional Safari + Local Sightseeing
                                        </button>
                                    </h2>
                                    <div id="collapseDay3" class="accordion-collapse collapse"
                                        data-bs-parent="#itineraryAccordion">
                                        <div class="accordion-body pt-0">
                                            <ul class="list-unstyled mb-0  package-lists">
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Early
                                                    morning
                                                    jeep
                                                    safari in core
                                                    zone</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Return for
                                                    breakfast
                                                    & relax</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Lunch at the
                                                    lodge
                                                </li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Afternoon
                                                    safari
                                                    in
                                                    a different
                                                    zone</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Dinner &
                                                    overnight
                                                    stay</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Day 4 -->
                                <div class="accordion-item mb-0 rounded-3">
                                    <h2 class="accordion-header rounded-top-3" id="day4">
                                        <button class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseDay4">
                                            Day 4: Check-out & Departure
                                        </button>
                                    </h2>
                                    <div id="collapseDay4" class="accordion-collapse collapse"
                                        data-bs-parent="#itineraryAccordion">
                                        <div class="accordion-body pt-0">
                                            <ul class="list-unstyled mb-0  package-lists">
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Early
                                                    morning
                                                    jeep
                                                    safari in core
                                                    zone</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Return for
                                                    breakfast
                                                    & relax</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Lunch at the
                                                    lodge
                                                </li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Afternoon
                                                    safari
                                                    in
                                                    a different
                                                    zone</li>
                                                <li class="mb-2"><i class="fa-regular fa-circle-check"></i> Dinner &
                                                    overnight
                                                    stay</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="section-inclusions p-3 rounded-3 dark-grey-bg mb-4" id="section-inclusions">
                            <div class="bg-white px-4 py-3 rounded-3">
                                <h3 class="text-blue">Inclusions</h3>
                                <ul class="list-unstyled mb-0  package-lists">
                                    <li class="mb-2">
                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#333333">
                                            <path
                                                d="M240-200q-50 0-85-35t-35-85H40v-360q0-33 23.5-56.5T120-760h560l240 240v200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H360q0 50-35 85t-85 35Zm360-360h160L640-680h-40v120Zm-240 0h160v-120H360v120Zm-240 0h160v-120H120v120Zm120 290q21 0 35.5-14.5T290-320q0-21-14.5-35.5T240-370q-21 0-35.5 14.5T190-320q0 21 14.5 35.5T240-270Zm480 0q21 0 35.5-14.5T770-320q0-21-14.5-35.5T720-370q-21 0-35.5 14.5T670-320q0 21 14.5 35.5T720-270ZM120-400h32q17-18 39-29t49-11q27 0 49 11t39 29h304q17-18 39-29t49-11q27 0 49 11t39 29h32v-80H120v80Zm720-80H120h720Z" />
                                        </svg>
                                        3 Jeep Safaris
                                    </li>

                                    <li class="mb-2">
                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#333333">
                                            <path
                                                d="M160-120v-375l-72 55-48-64 120-92v-124h80v63l240-183 440 336-48 63-72-54v375H160Zm80-80h200v-160h80v160h200v-356L480-739 240-556v356Zm-80-560q0-50 35-85t85-35q17 0 28.5-11.5T320-920h80q0 50-35 85t-85 35q-17 0-28.5 11.5T240-760h-80Zm80 560h480-480Z" />
                                        </svg>
                                        3N Stay in jungle lodge
                                    </li>

                                    <li class="mb-2">
                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#333333">
                                            <path
                                                d="m175-120-56-56 410-410q-18-42-5-95t57-95q53-53 118-62t106 32q41 41 32 106t-62 118q-42 44-95 57t-95-5l-50 50 304 304-56 56-304-302-304 302Zm118-342L173-582q-54-54-54-129t54-129l248 250-128 128Z" />
                                        </svg>
                                        All meals (B/L/D)
                                    </li>

                                    <li class="mb-2">
                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#333333">
                                            <path
                                                d="m387-412 35-114-92-74h114l36-112 36 112h114l-93 74 35 114-92-71-93 71ZM240-40v-309q-38-42-59-96t-21-115q0-134 93-227t227-93q134 0 227 93t93 227q0 61-21 115t-59 96v309l-240-80-240 80Zm240-280q100 0 170-70t70-170q0-100-70-170t-170-70q-100 0-170 70t-70 170q0 100 70 170t170 70ZM320-159l160-41 160 41v-124q-35 20-75.5 31.5T480-240q-44 0-84.5-11.5T320-283v124Zm160-62Z" />
                                        </svg>
                                        Safari permits
                                    </li>
                                    <li class="mb-2">
                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#333333">
                                            <path
                                                d="m600-120-240-84-186 72q-20 8-37-4.5T120-170v-560q0-13 7.5-23t20.5-15l212-72 240 84 186-72q20-8 37 4.5t17 33.5v560q0 13-7.5 23T812-192l-212 72Zm-40-98v-468l-160-56v468l160 56Zm80 0 120-40v-474l-120 46v468Zm-440-10 120-46v-468l-120 40v474Zm440-458v468-468Zm-320-56v468-468Z" />
                                        </svg>
                                        Guide & naturalist
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="section-exclusions p-3 rounded-3 dark-grey-bg mb-4" id="section-exclusions">
                            <div class="bg-white px-4 py-3 rounded-3">
                                <h3 class="text-blue">Exclusions</h3>
                                <ul class="list-unstyled mb-0  package-lists">
                                    <li class="mb-2">
                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#333333">
                                            <path
                                                d="M240-200q-50 0-85-35t-35-85H40v-360q0-33 23.5-56.5T120-760h560l240 240v200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H360q0 50-35 85t-85 35Zm360-360h160L640-680h-40v120Zm-240 0h160v-120H360v120Zm-240 0h160v-120H120v120Zm120 290q21 0 35.5-14.5T290-320q0-21-14.5-35.5T240-370q-21 0-35.5 14.5T190-320q0 21 14.5 35.5T240-270Zm480 0q21 0 35.5-14.5T770-320q0-21-14.5-35.5T720-370q-21 0-35.5 14.5T670-320q0 21 14.5 35.5T720-270ZM120-400h32q17-18 39-29t49-11q27 0 49 11t39 29h304q17-18 39-29t49-11q27 0 49 11t39 29h32v-80H120v80Zm720-80H120h720Z" />
                                        </svg>
                                        Travel Insurance
                                    </li>

                                    <li class="mb-2">
                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#333333">
                                            <path
                                                d="M280-80v-100l120-84v-144L80-280v-120l320-224v-176q0-33 23.5-56.5T480-880q33 0 56.5 23.5T560-800v176l320 224v120L560-408v144l120 84v100l-200-60-200 60Z" />
                                        </svg>
                                        Any Airfare, Any Still OR Video Camera fee
                                    </li>

                                    <li class="mb-2">
                                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#333333">
                                            <path
                                                d="M336-120q-91 0-153.5-62.5T120-336q0-38 13-74t37-65l142-171-97-194h530l-97 194 142 171q24 29 37 65t13 74q0 91-63 153.5T624-120H336Zm144-200q-33 0-56.5-23.5T400-400q0-33 23.5-56.5T480-480q33 0 56.5 23.5T560-400q0 33-23.5 56.5T480-320Zm-95-360h190l40-80H345l40 80Zm-49 480h288q57 0 96.5-39.5T760-336q0-24-8.5-46.5T728-423L581-600H380L232-424q-15 18-23.5 41t-8.5 47q0 57 39.5 96.5T336-200Z" />
                                        </svg>
                                        Expenses of personal nature such as laundry, telephone calls, drinks, tipping
                                        etc
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="section-accommodation p-3 rounded-3 dark-grey-bg mb-4" id="section-accommodation">
                            <div class="bg-white px-4 py-3 rounded-3">
                                <h3 class="text-blue mb-3">Accommodation Details:</h3>
                                <!-- Grid for desktop -->

                                <div class="row">
                                    <div class="col-xl-6 mb-xl-0 mb-3 d-sm-block d-none">
                                        <div class="row row-gap-3 gx-3">
                                            <div class="col-6">
                                                <div class="accommodation-right">
                                                    <img src="{{ asset('front-assets/images/lodge/lodge-1.jpg')}}" alt="Lodge-1"
                                                        class="img-fluid w-100 rounded-3">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="accommodation-right">
                                                    <img src="{{ asset('front-assets/images/lodge/lodge-3.jpg')}}" alt="Lodge-3"
                                                        class="img-fluid w-100 rounded-3">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="accommodation-right">
                                                    <img src="{{ asset('front-assets/images/lodge/lodge-2.jpg')}}" alt="Lodge-2"
                                                        class="img-fluid w-100 rounded-3">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="accommodation-right">
                                                    <img src="{{ asset('front-assets/images/lodge/lodge-4.jpg')}}" alt="Lodge-4"
                                                        class="img-fluid w-100 rounded-3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 mb-xl-0 mb-3 ps-xl-1 d-sm-block d-none">
                                        <div class="accommodation-left mb-3">
                                            <img src="{{ asset('front-assets/images/lodge/lodge-5.jpg')}}" class="img-fluid w-100 rounded-3"
                                                alt="Lodge-5">
                                        </div>
                                    </div>
                                    <!-- Owl Carousel for mobile only -->
                                    <div class="col-12 d-sm-none owl-carousel owl-theme mb-3">
                                        <div class="item">
                                            <img src="{{ asset('front-assets/images/lodge/lodge-1.jpg')}}" alt="Lodge-1"
                                                class="img-fluid rounded-3 accommodation-mobile-img">
                                        </div>
                                        <div class="item">
                                            <img src="{{ asset('front-assets/images/lodge/lodge-3.jpg')}}" alt="Lodge-3"
                                                class="img-fluid rounded-3 accommodation-mobile-img">
                                        </div>
                                        <div class="item">
                                            <img src="{{ asset('front-assets/images/lodge/lodge-2.jpg')}}" alt="Lodge-2"
                                                class="img-fluid rounded-3 accommodation-mobile-img">
                                        </div>
                                        <div class="item">
                                            <img src="{{ asset('front-assets/images/lodge/lodge-4.jpg')}}" alt="Lodge-4"
                                                class="img-fluid rounded-3 accommodation-mobile-img">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="lodge-name">
                                            <h3 class="mb-1 text-accent">Ranthambore Bagh Villa</h3>
                                            <div class="star-rating d-flex align-items-center gap-1 mb-1">
                                                <img src="{{ asset('front-assets/images/icons/star-fill.png')}}">
                                                <img src="{{ asset('front-assets/images/icons/star-fill.png')}}">
                                                <img src="{{ asset('front-assets/images/icons/star-fill.png')}}">
                                                <img src="{{ asset('front-assets/images/icons/star-fill.png')}}">
                                                <img src="{{ asset('front-assets/images/icons/half-fill.png')}}">
                                            </div>
                                            <div class="category">
                                                <span class="text-dark">Category:</span>
                                                <p class="text-dark d-inline-block">Premium</p>
                                            </div>
                                        </div>
                                        <div class="amenities-container">
                                            <h3 class="text-blue">Amenities</h3>
                                            <div class="d-flex align-items-center  gap-3 flex-wrap">
                                                <div class="amenities me-3">
                                                    <svg class="me-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                        <path
                                                            d="M480-120q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM254-346l-84-86q59-59 138.5-93.5T480-560q92 0 171.5 35T790-430l-84 84q-44-44-102-69t-124-25q-66 0-124 25t-102 69ZM84-516 0-600q92-94 215-147t265-53q142 0 265 53t215 147l-84 84q-77-77-178.5-120.5T480-680q-116 0-217.5 43.5T84-516Z" />
                                                    </svg>

                                                    <span class="text-dark">WiFi</span>
                                                </div>
                                                <div class="amenities me-3">
                                                    <svg class="me-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                        <path
                                                            d="m175-120-56-56 410-410q-18-42-5-95t57-95q53-53 118-62t106 32q41 41 32 106t-62 118q-42 44-95 57t-95-5l-50 50 304 304-56 56-304-302-304 302Zm118-342L173-582q-54-54-54-129t54-129l248 250-128 128Z" />
                                                    </svg>

                                                    <span class="text-dark"> In-House Restaurant</span>
                                                </div>
                                                <div class="amenities me-3">
                                                    <svg class="me-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                        <path
                                                            d="M300-320q25 0 42.5-17.5T360-380q0-25-17.5-42.5T300-440q-25 0-42.5 17.5T240-380q0 25 17.5 42.5T300-320Zm360 0q25 0 42.5-17.5T720-380q0-25-17.5-42.5T660-440q-25 0-42.5 17.5T600-380q0 25 17.5 42.5T660-320ZM160-120q-17 0-28.5-11.5T120-160v-320l84-240q6-18 21.5-29t34.5-11h300v80H274l-42 120h328v80H200v200h560v-200h80v320q0 17-11.5 28.5T800-120h-40q-17 0-28.5-11.5T720-160v-40H240v40q0 17-11.5 28.5T200-120h-40Zm40-360v200-200Zm474-80q-14 0-24-10t-10-24v-132q0-14 10-24t24-10h6v-40q0-33 23.5-56.5T760-880q33 0 56.5 23.5T840-800v40h6q14 0 24 10t10 24v132q0 14-10 24t-24 10H674Zm46-200h80v-40q0-17-11.5-28.5T760-840q-17 0-28.5 11.5T720-800v40Z" />
                                                    </svg>

                                                    <span class="text-dark">Parking</span>
                                                </div>
                                                <div class="amenities me-3">

                                                    <svg class="me-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                        <path
                                                            d="M80-120v-80q38 0 57-20t75-20q56 0 77 20t57 20q36 0 57-20t77-20q56 0 77 20t57 20q36 0 57-20t77-20q56 0 75 20t57 20v80q-59 0-77.5-20T748-160q-36 0-57 20t-77 20q-56 0-77-20t-57-20q-36 0-57 20t-77 20q-56 0-77-20t-57-20q-36 0-54.5 20T80-120Zm0-180v-80q38 0 57-20t75-20q56 0 77.5 20t56.5 20q36 0 57-20t77-20q56 0 77 20t57 20q36 0 57-20t77-20q56 0 75 20t57 20v80q-59 0-77.5-20T748-340q-36 0-55.5 20T614-300q-57 0-77.5-20T480-340q-38 0-56.5 20T346-300q-59 0-78.5-20T212-340q-36 0-54.5 20T80-300Zm196-204 133-133-40-40q-33-33-70-48t-91-15v-100q75 0 124 16.5t96 63.5l256 256q-17 11-33 17.5t-37 6.5q-36 0-57-20t-77-20q-56 0-77 20t-57 20q-21 0-37-6.5T276-504Zm392-336q42 0 71 29.5t29 70.5q0 42-29 71t-71 29q-42 0-71-29t-29-71q0-41 29-70.5t71-29.5Z" />
                                                    </svg>
                                                    <span class="text-dark">Swimming Pool</span>
                                                </div>
                                                <div class="amenities me-3">
                                                    <svg class="me-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                        <path
                                                            d="M480-120q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM254-346l-84-86q59-59 138.5-93.5T480-560q92 0 171.5 35T790-430l-84 84q-44-44-102-69t-124-25q-66 0-124 25t-102 69ZM84-516 0-600q92-94 215-147t265-53q142 0 265 53t215 147l-84 84q-77-77-178.5-120.5T480-680q-116 0-217.5 43.5T84-516Z" />
                                                    </svg>

                                                    <span class="text-dark">WiFi</span>
                                                </div>
                                                <div class="amenities me-3">
                                                    <svg class="me-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                        <path
                                                            d="m175-120-56-56 410-410q-18-42-5-95t57-95q53-53 118-62t106 32q41 41 32 106t-62 118q-42 44-95 57t-95-5l-50 50 304 304-56 56-304-302-304 302Zm118-342L173-582q-54-54-54-129t54-129l248 250-128 128Z" />
                                                    </svg>

                                                    <span class="text-dark"> In-House Restaurant</span>
                                                </div>
                                                <div class="amenities me-3">
                                                    <svg class="me-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                        <path
                                                            d="M300-320q25 0 42.5-17.5T360-380q0-25-17.5-42.5T300-440q-25 0-42.5 17.5T240-380q0 25 17.5 42.5T300-320Zm360 0q25 0 42.5-17.5T720-380q0-25-17.5-42.5T660-440q-25 0-42.5 17.5T600-380q0 25 17.5 42.5T660-320ZM160-120q-17 0-28.5-11.5T120-160v-320l84-240q6-18 21.5-29t34.5-11h300v80H274l-42 120h328v80H200v200h560v-200h80v320q0 17-11.5 28.5T800-120h-40q-17 0-28.5-11.5T720-160v-40H240v40q0 17-11.5 28.5T200-120h-40Zm40-360v200-200Zm474-80q-14 0-24-10t-10-24v-132q0-14 10-24t24-10h6v-40q0-33 23.5-56.5T760-880q33 0 56.5 23.5T840-800v40h6q14 0 24 10t10 24v132q0 14-10 24t-24 10H674Zm46-200h80v-40q0-17-11.5-28.5T760-840q-17 0-28.5 11.5T720-800v40Z" />
                                                    </svg>

                                                    <span class="text-dark">Parking</span>
                                                </div>
                                                <div class="amenities me-3">

                                                    <svg class="me-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                                        viewBox="0 -960 960 960" width="24px" fill="#333333">
                                                        <path
                                                            d="M80-120v-80q38 0 57-20t75-20q56 0 77 20t57 20q36 0 57-20t77-20q56 0 77 20t57 20q36 0 57-20t77-20q56 0 75 20t57 20v80q-59 0-77.5-20T748-160q-36 0-57 20t-77 20q-56 0-77-20t-57-20q-36 0-57 20t-77 20q-56 0-77-20t-57-20q-36 0-54.5 20T80-120Zm0-180v-80q38 0 57-20t75-20q56 0 77.5 20t56.5 20q36 0 57-20t77-20q56 0 77 20t57 20q36 0 57-20t77-20q56 0 75 20t57 20v80q-59 0-77.5-20T748-340q-36 0-55.5 20T614-300q-57 0-77.5-20T480-340q-38 0-56.5 20T346-300q-59 0-78.5-20T212-340q-36 0-54.5 20T80-300Zm196-204 133-133-40-40q-33-33-70-48t-91-15v-100q75 0 124 16.5t96 63.5l256 256q-17 11-33 17.5t-37 6.5q-36 0-57-20t-77-20q-56 0-77 20t-57 20q-21 0-37-6.5T276-504Zm392-336q42 0 71 29.5t29 70.5q0 42-29 71t-71 29q-42 0-71-29t-29-71q0-41 29-70.5t71-29.5Z" />
                                                    </svg>
                                                    <span class="text-dark">Swimming Pool</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section-rates p-3 rounded-3 dark-grey-bg mb-4" id="section-rates">
                            <h3 class="text-blue mb-3">Rates:</h3>
                            <div class="table-responsive mb-md-0 mb-3">
                                <table class="custom-table" cellspacing="10px" id="bestTimeToVisit">
                                    <!-- First Header Row -->
                                    <tbody>
                                        <tr>
                                            <td colspan="3" class="table-header p-3 bg-white border-1 border-blue">
                                                <h3 class="text-blue fw-semibold m-0">Rates Info Per Person

                                                </h3>
                                            </td>
                                        </tr>

                                        <!-- Second Header Row -->
                                        <tr class="table-header p-2">
                                            <td class="p-3 bg-white border-1 border-blue fw-bold">Safari Type</td>
                                            <td class="p-3 bg-white border-1 border-blue fw-bold">1 Person</td>
                                            <td class="p-3 bg-white border-1 border-blue fw-bold">6 Person</td>
                                        </tr>

                                        <!-- Row 1 -->
                                        <tr>
                                            <td class="p-3 bg-white border-1 border-blue fw-normal">Canter Safari</td>
                                            <td class="p-3 bg-white border-1 border-blue fw-normal">Rs. 600</td>
                                            <td class="p-3 bg-white border-1 border-blue fw-normal">Rs. 3000</td>
                                        </tr>

                                        <!-- Row 2 -->
                                        <tr>
                                            <td class="p-3 bg-white border-1 border-blue fw-normal">Jeep Safari</td>
                                            <td class="p-3 bg-white border-1 border-blue fw-normal">Rs. 600</td>
                                            <td class="p-3 bg-white border-1 border-blue fw-normal">Rs. 3000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    
                        </div>



                        <div class="section-thing-to-carry p-3 rounded-3 dark-grey-bg mb-4" id="section-thing-to-carry">
                            <div class="bg-white px-4 py-3 rounded-3">
                                <h3 class="text-blue">Things to Carry</h3>
                                <ul class="list-unstyled mb-0  package-lists">
                                    <li class="mb-2">
                                        <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check" class="img-fluid">
                                        <b>Neutral-colored clothes</b> (olive, beige, brown, green) – bright colors
                                        disturb wildlife
                                    </li>

                                    <li class="mb-2">
                                        <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check" class="img-fluid">
                                        <b> Cap or hat </b> – for sun protection during open jeep safaris
                                    </li>

                                    <li class="mb-2">
                                        <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check" class="img-fluid">
                                        <b>Sunglasses </b> – to protect your eyes from glare
                                    </li>

                                    <li class="mb-2">
                                        <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check" class="img-fluid">
                                        <b>Light jacket or fleece</b> – especially for morning safaris (it gets
                                        chilly
                                        even in warmer months)


                                    </li>
                                    <li class="mb-2">
                                        <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check" class="img-fluid">
                                        <b>Comfortable walking shoes</b> – essential for any short walks or
                                        exploration
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="secion-faq mb-4 package-accordion" id="section-faq">
                            <h3 class="text-blue">FAQ's</h3>
                            <div class="accordion p-3 rounded-3 dark-grey-bg" id="faqAccordion">
                                <!-- Day 1 -->
                                <div class="accordion-item mb-3 rounded-3">
                                    <h2 class="accordion-header rounded-top-3" id="day1">
                                        <button class="accordion-button rounded-top-3 rounded-bottom-0" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#faq1">
                                            1: What is the best time for tiger sightings?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse show"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body pt-0">
                                            <ul class="list-unstyled mb-0  package-lists">
                                                <li><i class="fa-regular fa-circle-check"></i> March to June</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Day 2 -->
                                <div class="accordion-item mb-3 rounded-3">
                                    <h2 class="accordion-header rounded-top-3" id="day2">
                                        <button class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                            2: What documents are required for safari booking?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body pt-0">
                                            <ul class="list-unstyled mb-0  package-lists">
                                                <li><i class="fa-regular fa-circle-check"></i> Identification
                                                    documents
                                                    such
                                                    as
                                                    a government-issued ID (Aadhaar card, Voter ID, Driving License,
                                                    PAN
                                                    card,
                                                    or Passport for foreigners) and details like your name, age,
                                                    nationality,
                                                    and gender. </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Day 3 -->
                                <div class="accordion-item mb-3 rounded-3">
                                    <h2 class="accordion-header rounded-top-3" id="day3">
                                        <button class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                            3: Can I customize the itinerary?
                                        </button>
                                    </h2>
                                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body pt-0">
                                            <ul class="list-unstyled mb-0  package-lists">
                                                <li><i class="fa-regular fa-circle-check"></i> Yes, you can
                                                    customize
                                                    the
                                                    itinerary.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Day 4 -->
                                <div class="accordion-item mb-0 rounded-3">
                                    <h2 class="accordion-header rounded-top-3" id="day4">
                                        <button class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                            4: Are kids allowed?
                                        </button>
                                    </h2>
                                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body pt-0">
                                            <ul class="list-unstyled mb-0  package-lists">
                                                <li><i class="fa-regular fa-circle-check"></i> Yes</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="park-highlights">
                            <h3 class="text-blue text-center">Park Highlights</h3>
                            <div class="dark-grey-bg quick-info-box p-3 rounded-3 mb-4">
                                <div class="quickinfo-container mb-3">
                                    <h4 class="mb-1 pb-2 border-bottom border-accent">
                                        <svg class="me-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#333333">
                                            <path
                                                d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                        </svg>
                                        Quick Info
                                    </h4>
                                    <ul class="list-unstyled mb-0 quickinfo-list">
                                        <li>
                                            <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check"
                                                class="img-fluid">
                                            <span class="text-dark">Location:</span>
                                            <p class="d-inline-block mb-0 text-dark">Sawai Madhopur, Rajasthan</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check"
                                                class="img-fluid">
                                            <span class="text-dark">Area:</span>
                                            <p class="d-inline-block mb-0 text-dark">59 km2 (23 sq mi)</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check"
                                                class="img-fluid">
                                            <span class="text-dark">Area:</span>
                                            <p class="d-inline-block mb-0 text-dark">59 km2 (23 sq mi)</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="wildlife-container mb-3">
                                    <h4 class="mb-1 pb-2 border-bottom border-accent">
                                        <svg class="me-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#333333">
                                            <path
                                                d="M180-475q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180-160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm240 0q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29Zm180 160q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM266-75q-45 0-75.5-34.5T160-191q0-52 35.5-91t70.5-77q29-31 50-67.5t50-68.5q22-26 51-43t63-17q34 0 63 16t51 42q28 32 49.5 69t50.5 69q35 38 70.5 77t35.5 91q0 47-30.5 81.5T694-75q-54 0-107-9t-107-9q-54 0-107 9t-107 9Z" />
                                        </svg>
                                        Wildlife You May See
                                    </h4>
                                    <ul class="list-unstyled mb-0 quickinfo-list">
                                        <li>
                                            <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check"
                                                class="img-fluid">
                                            <p class="d-inline-block mb-0 text-dark">Bengal Tiger, Leopard</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check"
                                                class="img-fluid">
                                            <p class="d-inline-block mb-0 text-dark">Sloth Bear, Hyena, Marsh
                                                Crocodile
                                            </p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check"
                                                class="img-fluid">
                                            <p class="d-inline-block mb-0 text-dark">Sambar, Spotted Deer, Nilgai
                                            </p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check"
                                                class="img-fluid">
                                            <p class="d-inline-block mb-0 text-dark">300+ bird species</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="zones-container mb-0">
                                    <h4 class="mb-1 pb-2 border-bottom border-accent">
                                        <svg class="me-1" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#333333">
                                            <path
                                                d="M480-304 304-480l176-176 176 176-176 176Zm56 199q-11 11-26 17t-30 6q-15 0-30-6t-26-17L105-424q-11-11-17-26t-6-30q0-15 6-30t17-26l318-318q12-12 26.5-18t30.5-6q16 0 30.5 6t26.5 18l318 318q11 11 17 26t6 30q0 15-6 30t-17 26L536-105Zm-56-87 288-288-288-288-288 288 288 288Z" />
                                        </svg>
                                        Safari Zones
                                    </h4>
                                    <ul class="list-unstyled mb-0 quickinfo-list">
                                        <li>
                                            <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check"
                                                class="img-fluid">
                                            <span class="text-dark">Zones 1–5:</span>
                                            <p class="d-inline-block mb-0 text-dark">Core – High tiger activity</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check"
                                                class="img-fluid">
                                            <span class="text-dark">Zones 6–10:</span>
                                            <p class="d-inline-block mb-0 text-dark">Buffer – Less crowded</p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('front-assets/images/icons/double-check.svg')}}" alt="double-check"
                                                class="img-fluid">
                                            <span class="text-dark">Safari Options:</span>
                                            <p class="d-inline-block mb-0 text-dark">Jeep (6-seater) / Canter
                                                (20-seater)</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="guest-reviews-section">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4>Guest Reviews</h4>

                                    <div class="viewall-link d-flex align-items-center gap-1"></div>
                                </div>

                                <div class="owl-carousel owl-theme" id="guest-reviews-carousel">
                                    <div class="item">
                                        <div class="owl-slide text-center mx-auto">
                                            <a href="javascript:void(0)" class="text-decoration-none">
                                                <div
                                                    class="guest-review-container text-start rounded-4 mt-5 position-relative">
                                                    <div class="px-3 pt-3 pb-2">
                                                        <img src="{{ asset('front-assets/images/icons/user-img.jpeg')}}" alt="User Image"
                                                            class="userimg img-fluid rounded-circle position-absolute">
                                                        <h6 class="mt-2 mb-2 pb-1 border-bottom text-dark">Shekhar
                                                            Shah
                                                            &
                                                            Family</h6>
                                                        <p class="mb-0 text-dark">Lorem Ipsum is simply dummy text
                                                            of
                                                            the
                                                            printing and
                                                            typesetting
                                                            industry.
                                                            Lorem Ipsum has been the industry's standard dummy text
                                                            ever
                                                            since the 1500s,
                                                            when
                                                            an
                                                            unknown printer took a galley of type and scrambled it
                                                            to
                                                            make a
                                                            type specimen
                                                            book.
                                                        </p>
                                                    </div>
                                                    <div class="guest-star-rating d-flex align-items-center px-3 py-1">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/half-fill.png')}}" alt="Half-Star-Fill"
                                                            class="img-fluid">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <div class="owl-slide text-center mx-auto">
                                            <a href="javascript:void(0)" class="text-decoration-none">
                                                <div
                                                    class="guest-review-container text-start rounded-4 mt-5 position-relative">
                                                    <div class="px-3 pt-3 pb-2">
                                                        <img src="{{ asset('front-assets/images/icons/user-img.jpeg')}}" alt="User Image"
                                                            class="userimg img-fluid rounded-circle position-absolute">
                                                        <h6 class="mt-2 mb-2 pb-1 border-bottom text-dark">Shekhar
                                                            Shah
                                                            &
                                                            Family</h6>
                                                        <p class="mb-0 text-dark">Lorem Ipsum is simply dummy text
                                                            of
                                                            the
                                                            printing and
                                                            typesetting
                                                            industry.
                                                            Lorem Ipsum has been the industry's standard dummy text
                                                            ever
                                                            since the 1500s,
                                                            when
                                                            an
                                                            unknown printer took a galley of type and scrambled it
                                                            to
                                                            make a
                                                            type specimen
                                                            book.
                                                        </p>
                                                    </div>
                                                    <div class="guest-star-rating d-flex align-items-center px-3 py-1">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/half-fill.png')}}" alt="Half-Star-Fill"
                                                            class="img-fluid">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <div class="owl-slide text-center mx-auto">
                                            <a href="javascript:void(0)" class="text-decoration-none">
                                                <div
                                                    class="guest-review-container text-start rounded-4 mt-5 position-relative">
                                                    <div class="px-3 pt-3 pb-2">
                                                        <img src="{{ asset('front-assets/images/icons/user-img.jpeg')}}" alt="User Image"
                                                            class="userimg img-fluid rounded-circle position-absolute">
                                                        <h6 class="mt-2 mb-2 pb-1 border-bottom text-dark">Shekhar
                                                            Shah
                                                            &
                                                            Family</h6>
                                                        <p class="mb-0 text-dark">Lorem Ipsum is simply dummy text
                                                            of
                                                            the
                                                            printing and
                                                            typesetting
                                                            industry.
                                                            Lorem Ipsum has been the industry's standard dummy text
                                                            ever
                                                            since the 1500s,
                                                            when
                                                            an
                                                            unknown printer took a galley of type and scrambled it
                                                            to
                                                            make a
                                                            type specimen
                                                            book.
                                                        </p>
                                                    </div>
                                                    <div class="guest-star-rating d-flex align-items-center px-3 py-1">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/half-fill.png')}}" alt="Half-Star-Fill"
                                                            class="img-fluid">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <div class="owl-slide text-center mx-auto">
                                            <a href="javascript:void(0)" class="text-decoration-none">
                                                <div
                                                    class="guest-review-container text-start rounded-4 mt-5 position-relative">
                                                    <div class="px-3 pt-3 pb-2">
                                                        <img src="{{ asset('front-assets/images/icons/user-img.jpeg')}}" alt="User Image"
                                                            class="userimg img-fluid rounded-circle position-absolute">
                                                        <h6 class="mt-2 mb-2 pb-1 border-bottom text-dark">Shekhar
                                                            Shah
                                                            &
                                                            Family</h6>
                                                        <p class="mb-0 text-dark">Lorem Ipsum is simply dummy text
                                                            of
                                                            the
                                                            printing and
                                                            typesetting
                                                            industry.
                                                            Lorem Ipsum has been the industry's standard dummy text
                                                            ever
                                                            since the 1500s,
                                                            when
                                                            an
                                                            unknown printer took a galley of type and scrambled it
                                                            to
                                                            make a
                                                            type specimen
                                                            book.
                                                        </p>
                                                    </div>
                                                    <div class="guest-star-rating d-flex align-items-center px-3 py-1">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/star-fill.png')}}" alt="Star-Fill"
                                                            class="img-fluid">
                                                        <img src="{{ asset('front-assets/images/icons/half-fill.png')}}" alt="Half-Star-Fill"
                                                            class="img-fluid">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="similar-packages">
            <div class="container-lg container-inner-padding px-1">
                <div class="heading-text text-center mb-xl-4 mb-3">
                    <div class="">
                        <h2 class="mb-0 text-accent">Similar Packages</h2>
                        <img src="{{ asset('front-assets/images/blue-border-vector.png')}}" alt="Vector-Border" class="vector-border-bottom">
                    </div>
                </div>

                <div class="owl-carousel owl-theme" id="similar-packages-owl">
                    @foreach ($similarPackages as $similarPackage)    
                        <div class="item">
                            <div class="owl-slide text-start mx-auto">
                                <div class="join-safari-card-box mb-3 px-2 rounded-3">
                                    <div class="card rounded-3">
                                        <!-- Card Image -->
                                        <img class="card-img-top rounded-top-3" src="{{ asset($similarPackage->display_image) }}"
                                            alt="Card image">
                                        <!-- Card Body -->
                                        <div class="card-body p-0">
                                            <div class="card-body-inner border-bottom">
                                                <div class="card-title border-bottom pb-1">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <h4 class="mb-0 card-text">
                                                            {{$similarPackage->title}}
                                                        </h4>
                                                        <div class="count-days px-2 rounded-1">
                                                            <span class="text-white">3N/4D</span>
                                                        </div>
                                                    </div>
                                                    <div class="cityplace-text">
                                                        <span>Ranthambore Tiger Reserve, Rajasthan</span>
                                                    </div>
                                                </div>
                                                <div class="card-text">
                                                    <!-- Highlights partition -->
                                                    <div
                                                        class="highlights  highlights-list d-flex flex-wrap gap-1 align-items-center">
                                                        <div class="mb-2">
                                                            <div class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/permit.svg')}}" alt="Safari Permit">
                                                                <p class="mb-0">Safari Permits</p>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/accommodation.svg')}}"
                                                                    alt="Accommodation">
                                                                <p class="mb-0">Accommodation</p>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/meals.svg')}}" alt="Meals">
                                                                <p class="mb-0">Meals</p>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/guide.svg')}}" alt="Guide">
                                                                <p class="mb-0">Guide</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Known for partition -->
                                                    <div class="knowfor-list mb-2">
                                                        <h6 class="mb-0">Known For:</h6>
                                                        <div
                                                            class="highlights d-flex align-items-center flex-wrap column-gap-2">
                                                            <div class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/dot.svg')}}" alt="dot">
                                                                <p class="mb-0">Tiger sightings</p>
                                                            </div>
                                                            <div class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/dot.svg')}}" alt="dot">
                                                                <p class="mb-0">Sloth Bears</p>
                                                            </div>

                                                            <div class="card-list-text d-flex align-items-center gap-1">
                                                                <img src="{{ asset('front-assets/images/icons/dot.svg')}}" alt="dot">
                                                                <p class="mb-0">Birds Watching</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex align-items-center justify-content-between card-body-inner py-2 price-container flex-wrap">
                                                <div class="starting-price">
                                                    <p class="mb-0">Starting Price:</p>
                                                    <span class="mb-0 text-muted">₹ 22,750</span>
                                                </div>
                                                <a href="{{ route('shared-safari-detail',$similarPackage->slug) }}"
                                                    class="btn btn-sm btn-primary blue-btn-hover border-0 rounded-1">Enquire
                                                    Now</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
</div>
