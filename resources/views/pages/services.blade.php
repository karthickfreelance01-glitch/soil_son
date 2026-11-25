@extends('layouts.app')

@section('bodyclass','no-sidebar site-layout-full-width is-page footer-no-widget elementor-default elementor-kit-7 vv-page-services')

@section('head')
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
@include('partials.seo', ['seoKey' => 'services', 'seoDefaults' => [
    'title' => 'Our Services | De-Addiction, Rehabilitation & Counselling in Madurai',
    'description' => 'Explore de-addiction, residential rehabilitation and individual counselling services at Soil Sons Welfare Foundation, Sellur, Madurai.',
    'path' => '/services',
], 'seoBreadcrumbs' => [['Home', '/'], ['Services', '/services']]])
@include('partials.theme-head')
@endsection

@section('content')
<div id="main-content" class="site-main clearfix vv-main">
    @include('partials.page-hero', [
        'heroTitle' => 'Our Services',
        'heroText'  => 'Compassionate, evidence-based care for every step of recovery — from detox to a confident new beginning.',
        'heroImage' => 'assets/uploads/sswf/campus-garden-view.jpg',
        'crumbs'    => [['Home', '/'], ['Services', '/services']],
    ])

    <section class="vv-section">
        <div class="vv-container">
            <div class="vv-heading" data-vv-reveal>
                <span class="vv-eyebrow">What we offer</span>
                <h2>Care that treats the whole person</h2>
                <p>Every programme at SSWF is personalised by our counsellors and medical team, in a calm residential campus at Sellur, Madurai.</p>
            </div>

            <div class="vv-services-grid">
                @foreach($services as $s)
                    <article class="vv-service-card" data-vv-reveal style="--d:{{ $loop->index * 90 }}ms">
                        <a href="{{ $s->url() }}" class="vv-service-card__media" aria-label="{{ $s->title }}">
                            @if($s->image)<img src="{{ $s->imageUrl() }}" alt="{{ $s->title }} at Soil Sons Welfare Foundation, Madurai" loading="lazy">@endif
                            <span class="vv-service-card__icon"><i class="fa-solid {{ $s->icon ?: 'fa-hand-holding-heart' }}"></i></span>
                        </a>
                        <div class="vv-service-card__body">
                            <h3><a href="{{ $s->url() }}">{{ $s->title }}</a></h3>
                            <p>{{ $s->short_description }}</p>
                            <div class="vv-service-card__actions">
                                <a href="{{ $s->url() }}" class="vv-link">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                                <button type="button" class="vv-btn vv-btn--sm vv-btn--ghost" data-vv-enquire="{{ $s->title }}">Enquire</button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="vv-section vv-section--tint">
        <div class="vv-container">
            <div class="vv-features">
                @foreach([
                    ['fa-user-doctor', 'Expert team', 'Psychiatrists, counsellors and nursing staff who understand addiction.'],
                    ['fa-house-medical', 'Safe residential care', 'A peaceful, supervised campus with 24×7 support.'],
                    ['fa-spa', 'Holistic healing', 'Yoga, awareness classes, routine and nutrition alongside therapy.'],
                    ['fa-people-roof', 'Family involvement', 'Family counselling and aftercare to protect long-term recovery.'],
                ] as [$ic, $t, $d])
                    <div class="vv-feature" data-vv-reveal style="--d:{{ $loop->index * 90 }}ms">
                        <span class="vv-feature__icon"><i class="fa-solid {{ $ic }}"></i></span>
                        <h4>{{ $t }}</h4>
                        <p>{{ $d }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.cta-band')
</div>
@endsection

@section('scripts')
@include('partials.theme-scripts')
@endsection
