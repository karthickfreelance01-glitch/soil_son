@extends('layouts.app')

@section('bodyclass','no-sidebar site-layout-full-width is-page footer-no-widget elementor-default elementor-kit-7 vvp-home')

@section('head')
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
@include('partials.seo', ['seoKey' => 'home', 'seoDefaults' => [
    'title' => 'Best De-addiction center in Madurai | Soil Sons Welfare Foundation',
    'description' => 'Best De-addiction center in Madurai - Soil Sons Welfare Foundation is a trusted and compassionate de-addiction and rehabilitation centre committed to helping individuals reclaim their lives.',
    'path' => '/',
    'image' => 'assets/uploads/sswf/hero-2.jpg',
]])
@include('partials.theme-head')
<link rel="preload" as="image" href="{{ asset('assets/uploads/sswf/slide-2.jpg') }}">
<link rel="stylesheet" href="{{ $A }}css/sswf-home.css?v=4">
@endsection

@section('content')
@php
    $phone    = config('site.phone');
    $tel      = preg_replace('/\s+/', '', $phone);
    $wa       = preg_replace('/\D/', '', $phone);
    $services = \App\Support\SiteData::services();
    $photos   = \App\Support\SiteData::gallery()->take(5);
    $slides   = [
        ['img' => 'slide-2.jpg',            'pos' => 'center 40%'],
        ['img' => 'campus-garden-view.jpg', 'pos' => 'center 55%'],
        ['img' => 'section-bg.jpg',         'pos' => 'center 45%'],
        ['img' => 'slide-1.jpg',            'pos' => 'center 50%'],
    ];
