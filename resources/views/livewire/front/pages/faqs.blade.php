<div>
    <main>
        <!-- Hero Section -->
        <section id="home-hero"
            class="search-hero listing-page-hero d-flex align-items-center justify-content-center text-center text-white mb-4">
            <div class="container-fluid container-padding">
                <div class="bannertext text-center">
                    <h1 class="text-white">FAQ'S</h1>
                </div>
            </div>
        </section>

        <div class="container-lg container-inner-padding">
            <div class="secion-faq mb-4 package-accordion" id="section-faq">
                <div class="accordion all-accordion p-3 rounded-3 dark-grey-bg row" id="faqAccordion">
                     @foreach ($faqs as $index => $faq)
                            @php
                                $count = count($faqs);
                                if ($count % 2 == 1 && $index == $count - 1) {
                                    // Agar odd count hai aur last item hai, toh col-12 use karo
                                    $colClass = 'col-sm-12';
                                } else {
                                    // Baaki cases mein col-6 use karo
                                    $colClass = 'col-sm-6';
                                }
                            @endphp

                            <div class="accordion-item mb-3 rounded-top-3 border-0 {{ $colClass }}">
                                <h2 class="accordion-header rounded-top-3" id="faqHeading{{ $index }}">
                                    <button class="accordion-button rounded-top-3 rounded-bottom-0 collapsed"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqCollapse{{ $index }}">
                                        {{ $index + 1 }}: {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="faqCollapse{{ $index }}" class="accordion-collapse collapse"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body pt-0">
                                        <ul class="list-unstyled mb-0 package-lists">
                                            <li><i class="fa-regular fa-circle-check"></i> {{ $faq->answer }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
@push('scripts')
    <script type="application/ld+json">
    {!! json_encode([
        "@context" => "https://schema.org",
        "@type" => "FAQPage",
        "mainEntity" => $faqs->map(function($faq){
            return [
                "@type" => "Question",
                "name" => $faq->question,
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => $faq->answer,
                ],
            ];
        })->toArray(),
    ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@endpush
