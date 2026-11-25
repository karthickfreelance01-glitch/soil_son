{{-- Shared theme scripts for pages built outside Elementor. --}}
<script type="speculationrules">
{"prefetch":[{"source":"document","where":{"and":[{"href_matches":"/*"},{"not":{"href_matches":["/wp-*.php","/wp-admin/*","{{ $A }}assets/uploads/*","{{ $A }}assets/*","{{ $A }}assets/plugins/*","{{ $A }}assets/themes/tombuild/*","/*\\?(.+)"]}},{"not":{"selector_matches":"a[rel~=\"nofollow\"]"}},{"not":{"selector_matches":".no-prefetch, .no-prefetch a"}}]},"eagerness":"conservative"}]}
</script>
			<script>
				const lazyloadRunObserver = () => {
					const lazyloadBackgrounds = document.querySelectorAll( `.e-con.e-parent:not(.e-lazyloaded)` );
					const lazyloadBackgroundObserver = new IntersectionObserver( ( entries ) => {
						entries.forEach( ( entry ) => {
							if ( entry.isIntersecting ) {
								let lazyloadBackground = entry.target;
								if( lazyloadBackground ) {
									lazyloadBackground.classList.add( 'e-lazyloaded' );
								}
								lazyloadBackgroundObserver.unobserve( entry.target );
							}
						});
					}, { rootMargin: '200px 0px 200px 0px' } );
					lazyloadBackgrounds.forEach( ( lazyloadBackground ) => {
						lazyloadBackgroundObserver.observe( lazyloadBackground );
					} );
				};
				const events = [
					'DOMContentLoaded',
					'elementor/lazyload/observe',
				];
				events.forEach( ( event ) => {
					document.addEventListener( event, lazyloadRunObserver );
				} );
			</script>
					<script type="text/javascript">
			var visualizerUserInteractionEvents = [
				"scroll",
				"mouseover",
				"keydown",
				"touchmove",
				"touchstart"
			];

			visualizerUserInteractionEvents.forEach(function(event) {
				window.addEventListener(event, visualizerTriggerScriptLoader, { passive: true });
			});

			function visualizerTriggerScriptLoader() {
				visualizerLoadScripts();
				visualizerUserInteractionEvents.forEach(function(event) {
					window.removeEventListener(event, visualizerTriggerScriptLoader, { passive: true });
				});
			}

			function visualizerLoadScripts() {
				document.querySelectorAll("script[data-visualizer-script]").forEach(function(elem) {
					jQuery.getScript( elem.getAttribute("data-visualizer-script") )
					.done( function( script, textStatus ) {
						elem.setAttribute("src", elem.getAttribute("data-visualizer-script"));
						elem.removeAttribute("data-visualizer-script");
						setTimeout( function() {
							visualizerRefreshChart();
						} );
					} );
				});
			}

			function visualizerRefreshChart() {
				jQuery( '.visualizer-front:not(.visualizer-chart-loaded)' ).resize();
				if ( jQuery( 'div.viz-facade-loaded:not(.visualizer-lazy):empty' ).length > 0 ) {
					visualizerUserInteractionEvents.forEach( function( event ) {
						window.addEventListener( event, function() {
							jQuery( '.visualizer-front:not(.visualizer-chart-loaded)' ).resize();
						}, { passive: true } );
					} );
				}
			}
		</script>
			<script type="text/javascript" src="{{ $A }}assets/plugins/masterlayer-addons-for-elementor/assets/js/gsap.min.js?ver=1.0.0" id="gsap-js"></script>