@endphp
<div id="main-content" class="site-main clearfix vvp">

    {{-- ============================== HERO ============================== --}}
    <section class="vvp-hero" aria-label="Welcome">
        <div class="vvp-hero__slides" aria-hidden="true">
            @foreach($slides as $s)
                <div class="vvp-hero__slide {{ $loop->first ? 'is-active' : '' }}"
                     style="background-image:url('{{ asset('assets/uploads/sswf/'.$s['img']) }}');background-position:{{ $s['pos'] }}"></div>
            @endforeach
        </div>
        <div class="vvp-hero__veil"></div>
        <div class="vvp-hero__grain"></div>

        <div class="vvp-wrap vvp-hero__inner">
            <div class="vvp-hero__copy">
                <p class="vvp-kicker vvp-rise" style="--d:.1s"><span></span> De-Addiction &amp; Rehabilitation &middot; Madurai</p>
                <h1 class="vvp-hero__title vvp-rise" style="--d:.25s">
                    A new dawn for an<br><em>addiction-free</em> life.
                </h1>
                <p class="vvp-hero__tamil vvp-rise" style="--d:.4s">SSWF — போதையில்லா வாழ்க்கைக்கு ஒரு புதிய விடியல்</p>
                <p class="vvp-hero__lead vvp-rise" style="--d:.5s">
                    Compassionate, confidential and medically supervised care for alcohol and drug dependence —
                    with a calm residential campus at Sellur and a team that walks with your family at every step.
                </p>
                <div class="vvp-hero__ctas vvp-rise" style="--d:.65s">
                    <button type="button" class="vvp-btn vvp-btn--gold" data-vv-enquire>
                        Book a confidential appointment <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <a href="tel:{{ $tel }}" class="vvp-btn vvp-btn--glass"><i class="fa-solid fa-phone"></i> {{ $phone }}</a>
                </div>
                <ul class="vvp-hero__trust vvp-rise" style="--d:.8s">
                    <li><i class="fa-solid fa-shield-heart"></i> 100% confidential</li>
                    <li><i class="fa-solid fa-user-doctor"></i> Doctor-led treatment</li>
                    <li><i class="fa-solid fa-clock"></i> 24×7 care</li>
                </ul>
            </div>
        </div>

        <div class="vvp-hero__dots" role="tablist" aria-label="Background images">
            @foreach($slides as $s)
                <button type="button" class="{{ $loop->first ? 'is-active' : '' }}" aria-label="Show image {{ $loop->iteration }}"></button>
            @endforeach
        </div>
        <a href="#about" class="vvp-hero__scroll" aria-label="Scroll to learn more"><span></span></a>
    </section>

    {{-- ============================== STATS ============================== --}}
    <section class="vvp-stats" aria-label="At a glance">
        <div class="vvp-wrap vvp-stats__grid">
            @foreach([
                ['15', '+', 'Years of experience', 'fa-award'],
                ['24', '×7', 'Medical supervision', 'fa-heart-pulse'],
                ['3', '', 'Specialised programmes', 'fa-hand-holding-heart'],
                ['100', '%', 'Private & confidential', 'fa-lock'],
            ] as [$n, $suffix, $label, $ic])
                <div class="vvp-stat" data-vv-reveal style="--d:{{ $loop->index * 90 }}ms">
                    <i class="fa-solid {{ $ic }}"></i>
                    <div class="vvp-stat__num"><span data-count="{{ $n }}">{{ $n }}</span>{{ $suffix }}</div>
                    <div class="vvp-stat__label">{{ $label }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============================== ABOUT ============================== --}}
    <section class="vvp-section" id="about">
        <div class="vvp-wrap vvp-about">
            <div class="vvp-about__media" data-vv-reveal>
                <figure class="vvp-about__main"><img src="{{ asset('assets/uploads/sswf/about-centre.jpg') }}" alt="Awareness class at Soil Sons Welfare Foundation, Madurai" loading="lazy"></figure>
                <figure class="vvp-about__sub"><img src="{{ asset('assets/uploads/sswf/counselling-room.jpg') }}" alt="Counselling room at SSWF" loading="lazy"></figure>
                <div class="vvp-about__badge">
                    <strong>15</strong>
                    <span>Years of<br>Experience</span>
                </div>
            </div>
            <div class="vvp-about__copy">
                <p class="vvp-eyebrow" data-vv-reveal>About SSWF</p>
                <h2 class="vvp-h2" data-vv-reveal>Best De-addiction center in <em>Madurai</em></h2>
                <div class="vvp-rule" data-vv-reveal></div>
                <p class="vvp-lead" data-vv-reveal><strong>Soil Sons Welfare Foundation</strong> is a trusted and compassionate de-addiction and rehabilitation centre committed to helping individuals reclaim their lives from the challenges of addiction.</p>
                <p data-vv-reveal>With a multidisciplinary team of experienced counselors, therapists, and healthcare professionals, we focus on providing evidence-based treatments, personalized care plans, and a supportive healing environment. Our holistic approach addresses the physical, psychological, emotional, and social aspects of recovery, ensuring long-term transformation and relapse prevention.</p>
                <p data-vv-reveal>At <strong>Soil Sons Welfare Foundation</strong>, we believe that every individual deserves a second chance, and we are dedicated to empowering them with the strength, guidance, and tools they need to rebuild a healthy and meaningful life.</p>
                <div class="vvp-about__actions" data-vv-reveal>
                    <a href="/about" class="vvp-btn vvp-btn--plum">Read More <i class="fa-solid fa-arrow-right"></i></a>
                    <span class="vvp-signature">SSWF <small>— “the morning star”</small></span>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================== VISION / MISSION ============================== --}}
    <section class="vvp-section vvp-section--cream">
        <div class="vvp-wrap">
            <div class="vvp-head" data-vv-reveal>
                <p class="vvp-eyebrow">Our purpose</p>
                <h2 class="vvp-h2">We transform <em>reality</em></h2>
            </div>
            <div class="vvp-vm">
                <article class="vvp-vm__card" data-vv-reveal>
                    <span class="vvp-vm__num">01</span>
                    <i class="fa-regular fa-eye"></i>
                    <h3>Vision</h3>
                    <p>To create a society free from the clutches of addiction by empowering individuals to lead healthy, fulfilling, and addiction-free lives through compassion, care, and professional rehabilitation services.</p>
                </article>
                <article class="vvp-vm__card vvp-vm__card--dark" data-vv-reveal style="--d:120ms">
                    <span class="vvp-vm__num">02</span>
                    <i class="fa-solid fa-bullseye"></i>
                    <h3>Mission</h3>
                    <p>Our mission is to provide effective, evidence-based de-addiction and rehabilitation programs that promote recovery, restore mental and physical well-being, and reintegrate individuals into society with renewed hope.</p>
                </article>
            </div>
        </div>
    </section>

    {{-- ============================== SERVICES ============================== --}}
    <section class="vvp-section">
        <div class="vvp-wrap">
            <div class="vvp-head vvp-head--split">
                <div data-vv-reveal>
                    <p class="vvp-eyebrow">Our Services</p>
                    <h2 class="vvp-h2">Care for every step of <em>recovery</em></h2>
                </div>
                <a href="/services" class="vvp-link" data-vv-reveal>View all services <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="vvp-services">
                @foreach($services as $s)
                    <article class="vvp-svc" data-vv-reveal style="--d:{{ $loop->index * 100 }}ms">
                        <a href="{{ $s->url() }}" class="vvp-svc__img" tabindex="-1" aria-hidden="true">
                            @if($s->image)<img src="{{ $s->imageUrl() }}" alt="" loading="lazy">@endif
                        </a>
                        <div class="vvp-svc__body">
                            <span class="vvp-svc__icon"><i class="fa-solid {{ $s->icon ?: 'fa-hand-holding-heart' }}"></i></span>
                            <span class="vvp-svc__no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3><a href="{{ $s->url() }}">{{ $s->title }}</a></h3>
                            <p>{{ $s->short_description }}</p>
                            <div class="vvp-svc__foot">
                                <a href="{{ $s->url() }}" class="vvp-link">Learn more <i class="fa-solid fa-arrow-right"></i></a>
                                <button type="button" class="vvp-chip" data-vv-enquire="{{ $s->title }}">Enquire</button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================== WHY CHOOSE US ============================== --}}
    <section class="vvp-why">
        <div class="vvp-why__bg" style="background-image:url('{{ asset('assets/uploads/sswf/section-bg.jpg') }}')"></div>
        <div class="vvp-wrap vvp-why__inner">
            <div class="vvp-why__intro" data-vv-reveal>
                <p class="vvp-eyebrow vvp-eyebrow--light">Why choose us?</p>
                <h2 class="vvp-h2 vvp-h2--light">A safe place to <em>heal</em>, and to begin again.</h2>
                <p>Recovery needs more than medicine. At SSWF it is supported by routine, nutrition, movement, counselling and the people around you.</p>
                <button type="button" class="vvp-btn vvp-btn--gold" data-vv-enquire>Plan a visit <i class="fa-solid fa-arrow-right"></i></button>
            </div>
            <ul class="vvp-why__list">
                @foreach([
                    ['fa-briefcase-medical', '24×7 Health Care Assistance'],
                    ['fa-user-nurse', '24×7 Patient Support & Monitoring'],
                    ['fa-shield-heart', 'Safe, Secure & Hygienic Environment'],
                    ['fa-comments', 'Personalized Counseling & Therapy'],
                    ['fa-people-group', 'Group Therapy & Peer Support'],
                    ['fa-spa', 'Yoga, Meditation & Fitness Sessions'],
                    ['fa-person-chalkboard', 'Motivational & Life Skill Training'],
                    ['fa-bowl-food', 'Nutritious Meals & Wellness Programs'],
                ] as [$ic, $t])
                    <li data-vv-reveal style="--d:{{ $loop->index * 60 }}ms"><span><i class="fa-solid {{ $ic }}"></i></span>{{ $t }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- ============================== JOURNEY ============================== --}}
    <section class="vvp-section vvp-section--cream">
        <div class="vvp-wrap">
            <div class="vvp-head" data-vv-reveal>
                <p class="vvp-eyebrow">Your journey with us</p>
                <h2 class="vvp-h2">Five gentle steps to <em>recovery</em></h2>
            </div>
            <ol class="vvp-steps">
                @foreach([
                    ['fa-phone', 'Reach out', 'Call or send an enquiry. Everything you share stays private.'],
                    ['fa-stethoscope', 'Assessment', 'Our doctor and counsellor understand the person, the habit and the family.'],
                    ['fa-house-medical', 'Safe detox', 'Medically supervised de-addiction in a calm residential setting.'],
                    ['fa-seedling', 'Rehabilitation', 'Therapy, yoga, routine and life skills to rebuild strength and confidence.'],
                    ['fa-people-roof', 'Aftercare', 'Family counselling and follow-up to protect long-term recovery.'],
                ] as [$ic, $t, $d])
                    <li class="vvp-step" data-vv-reveal style="--d:{{ $loop->index * 110 }}ms">
                        <span class="vvp-step__dot"><i class="fa-solid {{ $ic }}"></i></span>
                        <span class="vvp-step__no">Step {{ $loop->iteration }}</span>
                        <h3>{{ $t }}</h3>
                        <p>{{ $d }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ============================== AWARENESS (Tamil) ============================== --}}
    <section class="vvp-section vvp-aware" lang="ta">
        <div class="vvp-wrap vvp-aware__grid">
            <div class="vvp-aware__posters" data-vv-reveal>
                <img src="{{ asset('assets/uploads/sswf/poster-addiction-stages.jpg') }}" alt="Stages of alcohol addiction - SSWF" loading="lazy">
                <img src="{{ asset('assets/uploads/sswf/poster-holistic-care.jpg') }}" alt="Holistic care for body, mind and spirit - SSWF" loading="lazy">
            </div>
            <div class="vvp-aware__copy">
                <p class="vvp-eyebrow" data-vv-reveal>விழிப்புணர்வு</p>
                <h2 class="vvp-h2 vvp-tamil" data-vv-reveal>குடிபோதை – வாழ்க்கையை கட்டுப்படுத்தும் மறைமுக நோய்</h2>
                <div class="vvp-rule" data-vv-reveal></div>
                <p class="vvp-tamil" data-vv-reveal>குடி உங்களுக்கோ உங்களைச் சார்ந்தவர்களுக்கோ பிரச்சனையா SSWF குடிபோதை* மனநல சிகிச்சை &amp; #மறுவாழ்வு மையம் நாங்கள் உங்களை அன்போடு வரவேற்கிறோம். வாழ்க்கையில் சந்தோஷத்திற்காக குடிக்க ஆரம்பித்து, படிப்படியாக குடிபோதை இல்லாமல் வாழ்க்கையே இல்லை என்ற நிலைமைக்கு வந்தவர்கள்- குடிபோதை அடிமைகள் ஆவார்கள்.</p>
                <ul class="vvp-facts vvp-tamil" data-vv-reveal>
                    <li>எல்லாவிதமான மதுவிலும் ஒரே வகையான போதைப் பொருள் தான் உள்ளது. (சதவிகிதம் மட்டுமே மாறுபடுகிறது).</li>
                    <li>மதுவில் எந்த விதமான சத்துப் பொருட்களும் இல்லை. மது உடல் பலத்தையோ, உடல் நலத்தையோ உயர்த்துவதில்லை.</li>
                    <li>குடித்தவுடன் மது வேகமாக மூளைக்கு சென்று, மூளையின் செயல்திறனை உடனடியாக குறைத்து விடுகிறது.</li>
                    <li>மது ஒருவரின் செயல்படும் திறனை அதிகரிப்பது இல்லை; மாறாக பல்வேறு பாதிப்புகளை ஏற்படுத்துகிறது.</li>
                    <li>குடிப்பதால் மனக்கவலை, ஏமாற்றம், வருத்தம் போன்ற உணர்ச்சிகள் மறைவதில்லை; மாறாக அவை அதிகரிக்கின்றன.</li>
                    <li>மது குடிப்பதால் உடல் அசதி குறைவதில்லை; ஆழ்ந்த, தரமான தூக்கம் ஏற்படுவதில்லை.</li>
                </ul>
                <details class="vvp-more vvp-tamil" data-vv-reveal>
                    <summary><span class="vvp-more__open">மேலும் படிக்க</span><span class="vvp-more__close">சுருக்கு</span> <i class="fa-solid fa-chevron-down"></i></summary>
                    <h3>குடிக்கு அடிமையாவது ஒரு நோய்.</h3>
                    <p>இந்த நோய்க்கு அடிமையானவர்களின் குடும்பத்தினரும் மிகுந்த மன நோய்க்கு ஆளாகிறார்கள். #குடிப்பவர்களில் 10 லிருந்து 20 சதவிகிதத்தினர் மதுவிற்கு அடிமையாகிவிடுகின்றனர். ஏழை – பணக்காரர், படித்தவர்- படிக்காதவர், தொழிலாளி- முதலாளி போன்ற பாகுபாடே இல்லாமல், குடிப்பவர்களில் யாருக்கு வேண்டுமானாலும் இந்நோய் வரலாம். #குடிநோயாளி உடலளவிலும் மனதளவிலும் மதுவிற்கு அடிமையாகி, வாழ்க்கையில் எவ்வளவு பிரச்சனைகள் ஏற்பட்டாலும #குடிப்பதை நிறுத்தாமல் தொடர்ந்து குடித்துக் கொண்டே இருப்பார்கள். ஏனெனில் குடிக்காமல் இருந்தால் கை நடுக்கம், தூக்கமின்மை, மனச்சோர்வு ஏற்படும். #ஒரு #குடிநோயாளியால் குடிக்கும் அளவைக் குறைக்கவோ குடிக்கும் இடைவெளியை அதிகரிக்கவோ முடியாது. முழுமையாக வாழ்நாள் முழுவதும் குடிக்காமல் இருப்பது தான் இந்த நோயிலிருந்து விடுபட ஒரே வழி.</p>
                    <h3>தீவிரமான இறுதி நிலை</h3>
                    <p>#தொடர்ந்து குடித்துக்கொண்டே இருப்பது – குடிப்பதற்காக கடன் வாங்குவது – பொய் பேசுவது, திருடுவது – மனபிரமை – மனைவியின் மீது சந்தேகப்படுவது குடித்தால் தான் செயல்பட முடியும் என்று நினைப்பது இந்த நிலையை தவிர்க்க போதை இல்லா பெருவாழ்வு வாழ்ந்திட அனுபவமிக்க திறமை வாய்ந்த சேவை உணர்வு மிக்க இத்துறையில் தேர்ச்சி பெற்ற நிபுணர்களால் நடத்தப்படும் எமது சிகிச்சை மையத்தை நாடவும் #இதற்கு சிகிச்சை முறைகள் உடல்நல பிரச்சனைக்கு பொது மருத்துவர் மூலமும் மனநல பிரச்சனைக்கு மனநல மருத்துவர் மூலமும் சிகிச்சை மனநல ஆலோசனை குடும்ப நல ஆலோசனை #மையத்தின் சிறப்பு அம்சங்கள் #மருத்துவர் ஆலோசனைப்படி ஆரோக்கியமான மற்றும் சத்தான உணவு 24 மணி நேர கண்காணிப்பு வசதி உள்ளது இயற்கை சூழல் நிறைந்த பாதுகாப்புடன் கூடிய மையம் தனித்தனி படுக்கை வசதி கொண்டது SSWF குடி மற்றும் போதை மனநல சிகிச்சை மறுவாழ்வு மையம் SF-436, சாமநாயக்கன்பாளையம் சாலை, வெள்ளமடை, கோயம்புத்தூர் – 625002</p>
                </details>
                <div class="vvp-aware__cta" data-vv-reveal>
                    <a href="tel:{{ $tel }}" class="vvp-btn vvp-btn--plum"><i class="fa-solid fa-phone"></i> பேசுங்கள் — {{ $phone }}</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================== FACILITIES ============================== --}}
    <section class="vvp-section vvp-section--cream">
        <div class="vvp-wrap">
            <div class="vvp-head vvp-head--split">
                <div data-vv-reveal>
                    <p class="vvp-eyebrow">Our Facilities</p>
                    <h2 class="vvp-h2">A calm, green campus at <em>Sellur</em></h2>
                </div>
                <a href="/gallery" class="vvp-link" data-vv-reveal>Open the gallery <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="vvp-mosaic">
                @foreach($photos as $p)
                    <a href="/gallery" class="vvp-mosaic__item vvp-mosaic__item--{{ $loop->iteration }}" data-vv-reveal style="--d:{{ $loop->index * 80 }}ms">
                        <img src="{{ $p->imageUrl() }}" alt="{{ $p->alt_text ?: $p->title }}" loading="lazy">
                        <span>{{ $p->title }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================== VISIT / CTA ============================== --}}
    <section class="vvp-visit">
        <div class="vvp-wrap vvp-visit__grid">
            <div class="vvp-visit__copy" data-vv-reveal>
                <p class="vvp-eyebrow vvp-eyebrow--light">Take the first step</p>
                <h2 class="vvp-h2 vvp-h2--light">Recovery starts with <em>one conversation.</em></h2>
                <p>Call us, message us on WhatsApp, or leave your number — our counsellor will call you back. Completely confidential.</p>
                <div class="vvp-hero__ctas">
                    <button type="button" class="vvp-btn vvp-btn--gold" data-vv-enquire>Request a call back <i class="fa-solid fa-arrow-right"></i></button>
                    <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="vvp-btn vvp-btn--glass"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                </div>
            </div>
            <div class="vvp-visit__cards">
                <a class="vvp-info" href="tel:{{ $tel }}" data-vv-reveal>
                    <i class="fa-solid fa-phone"></i><span><small>Call</small>{{ $phone }}</span>
                </a>
                <a class="vvp-info" href="mailto:{{ config('site.email') }}" data-vv-reveal style="--d:90ms">
                    <i class="fa-solid fa-envelope"></i><span><small>Email</small>{{ config('site.email') }}</span>
                </a>
                <a class="vvp-info" href="https://www.google.com/maps/search/?api=1&query={{ rawurlencode(config('site.name').', '.config('site.address')) }}" target="_blank" rel="noopener" data-vv-reveal style="--d:180ms">
                    <i class="fa-solid fa-location-dot"></i><span><small>Visit us · Get directions</small>{{ config('site.address') }}</span>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
