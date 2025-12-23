export function initCarousels() {
    // Add small delay to ensure jQuery and Slick are fully available
    setTimeout(() => {
        safeRun(initTopSafariParks);
        safeRun(initTopRatedParks);
        safeRun(initDealsDiscounts);
        safeRun(initThingsToCarry);
        safeRun(initGuestReviews);
        safeRun(initSimilarPackages);
        safeRun(initPackageDetailSlider);
        safeRun(initFallbackOwl);
    }, 100);
}

function safeRun(fn) {
    try {
        fn();
    } catch (e) {
        console.error("Carousel Error in:", fn.name, e);
    }
}

/* -------------------------------------
   1) Top Safari Parks Home Page
--------------------------------------*/
function initTopSafariParks() {
    const slider = $("#top-safari-park-owl");
    if (!slider.length) return;

    if (slider.find(".item").length <= 3) {
        slider.addClass("no-carousel");
        return;
    }
    if (slider.hasClass("slick-initialized")) return;

    slider.slick({
        infinite: true,
        autoplay: true,
        nav: true,
        autoplaySpeed: 4000,
        speed: 600,
        dots: true,
        arrows: true,
        prevArrow: '<button class="slick-prev">Previous</button>',
        nextArrow: '<button class="slick-next">Next</button>',
        slidesToShow: 3,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 3 } },
            { breakpoint: 992, settings: { slidesToShow: 2 } },
            { breakpoint: 576, settings: { slidesToShow: 1 } },
        ],
    });
}

/* -------------------------------------
   2) Top Rated Parks (Livewire Component)
--------------------------------------*/
function initTopRatedParks() {
    const slider = $("#top-rated-park-owl");
    if (!slider.length) return;

    if (slider.hasClass("slick-initialized")) return;

    if (slider.find(".item").length <= 2) {
        slider.addClass("no-carousel");
        return;
    }

    slider.slick({
        infinite: true,
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 600,
        dots: true,
        arrows: true,
        prevArrow: '<button class="slick-prev">Previous</button>',
        nextArrow: '<button class="slick-next">Next</button>',
        slidesToShow: 3,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 3 } },
            { breakpoint: 992, settings: { slidesToShow: 2 } },
            { breakpoint: 576, settings: { slidesToShow: 1 } },
        ],
    });
}

window.initTopRatedCarousel = initTopRatedParks;

/* -------------------------------------
   3) Deals & Discounts
--------------------------------------*/
function initDealsDiscounts() {
    const slider = $("#dealsdiscount-carousel");
    if (!slider.length) return;

    if (slider.hasClass("slick-initialized")) return;
    slider.not(".slick-initialized").slick({
        infinite: false,
        autoplay: true,
        speed: 600,
        dots: true,
        arrows: false,
        slidesToShow: 3,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 3 } },
            { breakpoint: 768, settings: { slidesToShow: 2 } },
            { breakpoint: 650, settings: { slidesToShow: 1.5 } },
            { breakpoint: 0, settings: { slidesToShow: 1 } },
        ],
    });
}

/* -------------------------------------
   4) Things to Carry
--------------------------------------*/
function initThingsToCarry() {
    const slider = $("#thing-to-carry");
    if (!slider.length) return;
    if (slider.hasClass("slick-initialized")) return;

    slider.not(".slick-initialized").slick({
        infinite: true,
        autoplay: true,
        autoplaySpeed: 1000,
        speed: 800,
        dots: true,
        arrows: false,
        slidesToShow: 1,
        responsive: [
            { breakpoint: 500, settings: { slidesToShow: 2 } },
            { breakpoint: 0, settings: { slidesToShow: 1 } },
        ],
    });
}

/* -------------------------------------
   5) Guest Reviews
--------------------------------------*/
function initGuestReviews() {
    const slider = $("#guest-reviews-carousel");
    if (!slider.length) return;

    if (slider.hasClass("slick-initialized")) return;
    slider.not(".slick-initialized").slick({
        infinite: true,
        autoplay: true,
        speed: 600,
        dots: false,
        arrows: true,
        prevArrow: `<button class="slick-prev"><img src="/front-assets/images/icons/prev-arrow-fill.svg" /></button>`,
        nextArrow: `<button class="slick-next"><img src="/front-assets/images/icons/next-arrow-fill.svg" /></button>`,
        slidesToShow: 3,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 3 } },
            { breakpoint: 768, settings: { slidesToShow: 2 } },
            { breakpoint: 576, settings: { slidesToShow: 1.5 } },
            { breakpoint: 0, settings: { slidesToShow: 1 } },
        ],
    });

    // move arrows
    const arrows = $(
        "#guest-reviews-carousel .slick-prev, #guest-reviews-carousel .slick-next"
    );
    $(".guest-reviews-section .viewall-link").append(arrows);
}

/* -------------------------------------
   6) Similar Packages
--------------------------------------*/
function initSimilarPackages() {
    const slider = $("#similar-packages-owl");

    if (!slider.length) {
        return;
    }

    if (slider.hasClass("slick-initialized")) {
        console.log("Similar Packages already initialized, skipping");
        return;
    }

    const itemCount = slider.find(".item").length;

    if (itemCount <= 3) {
        slider.slick({
            infinite: false,
            autoplay: false,
            speed: 600,
            dots: false,
            arrows: true,
            prevArrow: `
                <button class="slick-prev" aria-label="Previous">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M15 18L9 12L15 6" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            `,
            nextArrow: `
                <button class="slick-next" aria-label="Next">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M9 6L15 12L9 18" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            `,
            slidesToShow: 3,
            responsive: [
                { breakpoint: 992, settings: { slidesToShow: 3 } },
                { breakpoint: 900, settings: { slidesToShow: 2 } },
                { breakpoint: 576, settings: { slidesToShow: 2 } },
                { breakpoint: 0, settings: { slidesToShow: 1 } },
            ],
        });
    } else {
        slider.slick({
            infinite: false,
            autoplay: false,
            speed: 600,
            dots: true,
            arrows: true,
            prevArrow: `
                <button class="slick-prev" aria-label="Previous">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M15 18L9 12L15 6" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            `,
            nextArrow: `
                <button class="slick-next" aria-label="Next">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M9 6L15 12L9 18" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            `,
            slidesToShow: 3,
            dotsClass: 'slick-dots slick-dots-limited',
            responsive: [
                { breakpoint: 992, settings: { slidesToShow: 3 } },
                { breakpoint: 900, settings: { slidesToShow: 2 } },
                { breakpoint: 576, settings: { slidesToShow: 2 } },
                { breakpoint: 0, settings: { slidesToShow: 1 } },
            ],
        });
    }
}

/* -------------------------------------
   8) Package Detail Hero Slider
--------------------------------------*/
function initPackageDetailSlider() {
    const slider = $("#package-detail-slider");

    if (!slider || !slider.length) return;
    if (slider.hasClass("slick-initialized")) return;

    slider.slick({
        infinite: true,
        autoplay: false,
        autoplaySpeed: 4500,
        speed: 600,
        dots: true,
        arrows: false,
        slidesToShow: 1,
        adaptiveHeight: false,
    });
}

/* -------------------------------------
   7) Fallback — any .owl-carousel
--------------------------------------*/
function initFallbackOwl() {
    const slider = $(".owl-carousel");

    if (!slider.length) return;

    slider.each(function () {
        const $this = $(this);
        if ($this.hasClass("slick-initialized")) return;

        $this.slick({
            infinite: true,
            autoplay: true,
            autoplaySpeed: 2500,
            speed: 600,
            dots: true,
            arrows: false,
            slidesToShow: 1,
        });
    });
}