<script type="text/javascript" src="{{ $A }}assets/plugins/masterlayer-addons-for-elementor/assets/js/waitforimages.js?ver=1.0.0" id="waitforimages-js"></script>
<script type="text/javascript" src="{{ $A }}assets/plugins/masterlayer-addons-for-elementor/assets/js/core.js?ver=1.0" id="mae-core-js"></script>
<script type="text/javascript" src="{{ $A }}assets/plugins/masterlayer-addons-for-elementor/assets/js/init.js?ver=1.0" id="mae-init-js"></script>
<script type="text/javascript" src="{{ $A }}assets/wp-includes/js/dist/hooks.min.js?ver=dd5603f07f9220ed27f1" id="wp-hooks-js"></script>
<script type="text/javascript" src="{{ $A }}assets/wp-includes/js/dist/i18n.min.js?ver=c26c3dc7bed366793375" id="wp-i18n-js"></script>
<script type="text/javascript" id="wp-i18n-js-after">
/* <![CDATA[ */
wp.i18n.setLocaleData( { 'text direction\u0004ltr': [ 'ltr' ] } );
//# sourceURL=wp-i18n-js-after
/* ]]> */
</script>
<script type="text/javascript" src="{{ $A }}assets/plugins/contact-form-7/includes/swv/js/index.js?ver=6.1.2" id="swv-js"></script>
<script type="text/javascript" id="contact-form-7-js-before">
/* <![CDATA[ */
var wpcf7 = {
    "api": {
        "root": "https:\/\/{{ config('site.url') }}\/wp-json\/",
        "namespace": "contact-form-7\/v1"
    }
};
//# sourceURL=contact-form-7-js-before
/* ]]> */
</script>
<script type="text/javascript" src="{{ $A }}assets/plugins/contact-form-7/includes/js/index.js?ver=6.1.2" id="contact-form-7-js"></script>
<script type="text/javascript" src="{{ $A }}assets/themes/tombuild/assets/js/animsition.js?ver=4.0.1" id="animsition-js"></script>
<script type="text/javascript" src="{{ $A }}assets/themes/tombuild/assets/js/easing.js?ver=1.3.0" id="easing-js"></script>
<script type="text/javascript" src="{{ $A }}assets/themes/tombuild/assets/js/fitvids.js?ver=1.0.0" id="fitvids-js"></script>
<script type="text/javascript" src="{{ $A }}assets/themes/tombuild/assets/js/main.js?ver=1.0" id="tombuild-theme-script-js"></script>
<script type="text/javascript" src="{{ $A }}assets/themes/tombuild/assets/js/cursor.js?ver=1.0.0" id="cursor-js"></script>
<script type="text/javascript" src="{{ $A }}assets/plugins/elementor/assets/js/webpack.runtime.min.js?ver=3.32.4" id="elementor-webpack-runtime-js"></script>
<script type="text/javascript" src="{{ $A }}assets/plugins/elementor/assets/js/frontend-modules.min.js?ver=3.32.4" id="elementor-frontend-modules-js"></script>
<script type="text/javascript" src="{{ $A }}assets/wp-includes/js/jquery/ui/core.min.js?ver=1.13.3" id="jquery-ui-core-js"></script>
<script type="text/javascript" id="elementor-frontend-js-before">
/* <![CDATA[ */
var elementorFrontendConfig = {"environmentMode":{"edit":false,"wpPreview":false,"isScriptDebug":false},"i18n":{"shareOnFacebook":"Share on Facebook","shareOnTwitter":"Share on Twitter","pinIt":"Pin it","download":"Download","downloadImage":"Download image","fullscreen":"Fullscreen","zoom":"Zoom","share":"Share","playVideo":"Play Video","previous":"Previous","next":"Next","close":"Close","a11yCarouselPrevSlideMessage":"Previous slide","a11yCarouselNextSlideMessage":"Next slide","a11yCarouselFirstSlideMessage":"This is the first slide","a11yCarouselLastSlideMessage":"This is the last slide","a11yCarouselPaginationBulletMessage":"Go to slide"},"is_rtl":false,"breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"responsive":{"breakpoints":{"mobile":{"label":"Mobile Portrait","value":767,"default_value":767,"direction":"max","is_enabled":true},"mobile_extra":{"label":"Mobile Landscape","value":880,"default_value":880,"direction":"max","is_enabled":false},"tablet":{"label":"Tablet Portrait","value":1024,"default_value":1024,"direction":"max","is_enabled":true},"tablet_extra":{"label":"Tablet Landscape","value":1200,"default_value":1200,"direction":"max","is_enabled":false},"laptop":{"label":"Laptop","value":1366,"default_value":1366,"direction":"max","is_enabled":false},"widescreen":{"label":"Widescreen","value":2400,"default_value":2400,"direction":"min","is_enabled":false}},
"hasCustomBreakpoints":false},"version":"3.32.4","is_static":false,"experimentalFeatures":{"e_font_icon_svg":true,"additional_custom_breakpoints":true,"e_optimized_markup":true,"theme_builder_v2":true,"e_pro_free_trial_popup":true,"home_screen":true,"global_classes_should_enforce_capabilities":true,"e_variables":true,"cloud-library":true,"e_opt_in_v4_page":true,"import-export-customization":true,"e_pro_variables":true},"urls":{"assets":"{{ $A }}assets\/plugins\/elementor\/assets\/","ajaxurl":"https:\/\/{{ config('site.url') }}\/wp-admin\/admin-ajax.php","uploadUrl":"{{ $A }}assets\/uploads"},"nonces":{"floatingButtonsClickTracking":"9e06db7e56"},"swiperClass":"swiper","settings":{"page":[],"editorPreferences":[]},"kit":{"global_image_lightbox":"no","active_breakpoints":["viewport_mobile","viewport_tablet"],"lightbox_enable_counter":"yes","lightbox_enable_fullscreen":"yes","lightbox_enable_zoom":"yes","lightbox_enable_share":"yes","lightbox_title_src":"title","lightbox_description_src":"description"},"post":{"id":6010,"title":"Gallery%20-%20SSWF%20Rehabilitation%20Centre","excerpt":"","featuredImage":false}};
//# sourceURL=elementor-frontend-js-before
/* ]]> */
</script>
<script type="text/javascript" src="{{ $A }}assets/plugins/elementor/assets/js/frontend.min.js?ver=3.32.4" id="elementor-frontend-js"></script>
<script type="text/javascript" src="{{ $A }}assets/plugins/elementor/assets/lib/swiper/v8/swiper.min.js?ver=8.4.5" id="swiper-js"></script>
<script type="text/javascript" src="{{ $A }}assets/plugins/elementor/assets/lib/e-gallery/js/e-gallery.min.js?ver=1.2.0" id="elementor-gallery-js"></script>
<script type="text/javascript" src="{{ $A }}assets/plugins/elementor-pro/assets/js/webpack-pro.runtime.min.js?ver=3.33.0" id="elementor-pro-webpack-runtime-js"></script>
<script type="text/javascript" id="elementor-pro-frontend-js-before">
/* <![CDATA[ */
var ElementorProFrontendConfig = {"ajaxurl":"https:\/\/{{ config('site.url') }}\/wp-admin\/admin-ajax.php","nonce":"e76468242f","urls":{"assets":"{{ $A }}assets\/plugins\/elementor-pro\/assets\/","rest":"https:\/\/{{ config('site.url') }}\/wp-json\/"},"settings":{"lazy_load_background_images":true},"popup":{"hasPopUps":false},"shareButtonsNetworks":{"facebook":{"title":"Facebook","has_counter":true},"twitter":{"title":"Twitter"},"linkedin":{"title":"LinkedIn","has_counter":true},"pinterest":{"title":"Pinterest","has_counter":true},"reddit":{"title":"Reddit","has_counter":true},"vk":{"title":"VK","has_counter":true},"odnoklassniki":{"title":"OK","has_counter":true},"tumblr":{"title":"Tumblr"},"digg":{"title":"Digg"},"skype":{"title":"Skype"},"stumbleupon":{"title":"StumbleUpon","has_counter":true},"mix":{"title":"Mix"},"telegram":{"title":"Telegram"},"pocket":{"title":"Pocket","has_counter":true},"xing":{"title":"XING","has_counter":true},"whatsapp":{"title":"WhatsApp"},"email":{"title":"Email"},"print":{"title":"Print"},"x-twitter":{"title":"X"},"threads":{"title":"Threads"}},
"facebook_sdk":{"lang":"en_US","app_id":""},"lottie":{"defaultAnimationUrl":"{{ $A }}assets\/plugins\/elementor-pro\/modules\/lottie\/assets\/animations\/default.json"}};
//# sourceURL=elementor-pro-frontend-js-before
/* ]]> */
</script>
<script type="text/javascript" src="{{ $A }}assets/plugins/elementor-pro/assets/js/frontend.min.js?ver=3.33.0" id="elementor-pro-frontend-js"></script>
<script type="text/javascript" src="{{ $A }}assets/plugins/elementor-pro/assets/js/elements-handlers.min.js?ver=3.33.0" id="pro-elements-handlers-js"></script>
<script id="wp-emoji-settings" type="application/json">
{"baseUrl":"https://s.w.org/images/core/emoji/17.0.2/72x72/","ext":".png","svgUrl":"https://s.w.org/images/core/emoji/17.0.2/svg/","svgExt":".svg","source":{"concatemoji":"{{ $A }}assets/wp-includes/js/wp-emoji-release.min.js?ver=6.9.1"}}
</script>
<script type="module">
/* <![CDATA[ */
/*! This file is auto-generated */
const a=JSON.parse(document.getElementById("wp-emoji-settings").textContent),o=(window._wpemojiSettings=a,"wpEmojiSettingsSupports"),s=["flag","emoji"];function i(e){try{var t={supportTests:e,timestamp:(new Date).valueOf()};sessionStorage.setItem(o,JSON.stringify(t))}catch(e){}}function c(e,t,n){e.clearRect(0,0,e.canvas.width,e.canvas.height),e.fillText(t,0,0);t=new Uint32Array(e.getImageData(0,0,e.canvas.width,e.canvas.height).data);e.clearRect(0,0,e.canvas.width,e.canvas.height),e.fillText(n,0,0);const a=new Uint32Array(e.getImageData(0,0,e.canvas.width,e.canvas.height).data);return t.every((e,t)=>e===a[t])}function p(e,t){e.clearRect(0,0,e.canvas.width,e.canvas.height),e.fillText(t,0,0);var n=e.getImageData(16,16,1,1);for(let e=0;e<n.data.length;e++)if(0!==n.data[e])return!1;return!0}function u(e,t,n,a){switch(t){case"flag":return n(e,"\ud83c\udff3\ufe0f\u200d\u26a7\ufe0f","\ud83c\udff3\ufe0f\u200b\u26a7\ufe0f")?!1:!n(e,"\ud83c\udde8\ud83c\uddf6","\ud83c\udde8\u200b\ud83c\uddf6")&&!n(e,"\ud83c\udff4\udb40\udc67\udb40\udc62\udb40\udc65\udb40\udc6e\udb40\udc67\udb40\udc7f","\ud83c\udff4\u200b\udb40\udc67\u200b\udb40\udc62\u200b\udb40\udc65\u200b\udb40\udc6e\u200b\udb40\udc67\u200b\udb40\udc7f");case"emoji":return!a(e,"\ud83e\u1fac8")}return!1}function f(e,t,n,a){let r;const o=(r="undefined"!=typeof WorkerGlobalScope&&self instanceof WorkerGlobalScope?new OffscreenCanvas(300,150):document.createElement("canvas")).getContext("2d",{willReadFrequently:!0}),s=(o.textBaseline="top",o.font="600 32px Arial",{});return e.forEach(e=>{s[e]=t(o,e,n,a)}),s}function r(e){var t=document.createElement("script");t.src=e,t.defer=!0,document.head.appendChild(t)}a.supports={everything:!0,everythingExceptFlag:!0},new Promise(t=>{let n=function(){try{var e=JSON.parse(sessionStorage.getItem(o));if("object"==typeof e&&"number"==typeof e.timestamp&&(new Date).valueOf()<e.timestamp+604800&&"object"==typeof e.supportTests)return e.supportTests}catch(e){}return null}();if(!n){if("undefined"!=typeof Worker&&"undefined"!=typeof OffscreenCanvas&&"undefined"!=typeof URL&&URL.createObjectURL&&"undefined"!=typeof Blob)try{var e="postMessage("+f.toString()+"("+[JSON.stringify(s),u.toString(),c.toString(),p.toString()].join(",")+"));",a=new Blob([e],{type:"text/javascript"});const r=new Worker(URL.createObjectURL(a),{name:"wpTestEmojiSupports"});return void(r.onmessage=e=>{i(n=e.data),r.terminate(),t(n)})}catch(e){}i(n=f(s,u,c,p))}t(n)}).then(e=>{for(const n in e)a.supports[n]=e[n],a.supports.everything=a.supports.everything&&a.supports[n],"flag"!==n&&(a.supports.everythingExceptFlag=a.supports.everythingExceptFlag&&a.supports[n]);var t;a.supports.everythingExceptFlag=a.supports.everythingExceptFlag&&!a.supports.flag,a.supports.everything||((t=a.source||{}).concatemoji?r(t.concatemoji):t.wpemoji&&t.twemoji&&(r(t.twemoji),r(t.wpemoji)))});
//# sourceURL=/assets/wp-includes/js/wp-emoji-loader.min.js
/* ]]> */
</script>
<script id="shopping-cart-items-updater" type="text/javascript"></script>
