<div>
    {{-- @php
        if (!function_exists('getContrastYIQ')) {
            function getContrastYIQ($hexcolor)
            {
                $r = hexdec(substr($hexcolor, 1, 2));
                $g = hexdec(substr($hexcolor, 3, 2));
                $b = hexdec(substr($hexcolor, 5, 2));
                $yiq = ($r * 299 + $g * 587 + $b * 114) / 1000;
                return $yiq >= 128 ? 'black' : 'white';
            }
        }

        $customColors = [
            '#FF5733',
            '#33FF57',
            '#3357FF',
            '#FF33A1',
            '#A133FF',
            '#33FFF6',
            '#FFC133',
            '#8DFF33',
            '#FF8C33',
            '#33FFD1',
            '#FF336E',
            '#7533FF',
            '#33FF92',
            '#FFA533',
            '#33A1FF',
            '#FF33F6',
            '#6EFF33',
            '#33FFBD',
            '#FFBD33',
            '#33E3FF',
            '#E333FF',
            '#FF3333',
            '#FF6666',
            '#66CCFF',
            '#99FF99',
            '#FFB6C1',
            '#FFD700',
            '#87CEFA',
            '#FFDEAD',
            '#40E0D0',
        ];
    @endphp --}}
    @php
        if (!function_exists('getContrastYIQ')) {
            function getContrastYIQ($hexcolor)
            {
                $r = hexdec(substr($hexcolor, 1, 2));
                $g = hexdec(substr($hexcolor, 3, 2));
                $b = hexdec(substr($hexcolor, 5, 2));
                $yiq = ($r * 299 + $g * 587 + $b * 114) / 1000;
                return $yiq >= 128 ? 'black' : 'white';
            }
        }

        $customColors = [
            // Vibrant tones
            '#F94144', // Red
            '#F3722C', // Orange
            '#F9C74F', // Yellow
            '#90BE6D', // Green
            '#43AA8B', // Teal green
            '#577590', // Slate blue
            '#4D908E', // Muted teal

            // Pastel & Soft
            '#A2D2FF', // Light blue
            '#BDE0FE', // Very light blue
            '#FFC8DD', // Pink
            '#FFAFCC', // Soft pink
            '#CDB4DB', // Lavender
            '#E0BBE4', // Light purple
            '#D8E2DC', // Off white/gray

            // Rich & Dark tones
            '#6A0572', // Deep purple
            '#0A9396', // Rich teal
            '#005F73', // Dark teal
            '#BB3E03', // Deep rust
            '#3D405B', // Gray blue
            '#2A9D8F', // Sea green

            // 🌾 Earthy Tones
            '#A47551', // Safari brown
            '#C49E72', // Dusty tan
            '#D2B48C', // Tan
            '#BFAE9E', // Mud clay
            '#E6C9A8', // Soft sand
            '#9C7B56', // Camel
            '#7B5E57', // Dark earth
            '#A0522D', // Sienna
            '#8B5E3C', // Dirt

            // 🌅 Sunset Shades
            '#FFB347', // Sunset orange
            '#FF7F50', // Coral
            '#FFD580', // Soft gold
            '#FF9F1C', // Deep sunset
            '#FFA07A', // Light salmon
            '#FF8C42', // Wild amber
            '#F4A261', // Terracotta
            '#E76F51', // Desert sunset
            '#FCB900', // Golden sun

            // 🌿 Greens of Nature
            '#6B8E23', // Olive green
            '#556B2F', // Dark olive
            '#A8B400', // Safari grass
            '#BCCF02', // Lime grass
            '#9DC183', // Sage green
            '#B5E48C', // Light forest
            '#A7C957', // Leafy
            '#90A955', // Jungle
            '#52796F', // Mossy

            // ☁️ Sky & Water
            '#87CEEB', // Sky blue
            '#B0E0E6', // Pale sky
            '#5DADE2', // Cloudy sky
            '#E0F7FA', // Soft water
            '#48CAE4', // Bright lake
            '#ADE8F4', // Mist
            '#CAF0F8', // Cloud

            // 🐾 Neutrals & Naturals
            '#F5F5DC', // Beige
            '#FDF6EC', // Ivory
            '#EFE9DD', // Light soil
            '#FAF3E0', // Pale dune
            '#ECECEC', // Mist gray
            '#DADADA', // Soft ash
            '#CFCFC4', // Pale stone
            '#B4B4B4', // Grey rock
            '#8D8D8D', // Boulder

            // 🌑 Accents / Dark shades
            '#3B3B3B', // Rock
            '#2F2F2F', // Night
            '#1B1B1B', // Charcoal
            '#1C1C1C', // Obsidian
            '#5C4033', // Burnt wood
        ];

    @endphp


    <style>
        table {
            width: 100%;
        }
    </style>
    @if (count($BestTimeToVisit) > 0 || !empty($travelTips->weather) || count($whatToCarry) > 0 || !empty($travelTips))
        <div>
            @if (count($BestTimeToVisit) > 0)
                {{-- <div class="mb-4">
                    <div class="heading-text text-center mb-xl-4 mb-3">
                        <div class="">
                            <h2 class="mb-0 text-accent"> Best Time to Visit {{ $parkdetails->name }}
                            </h2>
                            <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                                class="vector-border-bottom">
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $bootstrapColors = ['primary', 'success', 'danger', 'warning', 'info', 'secondary', 'dark'];
                            $total = count($BestTimeToVisit);
                        @endphp

                        @foreach ($BestTimeToVisit as $i => $bestTime)
                            @php
                                $randomColor = $bootstrapColors[array_rand($bootstrapColors)];
                                $colClass =
                                    $i === $total - 1 && $total % 2 !== 0 ? 'col-12' : 'col-xl-6 col-lg-12 col-md-6';
                            @endphp

                            <div class="{{ $colClass }} mb-3">
                                <div
                                    class="season-card rounded-3 border-{{ $randomColor }} border-start bg-white border-5 p-3 h-100">
                                    <h6 class="season-header text-{{ $randomColor }}">
                                        {{ $bestTime->heading }}
                                    </h6>
                                    {!! $bestTime->description !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> --}}
                <div class="mb-4">
                    <div class="heading-text text-center mb-xl-4 mb-3">
                        <div class="">
                            <h2 class="mb-0 text-accent"> Best Time to Visit {{ $parkdetails->name }}</h2>
                            <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                                class="vector-border-bottom">
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $total = count($BestTimeToVisit);
                        @endphp
                        @foreach ($BestTimeToVisit as $i => $bestTime)
                            @php
                                $randomColor = $customColors[array_rand($customColors)];
                                $textColor = getContrastYIQ($randomColor);
                                $colClass =
                                    $i === $total - 1 && $total % 2 !== 0 ? 'col-12' : 'col-xl-6 col-lg-12 col-md-6';
                            @endphp

                            <div class="{{ $colClass }} mb-3">
                                <div class="season-card rounded-3 border-0 p-3 h-100"
                                    style="background-color: {{ $randomColor }}; color: {{ $textColor }};">
                                    <h6 class="season-header fw-semibold mb-2" style="color: {{ $textColor }}">
                                        {{ $bestTime->heading }}
                                    </h6>
                                    <div style="color: {{ $textColor }}">
                                        {!! $bestTime->description !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if (!empty($travelTips->weather))
                <div class="mb-4">
                    <div class="heading-text text-center mb-xl-4 mb-3">
                        <div class="">
                            <h2 class="mb-0 text-accent"> Weather in {{ $parkdetails->name }}
                            </h2>
                            <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                                class="vector-border-bottom">
                        </div>
                    </div>
                    <div class="">
                        {!! $travelTips->weather !!}
                    </div>
                </div>
            @endif
            @if (count($whatToCarry) > 0)
                <div class="mb-4">
                    <div class="heading-text text-center mb-xl-4 mb-3">
                        <div class="">
                            <h2 class="mb-0 text-accent">{{ $parkdetails->name }} – What to Carry</h2>
                            <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                                class="vector-border-bottom">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-sm-flex mb-5 row gx-3 gy-4">
                            @foreach ($whatToCarry as $carry)
                                @php
                                    $randomColor = $customColors[array_rand($customColors)];
                                    $textColor = getContrastYIQ($randomColor);
                                @endphp

                                <div class="col-sm-6 col-md-4 col-xl-3 d-flex align-items-stretch">
                                    <div class="card carry-item-card text-center border-0 shadow-sm rounded-4 w-100 h-100"
                                        style="background-color: {{ $randomColor }}; color: {{ $textColor }};">
                                        <div class="card-body essential-note">
                                            <img src="{{ asset($carry->image) }}" alt="{{ $carry->heading }}"
                                                width="70" height="70" class="rounded-circle shadow mb-3"
                                                style="border: 2px solid {{ $textColor }};">

                                            <h6 class="fw-semibold mb-1" style="color: {{ $textColor }}">
                                                {{ $carry->heading }}</h6>
                                            <p class="small mb-0" style="color: {{ $textColor }}">
                                                {{ $carry->short_description }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            @endif
            @if (!empty($travelTips))
                <div class="mb-4">
                    <div class="heading-text text-center mb-xl-4 mb-3">
                        <div class="">
                            <h2 class="mb-0 text-accent"> Safety Tips</h2>
                            <img src="{{ asset('front-assets/images/blue-border-vector.png') }}" alt="Vector-Border"
                                class="vector-border-bottom">
                        </div>
                    </div>
                    <div class="">
                        {!! $travelTips->safetyTips !!}
                    </div>
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
