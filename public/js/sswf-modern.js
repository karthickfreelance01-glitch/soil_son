/* SSWF — modern interactions (no dependencies). */
(function () {
  'use strict';
  var d = document, html = d.documentElement;
  window.vvReady = true;
  html.classList.add('vv-js');
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- Scroll progress + header shadow ---------- */
  var bar = d.createElement('div'); bar.className = 'vv-progress'; d.body.appendChild(bar);
  var header = d.getElementById('vvHeader') || d.getElementById('site-header');
  var ticking = false;
  function onScroll() {
    var max = html.scrollHeight - window.innerHeight;
    bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(window.scrollY / max, 1) : 0) + ')';
    if (header) { header.classList.toggle('is-scrolled', window.scrollY > 40); header.classList.toggle('is-compact', window.scrollY > 60); }
    html.classList.toggle('vv-scrolled', window.scrollY > 320);
    ticking = false;
  }
  window.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(onScroll); } }, { passive: true });
  onScroll();


  /* ---------- Header: mobile drawer ---------- */
  var drawer = d.getElementById('vvhDrawer'), burger = d.querySelector('.vvh-burger');
  if (drawer && burger) {
    var openD = function () { html.classList.add('vvh-open'); drawer.setAttribute('aria-hidden', 'false'); burger.setAttribute('aria-expanded', 'true'); setTimeout(function () { var c = drawer.querySelector('.vvh-drawer__close'); c && c.focus(); }, 300); };
    var closeD = function () { html.classList.remove('vvh-open'); drawer.setAttribute('aria-hidden', 'true'); burger.setAttribute('aria-expanded', 'false'); };
    burger.addEventListener('click', openD);
    drawer.querySelector('.vvh-drawer__close').addEventListener('click', closeD);
    var scrim = d.querySelector('.vvh-scrim'); if (scrim) scrim.addEventListener('click', closeD);
    d.addEventListener('keydown', function (e) { if (e.key === 'Escape' && html.classList.contains('vvh-open')) closeD(); });
    drawer.querySelectorAll('.vvh-drawer__toggle').forEach(function (t) {
      t.addEventListener('click', function () {
        var sub = t.parentNode.querySelector('.vvh-drawer__sub'), on = sub.classList.toggle('is-open');
        t.setAttribute('aria-expanded', on ? 'true' : 'false');
      });
    });
    drawer.addEventListener('click', function (e) { if (e.target.closest('[data-vv-enquire], a[href]')) closeD(); });
    window.addEventListener('resize', function () { if (window.innerWidth > 1024) closeD(); });
  }

  /* ---------- Reveal on scroll ---------- */
  // Gently animate existing page sections that start below the fold.
  d.querySelectorAll('.elementor-top-section').forEach(function (s) {
    if (s.querySelector('.elementor-invisible') || s.getBoundingClientRect().top < window.innerHeight) return;
    s.classList.add('vv-auto-reveal');
  });
  var targets = d.querySelectorAll('[data-vv-reveal], .vv-auto-reveal');
  if (reduce || !('IntersectionObserver' in window)) {
    targets.forEach(function (t) { t.classList.add('is-in'); });
  } else {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    targets.forEach(function (t) { io.observe(t); });
  }

  /* ---------- Side enquiry panel ---------- */
  var panel = d.getElementById('vvEnquiry');
  if (panel) {
    var form = d.getElementById('vvEnqForm'), done = panel.querySelector('.vv-enq__done'),
        alertBox = panel.querySelector('.vv-enq__alert'), lastFocus = null;

    var open = function (service) {
      lastFocus = d.activeElement;
      if (service) { var sel = d.getElementById('vvEnqService'); if (sel) { sel.value = service; if (sel.value !== service) sel.value = ''; } }
      html.classList.add('vv-enq-open', 'vv-lock');
      panel.setAttribute('aria-hidden', 'false');
      d.querySelectorAll('.vv-enq-tab').forEach(function (b) { b.setAttribute('aria-expanded', 'true'); });
      setTimeout(function () { var f = d.getElementById('vvEnqName'); if (f && done.hidden) f.focus(); }, 350);
    };
    var close = function () {
      html.classList.remove('vv-enq-open', 'vv-lock');
      panel.setAttribute('aria-hidden', 'true');
      d.querySelectorAll('.vv-enq-tab').forEach(function (b) { b.setAttribute('aria-expanded', 'false'); });
      if (!done.hidden) setTimeout(function () { done.hidden = true; form.hidden = false; form.reset(); }, 500);
      if (lastFocus && lastFocus.focus) lastFocus.focus();
    };
    window.vvOpenEnquiry = open;

    d.addEventListener('click', function (e) {
      var t = e.target.closest('[data-vv-enquire]');
      if (t) { e.preventDefault(); open(t.getAttribute('data-vv-enquire')); return; }
      if (e.target.closest('[data-vv-close]')) { e.preventDefault(); close(); }
    });
    d.addEventListener('keydown', function (e) { if (e.key === 'Escape' && html.classList.contains('vv-enq-open')) close(); });
    if (location.hash === '#enquiry') open();

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      alertBox.textContent = '';
      form.querySelectorAll('.has-error').forEach(function (f) { f.classList.remove('has-error'); });

      var name = form.elements.name, mobile = form.elements.mobile, errors = [];
      if (!name.value.trim()) { errors.push('Please enter your name.'); name.parentNode.classList.add('has-error'); }
      if (!/^[0-9+\-\s()]{7,20}$/.test(mobile.value.trim())) { errors.push('Please enter a valid mobile number.'); mobile.parentNode.classList.add('has-error'); }
      if (errors.length) { alertBox.textContent = errors.join(' '); return; }

      var btn = form.querySelector('button[type=submit]');
      btn.classList.add('is-loading'); btn.disabled = true;

      fetch(form.action, {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: new FormData(form),
        credentials: 'same-origin'
      }).then(function (r) {
        return r.json().catch(function () { return {}; }).then(function (j) { return { ok: r.ok, status: r.status, body: j }; });
      }).then(function (res) {
        if (res.ok && res.body.status) {
          form.hidden = true; done.hidden = false;
          var p = done.querySelector('p'); if (res.body.message) p.textContent = res.body.message;
        } else if (res.status === 422 && res.body.errors) {
          alertBox.textContent = Object.keys(res.body.errors).map(function (k) { return res.body.errors[k][0]; }).join(' ');
        } else if (res.status === 419) {
          alertBox.textContent = 'Your session expired. Please refresh the page and try again.';
        } else if (res.status === 429) {
          alertBox.textContent = 'Too many attempts. Please wait a minute or call us directly.';
        } else {
          alertBox.textContent = 'Sorry, something went wrong. Please call us directly.';
        }
      }).catch(function () {
        alertBox.textContent = 'Network error. Please check your connection or call us directly.';
      }).then(function () { btn.classList.remove('is-loading'); btn.disabled = false; });
    });
  }

  /* ---------- Gallery filters + lightbox ---------- */
  var gallery = d.getElementById('vvGallery');
  if (gallery) {
    var items = [].slice.call(gallery.querySelectorAll('.vv-gallery__item'));
    d.querySelectorAll('.vv-filter').forEach(function (btn) {
      btn.addEventListener('click', function () {
        d.querySelectorAll('.vv-filter').forEach(function (b) { b.classList.remove('is-active'); });
        btn.classList.add('is-active');
        var f = btn.getAttribute('data-filter');
        items.forEach(function (it) {
          var show = f === '*' || it.getAttribute('data-cat') === f;
          it.classList.toggle('is-hidden', !show);
          if (show) it.classList.add('is-in');
        });
      });
    });

    var lb = d.getElementById('vvLightbox'), img = lb.querySelector('img'), cap = lb.querySelector('figcaption'), idx = 0;
    var visible = function () { return items.filter(function (i) { return !i.classList.contains('is-hidden'); }); };
    var show = function (i) {
      var list = visible(); if (!list.length) return;
      idx = (i + list.length) % list.length;
      var a = list[idx];
      img.src = a.getAttribute('href'); img.alt = a.querySelector('img').alt; cap.textContent = a.getAttribute('data-caption') || '';
    };
    items.forEach(function (a) {
      a.addEventListener('click', function (e) {
        e.preventDefault(); show(visible().indexOf(a));
        lb.classList.add('is-open'); lb.setAttribute('aria-hidden', 'false'); html.classList.add('vv-lock');
      });
    });
    var closeLb = function () { lb.classList.remove('is-open'); lb.setAttribute('aria-hidden', 'true'); html.classList.remove('vv-lock'); };
    lb.querySelector('.vv-lightbox__close').addEventListener('click', closeLb);
    lb.querySelector('.vv-lightbox__prev').addEventListener('click', function () { show(idx - 1); });
    lb.querySelector('.vv-lightbox__next').addEventListener('click', function () { show(idx + 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) closeLb(); });
    d.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('is-open')) return;
      if (e.key === 'Escape') closeLb();
      if (e.key === 'ArrowLeft') show(idx - 1);
      if (e.key === 'ArrowRight') show(idx + 1);
    });
    var sx = 0;
    lb.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) { var dx = e.changedTouches[0].clientX - sx; if (Math.abs(dx) > 50) show(idx + (dx < 0 ? 1 : -1)); });
  }
})();
