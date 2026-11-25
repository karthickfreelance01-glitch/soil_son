<!DOCTYPE html>
<html lang="en-US" prefix="og: https://ogp.me/ns#" class="no-js">
<head>
@yield('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" media="print" onload="this.media='all'">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Manrope:wght@400;500;600;700&family=Noto+Sans+Tamil:wght@400;500;600&display=swap">
<link rel="stylesheet" href="{{ $A }}css/sswf-modern.css?v=5">
<link rel="stylesheet" href="{{ $A }}css/sswf-header.css?v=4">
<link rel="stylesheet" href="{{ $A }}css/sswf-ui.css?v=2">
<script>document.documentElement.classList.add('vv-js');setTimeout(function(){if(!window.vvReady){document.documentElement.classList.remove('vv-js');}},3500);</script>
</head>
<body class="@yield('bodyclass')">


<div id="wrapper" style="">
	<div class="tombuild-cursor" data-config='{&quot;efx&quot;:[{&quot;target&quot;:&quot;.demo&quot;,&quot;text&quot;:&quot;View Page&quot;,&quot;classes&quot;:&quot;circle-with-text&quot;}]}'>
    <div class="inner">
      	<span class="text"></span>
      	<svg class="arrow arrow-left" width="10" height="14" viewBox="0 0 10 14" xmlns="http://www.w3.org/2000/svg">
			<path d="M10 9.53674e-07L10 14L-3.41715e-07 7L10 9.53674e-07Z" />
		</svg>
      	<svg class="arrow arrow-right" width="10" height="14" viewBox="0 0 10 14"  xmlns="http://www.w3.org/2000/svg">
			<path d="M0 14V0L10 7L0 14Z" />
		</svg>
    </div>
</div>
	<div class="search-style-fullscreen">
    	<div class="search_form_wrap">
    		<span class="search-close"></span>
        	<form role="search" method="get" action="/" class="search-form">
	<input type="search" class="search-field" placeholder="Search..." value="" name="s" title="Search for:" />
	<button type="submit" class="search-submit" title="Search">SEARCH<i class="ci-magnifying-glass"></i></button>
</form>
        </div>
    </div><!-- /.search-style-fullscreen -->
	
    <div id="page" class="clearfix  default" 
    	 data-preloader="{{ $A }}assets/uploads/sswf/logo-mark.png" data-preclass="shining">
    		    	@include('partials.header')
<!-- /#site-header-wrap -->
		
		
        <!-- Main Content -->
        @yield('content')
<!-- /.main-content -->
						@include('partials.footer')

			
		
<div id="scroll-top"></div>	</div><!-- /#page -->
</div><!-- /#wrapper -->


@yield('scripts')
@include('partials.side-enquiry')
<script src="{{ $A }}js/sswf-modern.js?v=4" defer></script>
</body>
</html>
