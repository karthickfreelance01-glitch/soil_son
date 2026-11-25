@extends('layouts.app')

@section('bodyclass', 'no-sidebar site-layout-full-width is-page footer-no-widget elementor-default elementor-kit-7')

@section('head')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow">
<title>Page not found | Soil Sons Welfare Foundation</title>
<link rel="stylesheet" href="{{ $A }}assets/themes/tombuild/style.css">
<link rel="stylesheet" href="{{ $A }}assets/plugins/elementor/assets/css/frontend.min.css">
<link rel="stylesheet" href="{{ $A }}assets/uploads/elementor/css/post-7.css">
@endsection

@section('content')
<div id="main-content" class="site-main clearfix">
    <div id="content-wrap" class="tombuild-container">
        <div id="site-content" class="site-content clearfix">
            <div id="inner-content" class="inner-content-wrap">
                <div style="padding:120px 20px;text-align:center;">
                    <h1 style="font-size:64px;margin:0 0 10px;">404</h1>
                    <h2 style="margin:0 0 20px;">We couldn't find that page</h2>
                    <p style="margin:0 0 30px;">The page you were looking for has moved or no longer exists.</p>
                    <a href="/" class="elementor-button" style="display:inline-block;padding:14px 32px;background:#2f47e0;color:#fff;border-radius:4px;text-decoration:none;">Back to Home</a>
                    <a href="/contact" style="display:inline-block;padding:14px 32px;margin-left:10px;border:1px solid #2f47e0;color:#2f47e0;border-radius:4px;text-decoration:none;">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
