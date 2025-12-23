@php
// if (isset($seoContents) && count($seoContents)) {
// $seoContents = json_decode(json_encode($seoContents, true));
// $socialImageSize = explode('x', $seoContents->image_size);
// } elseif ($seo) {
// $seoContents = $seo;
// $socialImageSize = explode('x', getFileSize('seo'));
// $seoContents->image = getImage(getFilePath('seo') . '/' . $seo->image);
// } else {
// $seoContents = null;
// }
@endphp


@if (isset($seoContents))
<link rel="icon" href="{{ asset($seoContents?->meta_image ?? 'front-assets/images/safari-logo.png') }}"
    type="image/png">
<link rel="canonical" href="{{ url()->current() }}" />
<link rel="alternate" href="{{ url()->current() }}" hreflang="en-in" />
<meta name="googlebot" content="index,follow">
<title>{{ $seoContents?->meta_title }}</title>
<meta name="description" content="{{ $seoContents?->meta_description }}">

<!-- Google / Search Engine Tags -->
<meta itemprop="name" content="{{ $seoContents?->meta_title }}">
<meta itemprop="description" content="{{ $seoContents?->meta_description }}">
<meta itemprop="image" content="{{ asset($seoContents?->meta_image ?? 'front-assets/images/safari-logo.png') }}">

<!-- Facebook Meta Tags -->
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $seoContents?->meta_title }}">
<meta property="og:description" content="{{ $seoContents?->meta_description }}">
<meta property="og:image" content="{{ asset($seoContents?->meta_image ?? 'front-assets/images/safari-logo.png') }}">

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoContents?->meta_title }}">
<meta name="twitter:description" content="{{ $seoContents?->meta_description }}">
<meta name="twitter:image" content="{{ asset($seoContents?->meta_image ?? 'front-assets/images/safari-logo.png') }}">
@endif
