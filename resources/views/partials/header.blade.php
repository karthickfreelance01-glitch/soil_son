{{-- SSWF header — classic · premium. (The previous Elementor header is kept in header-elementor-backup.blade.php) --}}
@php
    $act      = $active ?? '';
    $phone    = config('site.phone');
    $tel      = preg_replace('/\s+/', '', $phone);
    $wa       = preg_replace('/\D/', '', $phone);
    $svcList  = \App\Support\SiteData::services();
    $isSvc    = in_array($act, ['services', 'de-addiction', 'rehabilitation', 'individual-counselling']);
    $social   = array_filter(config('site.social', []));
    $socialIc = ['facebook' => 'fa-facebook-f', 'instagram' => 'fa-instagram', 'youtube' => 'fa-youtube'];
    $nav = [
        ['Home', '/', $act === 'home'],
        ['About', '/about', $act === 'about'],
        ['Services', '/services', $isSvc, true],
        ['Gallery', '/gallery', $act === 'gallery'],
        ['Contact', '/contact', $act === 'contact'],
    ];
@endphp
<div id="site-header-wrap" class="vvh-wrap">
<header class="vvh" id="vvHeader">
    {{-- Utility bar --}}
    <div class="vvh-top">
        <div class="vvh-container vvh-top__inner">
            <div class="vvh-top__left">
                <a href="tel:{{ $tel }}" class="vvh-top__item"><i class="fa-solid fa-phone-volume"></i><span><b>24×7 Helpline</b> {{ $phone }}</span></a>
                @if(config('site.email'))
                <a href="mailto:{{ config('site.email') }}" class="vvh-top__item vvh-hide-md"><i class="fa-regular fa-envelope"></i><span>{{ config('site.email') }}</span></a>
                @endif
                <span class="vvh-top__item vvh-hide-lg"><i class="fa-solid fa-location-dot"></i><span>Sellur, Madurai</span></span>
            </div>
            <div class="vvh-top__right">
                <span class="vvh-top__badge"><i class="fa-solid fa-shield-heart"></i> 100% Confidential Care</span>
                @foreach($social as $k => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener" class="vvh-top__social" aria-label="{{ ucfirst($k) }}"><i class="fa-brands {{ $socialIc[$k] ?? 'fa-link' }}"></i></a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Main bar --}}
    <div class="vvh-main">
        <div class="vvh-container vvh-main__inner">
            <a href="/" class="vvh-logo" aria-label="Soil Sons Welfare Foundation — Home">
                <img src="{{ $A }}assets/uploads/sswf/sswf-logo-570.png" alt="Soil Sons Welfare Foundation" width="570" height="182">
            </a>

            <nav class="vvh-nav" aria-label="Main">
                <ul>
                    @foreach($nav as $item)
                        @php [$label, $href, $on] = $item; $drop = $item[3] ?? false; @endphp
                        <li class="{{ $drop ? 'vvh-has-drop' : '' }} {{ $on ? 'is-active' : '' }}">
                            <a href="{{ $href }}" @if($on) aria-current="page" @endif>{{ $label }}@if($drop) <i class="fa-solid fa-chevron-down"></i>@endif</a>
                            @if($drop)
                                <div class="vvh-drop">
                                    <div class="vvh-drop__inner">
                                        <div class="vvh-drop__list">
                                            @foreach($svcList as $s)
                                                <a href="{{ $s->url() }}" class="vvh-drop__item {{ ($act === $s->slug || request()->is('services/'.$s->slug)) ? 'is-active' : '' }}">
                                                    <span class="vvh-drop__ic"><i class="fa-solid {{ $s->icon ?: 'fa-hand-holding-heart' }}"></i></span>
                                                    <span><b>{{ $s->title }}</b><small>{{ \Illuminate\Support\Str::limit($s->short_description, 70) }}</small></span>
                                                </a>
                                            @endforeach
                                        </div>
                                        <div class="vvh-drop__card">
                                            <p>Not sure which programme is right?</p>
                                            <a href="tel:{{ $tel }}"><i class="fa-solid fa-phone"></i> {{ $phone }}</a>
                                            <a href="/services" class="vvh-drop__all">All services <i class="fa-solid fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="vvh-actions">
                <a href="tel:{{ $tel }}" class="vvh-call" aria-label="Call {{ $phone }}">
                    <span class="vvh-call__ic"><i class="fa-solid fa-phone"></i></span>
                    <span class="vvh-call__txt"><small>Talk to us</small>{{ $phone }}</span>
                </a>
                <a href="/contact" class="vvh-cta" data-vv-enquire>
                    <span>Make An Appointment</span><i class="fa-solid fa-arrow-right"></i>
                </a>
                <button type="button" class="vvh-burger" aria-label="Open menu" aria-controls="vvhDrawer" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </div>
</header>

{{-- Mobile drawer --}}
<div class="vvh-drawer" id="vvhDrawer" aria-hidden="true">
    <div class="vvh-drawer__head">
        <img src="{{ $A }}assets/uploads/sswf/sswf-logo-white.png" alt="SSWF" height="44">
        <button type="button" class="vvh-drawer__close" aria-label="Close menu">&times;</button>
    </div>
    <nav class="vvh-drawer__nav" aria-label="Mobile">
        @foreach($nav as $i => $item)
            @php [$label, $href, $on] = $item; $drop = $item[3] ?? false; @endphp
            <div class="vvh-drawer__row {{ $on ? 'is-active' : '' }}" style="--i:{{ $i }}">
                <a href="{{ $href }}">{{ $label }}</a>
                @if($drop)
                    <button type="button" class="vvh-drawer__toggle" aria-label="Show services" aria-expanded="false"><i class="fa-solid fa-plus"></i></button>
                    <div class="vvh-drawer__sub">
                        @foreach($svcList as $s)
                            <a href="{{ $s->url() }}"><i class="fa-solid {{ $s->icon ?: 'fa-hand-holding-heart' }}"></i> {{ $s->title }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </nav>
    <div class="vvh-drawer__foot">
        <a href="tel:{{ $tel }}" class="vvh-drawer__btn vvh-drawer__btn--gold"><i class="fa-solid fa-phone"></i> {{ $phone }}</a>
        <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="vvh-drawer__btn vvh-drawer__btn--wa"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
        <button type="button" class="vvh-drawer__btn vvh-drawer__btn--line" data-vv-enquire>Make An Appointment</button>
        <p><i class="fa-solid fa-location-dot"></i> {{ config('site.address') }}</p>
    </div>
</div>
<div class="vvh-scrim"></div>
</div>
