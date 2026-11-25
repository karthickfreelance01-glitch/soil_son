{{--
    Premium service page (De-Addiction, Rehabilitation, Individual Counselling).
    Vars:
      $slug, $title, $tagline, $icon, $image, $heroImage
      $intro      : array of paragraphs (plain text)
      $highlights : array of short bullet strings
      $includes   : [[icon, title, text], ...]
      $steps      : [[title, text], ...]   (4 recommended)
--}}
@php
    $others = \App\Support\SiteData::services()->filter(fn ($s) => $s->slug !== $slug)->take(3);
    $tel    = preg_replace('/\s+/', '', config('site.phone'));
@endphp

<div id="main-content" class="site-main clearfix vv-main ss-page">
    @include('partials.page-hero', [
        'heroTitle' => $title,
        'heroText'  => $tagline,
        'heroImage' => $heroImage,
        'crumbs'    => [['Home', '/'], ['Services', '/services'], [$title, '/'.$slug]],
    ])

    {{-- ================= Intro ================= --}}
    <section class="vv-section ss-intro">
        <div class="vv-container ss-intro__grid">
            <div class="ss-intro__media" data-vv-reveal="left">
                <span class="ss-intro__frame" aria-hidden="true"></span>
                <figure class="ss-intro__img"><img src="{{ asset($image) }}" alt="{{ $title }} at Soil Sons Welfare Foundation, Madurai" loading="lazy"></figure>
                <div class="ss-intro__badge">
                    <span class="ss-intro__badge-ic"><i class="fa-solid {{ $icon }}"></i></span>
                    <span><strong>24×7</strong><small>Care &amp; support</small></span>
                </div>
            </div>

            <div class="ss-intro__copy">
                <span class="vv-eyebrow" data-vv-reveal>{{ $title }}</span>
                <h2 class="ss-h2" data-vv-reveal style="--d:80ms">{!! $heading !!}</h2>
                @foreach($intro as $p)
                    <p class="{{ $loop->first ? 'ss-lead' : '' }}" data-vv-reveal style="--d:{{ 140 + $loop->index * 60 }}ms">{{ $p }}</p>
                @endforeach

                <ul class="ss-checks" data-vv-reveal style="--d:260ms">
                    @foreach($highlights as $h)
                        <li><i class="fa-solid fa-circle-check"></i> {{ $h }}</li>
                    @endforeach
                </ul>

                <div class="ss-actions" data-vv-reveal style="--d:320ms">
                    <button type="button" class="vv-btn ss-btn-gold" data-vv-enquire="{{ $title }}">Book a confidential visit <i class="fa-solid fa-arrow-right"></i></button>
                    <a class="ss-call" href="tel:{{ $tel }}">
                        <span class="ss-call__ic"><i class="fa-solid fa-phone-volume"></i></span>
                        <span><small>Talk to a counsellor</small>{{ config('site.phone') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= What's included ================= --}}
    <section class="vv-section ss-includes">
        <div class="vv-container">
            <div class="vv-heading" data-vv-reveal>
                <span class="vv-eyebrow">What the programme includes</span>
                <h2>Care for body, mind &amp; family</h2>
                <p>Every plan is personalised after a careful assessment, and reviewed as recovery progresses.</p>
            </div>
            <div class="ss-cards">
                @foreach($includes as [$ic, $t, $d])
                    <article class="ss-card" data-vv-reveal="zoom" style="--d:{{ $loop->index * 90 }}ms">
                        <span class="ss-card__no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="ss-card__ic"><i class="fa-solid {{ $ic }}"></i></span>
                        <h3>{{ $t }}</h3>
                        <p>{{ $d }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================= Journey ================= --}}
    <section class="vv-section ss-journey">
        <div class="vv-container">
            <div class="vv-heading" data-vv-reveal>
                <span class="vv-eyebrow">Your journey with us</span>
                <h2>Four steps to a new beginning</h2>
            </div>
            <ol class="ss-steps">
                @foreach($steps as [$t, $d])
                    <li class="ss-step" data-vv-reveal style="--d:{{ $loop->index * 140 }}ms">
                        <span class="ss-step__dot">{{ $loop->iteration }}</span>
                        <h4>{{ $t }}</h4>
                        <p>{{ $d }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ================= Promise band ================= --}}
    <section class="ss-promise">
        <div class="vv-container ss-promise__grid">
            @foreach([
                ['fa-user-shield', '100% confidential', 'Your identity and story stay private.'],
                ['fa-user-doctor', 'Doctor-led care', 'Medical supervision at every stage.'],
                ['fa-people-roof', 'Family support', 'We walk with your family too.'],
                ['fa-clock', '24×7 helpline', 'Someone is always here to listen.'],
            ] as [$ic, $t, $d])
                <div class="ss-promise__item" data-vv-reveal style="--d:{{ $loop->index * 100 }}ms">
                    <i class="fa-solid {{ $ic }}"></i>
                    <div><strong>{{ $t }}</strong><span>{{ $d }}</span></div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ================= Other services ================= --}}
    @if($others->isNotEmpty())
    <section class="vv-section">
        <div class="vv-container">
            <div class="vv-heading" data-vv-reveal>
                <span class="vv-eyebrow">Explore more</span>
                <h2>Other ways we can help</h2>
            </div>
            <div class="vv-services-grid">
                @foreach($others as $s)
                    <article class="vv-service-card" data-vv-reveal style="--d:{{ $loop->index * 90 }}ms">
                        <a href="{{ $s->url() }}" class="vv-service-card__media" aria-label="{{ $s->title }}">
                            @if($s->image)<img src="{{ $s->imageUrl() }}" alt="{{ $s->title }}" loading="lazy">@endif
                            <span class="vv-service-card__icon"><i class="fa-solid {{ $s->icon ?: 'fa-hand-holding-heart' }}"></i></span>
                        </a>
                        <div class="vv-service-card__body">
                            <h3><a href="{{ $s->url() }}">{{ $s->title }}</a></h3>
                            <p>{{ $s->short_description }}</p>
                            <div class="vv-service-card__actions">
                                <a href="{{ $s->url() }}" class="vv-link">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @include('partials.cta-band')
</div>