@include('partials.theme-scripts')
<script>
(function () {
  'use strict';
  /* Hero background crossfade (pauses when the tab is hidden or motion is reduced) */
  var slides = document.querySelectorAll('.vvp-hero__slide'), dots = document.querySelectorAll('.vvp-hero__dots button'), i = 0, timer;
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  function go(n) {
    slides[i].classList.remove('is-active'); dots[i] && dots[i].classList.remove('is-active');
    i = (n + slides.length) % slides.length;
    slides[i].classList.add('is-active'); dots[i] && dots[i].classList.add('is-active');
  }
  function play() { clearInterval(timer); if (!reduce && slides.length > 1) timer = setInterval(function () { go(i + 1); }, 6500); }
  dots.forEach(function (d, k) { d.addEventListener('click', function () { go(k); play(); }); });
  document.addEventListener('visibilitychange', function () { document.hidden ? clearInterval(timer) : play(); });
  play();

  /* Soft parallax on the "Why choose us" background */
  var why = document.querySelector('.vvp-why'), whyBg = document.querySelector('.vvp-why__bg');
  if (why && whyBg && !reduce) {
    var raf = false;
    window.addEventListener('scroll', function () {
      if (raf) return; raf = true;
      requestAnimationFrame(function () {
        var r = why.getBoundingClientRect();
        if (r.bottom > 0 && r.top < innerHeight) whyBg.style.setProperty('--py', ((r.top + r.height / 2 - innerHeight / 2) * -0.12).toFixed(1) + 'px');
        raf = false;
      });
    }, { passive: true });
  }

  /* Count-up numbers */
  var nums = document.querySelectorAll('[data-count]');
  if (!reduce && 'IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) {
        if (!e.isIntersecting) return;
        var el = e.target, end = +el.getAttribute('data-count'), t0 = null;
        (function step(t) { t0 = t0 || t; var p = Math.min((t - t0) / 1400, 1); el.textContent = Math.round(end * (1 - Math.pow(1 - p, 3))); if (p < 1) requestAnimationFrame(step); })(performance.now());
        io.unobserve(el);
      });
    }, { threshold: .6 });
    nums.forEach(function (n) { n.textContent = '0'; io.observe(n); });
  }
})();
</script>
@endsection
