{{-- SEO tags. Usage: @include('partials.seo', ['seoKey' => 'home', 'seoDefaults' => [...]])
     Values from Admin > SEO override the defaults passed in by the page. --}}
@php
    $seo = \App\Support\Seo::for($seoKey ?? ($active ?? 'home'), $seoDefaults ?? []);
    $siteName = config('site.name');
@endphp
<title>{{ $seo['title'] }}</title>
<meta name="description" content="{{ $seo['description'] }}"/>
@if($seo['keywords'])<meta name="keywords" content="{{ $seo['keywords'] }}"/>@endif

<meta name="robots" content="{{ $seo['noindex'] ? 'noindex, nofollow' : 'index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large' }}"/>
<link rel="canonical" href="{{ $seo['canonical'] }}" />
<meta property="og:locale" content="en_IN" />
<meta property="og:type" content="{{ $seo['type'] }}" />
<meta property="og:title" content="{{ $seo['title'] }}" />
<meta property="og:description" content="{{ $seo['description'] }}" />
<meta property="og:url" content="{{ $seo['canonical'] }}" />
<meta property="og:site_name" content="{{ $siteName }}" />
@if($seo['image'])<meta property="og:image" content="{{ $seo['image'] }}" />@endif

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $seo['title'] }}" />
<meta name="twitter:description" content="{{ $seo['description'] }}" />
@if($seo['image'])<meta name="twitter:image" content="{{ $seo['image'] }}" />@endif

<meta name="theme-color" content="#1a28aa" />
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => ['MedicalOrganization', 'LocalBusiness'],
            '@id' => rtrim(config('site.url'), '/').'/#organization',
            'name' => $siteName,
            'url' => rtrim(config('site.url'), '/').'/',
            'logo' => \App\Support\Seo::absolute('assets/uploads/sswf/favicon-256.png'),
            'image' => $seo['image'],
            'telephone' => config('site.phone'),
            'email' => config('site.email'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'No. 68/0, Ahimsapuram, Mela Street, Puthiyavisalam, Sellur',
                'addressLocality' => 'Madurai',
                'addressRegion' => 'Tamil Nadu',
                'postalCode' => '625002',
                'addressCountry' => 'IN',
            ],
            'medicalSpecialty' => 'Psychiatric',
        ],
        [
            '@type' => 'WebPage',
            '@id' => $seo['canonical'].'#webpage',
            'url' => $seo['canonical'],
            'name' => $seo['title'],
            'description' => $seo['description'],
            'isPartOf' => ['@id' => rtrim(config('site.url'), '/').'/#website'],
            'inLanguage' => 'en-IN',
        ],
        [
            '@type' => 'WebSite',
            '@id' => rtrim(config('site.url'), '/').'/#website',
            'url' => rtrim(config('site.url'), '/').'/',
            'name' => $siteName,
            'publisher' => ['@id' => rtrim(config('site.url'), '/').'/#organization'],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@isset($seoBreadcrumbs)
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => collect($seoBreadcrumbs)->values()->map(fn ($b, $i) => [
        '@type' => 'ListItem', 'position' => $i + 1, 'name' => $b[0], 'item' => \App\Support\Seo::absolute($b[1]),
    ])->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endisset
