@extends('layouts.app')

@section('bodyclass','no-sidebar site-layout-full-width is-page footer-no-widget elementor-default elementor-kit-7 vv-page-service ss-service-individual-counselling')

@section('head')
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
@include('partials.seo', ['seoKey' => 'individual-counselling', 'seoDefaults' => [
    'title' => 'Individual Counselling in Madurai | Soil Sons Welfare Foundation',
    'description' => 'Private one-to-one counselling in Madurai — a safe, confidential space to heal emotionally and build healthy coping skills at Soil Sons Welfare Foundation.',
    'image' => 'assets/uploads/sswf/service-counselling.jpg',
    'path' => '/individual-counselling',
], 'seoBreadcrumbs' => [['Home', '/'], ['Services', '/services'], ['Individual Counselling', '/individual-counselling']]])
@include('partials.theme-head')
@endsection

@section('content')
@include('partials.service-page', [
    'slug'       => 'individual-counselling',
    'title'      => 'Individual Counselling',
    'icon'       => 'fa-comments',
    'image'      => 'assets/uploads/sswf/service-counselling.jpg',
    'heroImage'  => 'assets/uploads/sswf/page-counselling.jpg',
    'tagline'    => 'Private one-to-one sessions in a safe, confidential space — to understand yourself and find the strength to move forward.',
    'heading'    => 'A safe space to be <em>heard, understood</em> and helped',
    'intro'      => ['Individual counselling is a vital step in understanding oneself and finding the strength to overcome life’s challenges. Our counselling sessions offer a safe, confidential, and supportive space where individuals can express their thoughts, emotions, and struggles freely.', 'Through one-on-one sessions with trained professionals, we help individuals identify the root causes of their stress, addiction, or behavioral issues. Each session is tailored to their unique needs, focusing on emotional healing, personal growth, and building healthy coping mechanisms.'],
    'highlights' => ['Completely confidential', 'Trained, caring counsellors', 'Sessions tailored to you', 'Stress, addiction & behaviour'],
    'includes'   => [['fa-user-shield', 'Confidential sessions', 'A private, judgement-free space where you can speak freely.'], ['fa-magnifying-glass', 'Root-cause work', 'Gently uncover what drives stress, addiction or difficult behaviour.'], ['fa-heart-pulse', 'Emotional healing', 'Process grief, anger, anxiety and trauma at your own pace.'], ['fa-shield-heart', 'Coping skills', 'Healthy, practical tools for cravings, triggers and daily pressures.'], ['fa-seedling', 'Personal growth', 'Rebuild self-esteem, motivation and a clear sense of direction.'], ['fa-people-roof', 'Family guidance', 'Optional sessions that help loved ones support your progress.']],
    'steps'      => [['First conversation', 'Share what you are going through — in complete confidence.'], ['Understanding', 'Together we explore the causes and set clear goals.'], ['Working through', 'Regular sessions to heal, practise skills and grow.'], ['Moving forward', 'Review progress and plan ongoing support as needed.']],
])
@endsection

@section('scripts')
@include('partials.theme-scripts')
@endsection
