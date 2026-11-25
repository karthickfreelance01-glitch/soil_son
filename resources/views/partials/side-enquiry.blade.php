{{-- Slide-out "Quick Enquiry" panel + floating call / WhatsApp buttons, on every public page. --}}
@php
    $vvPhone = preg_replace('/\s+/', '', config('site.phone'));
    $vvWa = preg_replace('/\D/', '', config('site.phone'));
@endphp
<button type="button" class="vv-enq-tab" data-vv-enquire aria-controls="vvEnquiry" aria-expanded="false">
    <i class="fa-solid fa-envelope-open-text"></i><span>Quick Enquiry</span>
</button>

<div class="vv-fab">
    <a href="https://wa.me/{{ $vvWa }}?text={{ rawurlencode('Hello SSWF, I would like to know more about your services.') }}" target="_blank" rel="noopener" class="vv-fab__btn vv-fab__btn--wa" aria-label="Chat on WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
    <a href="tel:{{ $vvPhone }}" class="vv-fab__btn vv-fab__btn--call" aria-label="Call {{ config('site.phone') }}"><i class="fa-solid fa-phone"></i></a>
</div>

<div class="vv-enq-overlay" data-vv-close></div>
<aside class="vv-enq" id="vvEnquiry" role="dialog" aria-modal="true" aria-labelledby="vvEnqTitle" aria-hidden="true">
    <div class="vv-enq__head">
        <div>
            <span class="vv-enq__badge"><i class="fa-solid fa-lock"></i> 100% confidential</span>
            <h3 id="vvEnqTitle">How can we help?</h3>
            <p>Leave your details and our counsellor will call you back shortly.</p>
        </div>
        <button type="button" class="vv-enq__close" data-vv-close aria-label="Close">&times;</button>
    </div>

    <form class="vv-enq__form" id="vvEnqForm" action="{{ route('enquiry.store') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="page_url" value="{{ url()->current() }}">
        <div class="vv-hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

        <div class="vv-field">
            <input type="text" name="name" id="vvEnqName" placeholder=" " required maxlength="100" autocomplete="name">
            <label for="vvEnqName">Your name *</label>
        </div>
        <div class="vv-field">
            <input type="tel" name="mobile" id="vvEnqMobile" placeholder=" " required maxlength="20" autocomplete="tel" inputmode="tel">
            <label for="vvEnqMobile">Mobile number *</label>
        </div>
        <div class="vv-field">
            <input type="email" name="email" id="vvEnqEmail" placeholder=" " maxlength="150" autocomplete="email">
            <label for="vvEnqEmail">Email (optional)</label>
        </div>
        <div class="vv-field vv-field--select">
            <select name="service" id="vvEnqService">
                <option value="">General enquiry</option>
                @foreach(\App\Support\SiteData::serviceNames() as $svc)<option value="{{ $svc }}">{{ $svc }}</option>@endforeach
            </select>
            <label for="vvEnqService">Service</label>
        </div>
        <div class="vv-field">
            <textarea name="message" id="vvEnqMsg" rows="3" placeholder=" " maxlength="1000"></textarea>
            <label for="vvEnqMsg">Message (optional)</label>
        </div>

        <div class="vv-enq__alert" role="status" aria-live="polite"></div>

        <button type="submit" class="vv-btn vv-btn--block">
            <span class="vv-btn__label">Request a call back</span>
            <span class="vv-spinner" aria-hidden="true"></span>
        </button>
        <p class="vv-enq__or">or call us directly <a href="tel:{{ $vvPhone }}"><i class="fa-solid fa-phone"></i> {{ config('site.phone') }}</a></p>
    </form>

    <div class="vv-enq__done" hidden>
        <div class="vv-enq__check"><i class="fa-solid fa-check"></i></div>
        <h3>Thank you!</h3>
        <p>We have received your enquiry. Our counsellor will call you shortly.</p>
        <button type="button" class="vv-btn vv-btn--ghost" data-vv-close>Close</button>
    </div>
</aside>
