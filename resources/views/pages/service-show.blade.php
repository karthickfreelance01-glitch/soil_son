@extends('layouts.app')

@section('bodyclass','no-sidebar site-layout-full-width is-page footer-no-widget elementor-default elementor-kit-7 vv-page-service')

@section('head')
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
@include('partials.seo', ['seoKey' => 'service-'.$service->slug, 'seoDefaults' => [
    'title' => $service->meta_title ?: $service->title.' in Madurai | Soil Sons Welfare Foundation',
    'description' => $service->meta_description ?: $service->short_description,
    'keywords' => $service->meta_keywords,
    'image' => $service->image,
    'path' => '/services/'.$service->slug,
    'type' => 'article',
], 'seoBreadcrumbs' => [['Home', '/'], ['Services', '/services'], [$service->title, '/services/'.$service->slug]]])
@include('partials.theme-head')
@endsection

@section('content')
<div id="main-content" class="site-main clearfix vv-main">
    @include('partials.page-hero', [
        'heroTitle' => $service->title,
        'heroText'  => $service->short_description,
        'heroImage' => $service->image ?: 'assets/uploads/sswf/section-bg.jpg',
        'crumbs'    => [['Home', '/'], ['Services', '/services'], [$service->title, '/services/'.$service->slug]],
    ])

    <section class="vv-section">
        <div class="vv-container vv-split">
            <article class="vv-prose" data-vv-reveal>
                @if($service->image)<img src="{{ $service->imageUrl() }}" alt="{{ $service->title }} - Soil Sons Welfare Foundation" class="vv-prose__img">@endif
                {!! $service->content ?: '<p>'.e($service->short_description).'</p>' !!}
            </article>
            <aside class="vv-aside">
                <div class="vv-aside__card" data-vv-reveal>
                    <h4>Our services</h4>
                    <ul class="vv-aside__list">
                        @foreach($services as $s)
                            <li class="{{ $s->slug === $service->slug ? 'is-active' : '' }}"><a href="{{ $s->url() }}"><i class="fa-solid {{ $s->icon ?: 'fa-hand-holding-heart' }}"></i> {{ $s->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="vv-aside__card vv-aside__card--grad" data-vv-reveal>
                    <h4>Need help today?</h4>
                    <p>Talk to our counsellor in confidence.</p>
                    <a class="vv-btn vv-btn--light" href="tel:{{ preg_replace('/\s+/', '', config('site.phone')) }}"><i class="fa-solid fa-phone"></i> {{ config('site.phone') }}</a>
                    <button type="button" class="vv-btn vv-btn--outline-light" data-vv-enquire="{{ $service->title }}">Send an enquiry</button>
                </div>
            </aside>
        </div>
    </section>

    @include('partials.cta-band')
</div>
@endsection

@section('scripts')
@include('partials.theme-scripts')
@endsection
