{{-- Modern page banner. Vars: $heroTitle, $heroText (optional), $heroImage (optional), $crumbs = [['Home','/'], ...] --}}
<section class="vv-hero" style="--vv-hero-img:url('{{ asset($heroImage ?? 'assets/uploads/sswf/section-bg.jpg') }}')">
    <div class="vv-hero__shape vv-hero__shape--1"></div>
    <div class="vv-hero__shape vv-hero__shape--2"></div>
    <div class="vv-container vv-hero__inner">
        <nav class="vv-crumbs" aria-label="Breadcrumb" data-vv-reveal>
            @foreach($crumbs ?? [['Home', '/']] as [$label, $href])
                @if($loop->last)<span aria-current="page">{{ $label }}</span>@else<a href="{{ url($href) }}">{{ $label }}</a><i>/</i>@endif
            @endforeach
        </nav>
        <h1 class="vv-hero__title" data-vv-reveal>{{ $heroTitle }}</h1>
        @if(!empty($heroText))<p class="vv-hero__text" data-vv-reveal>{{ $heroText }}</p>@endif
    </div>
</section>
