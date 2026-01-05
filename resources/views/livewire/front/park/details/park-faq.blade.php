<div>
    @if (!empty($faqs))
        <div class="secion-faq mb-4 package-accordion" id="section">
            <h3 class="text-blue">FAQ's</h3>
            <div class="accordion p-3 rounded-3 dark-grey-bg" id="faqAccordion">
                @foreach ($faqs as $index => $faq)
                    @php
                        $question = $faq['question'] ?? '';
                        $answer = $faq['answer'] ?? '';
                        $collapseId = 'faq' . $index;
                        $headingId = 'heading' . $index;
                    @endphp

                    <div class="accordion-item mb-3 rounded-3">
                        <h2 class="accordion-header rounded-top-3" id="{{ $headingId }}">
                            <button
                                class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }} rounded-top-3 rounded-bottom-0"
                                type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-controls="{{ $collapseId }}">
                                {{ $question }}
                            </button>
                        </h2>
                        <div id="{{ $collapseId }}"
                            class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                            aria-labelledby="{{ $headingId }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body pt-0">
                                <ul class="list-unstyled mb-0 package-lists">
                                    <li class="p-0">
                                        {{ $answer }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    @endif
</div>
