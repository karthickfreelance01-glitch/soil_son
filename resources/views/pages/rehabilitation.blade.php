@extends('layouts.app')

@section('bodyclass','no-sidebar site-layout-full-width is-page footer-no-widget elementor-default elementor-kit-7 vv-page-service ss-service-rehabilitation')

@section('head')
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
@include('partials.seo', ['seoKey' => 'rehabilitation', 'seoDefaults' => [
    'title' => 'Rehabilitation Centre in Madurai | Soil Sons Welfare Foundation',
    'description' => 'Residential rehabilitation in Madurai that rebuilds strength, confidence and purpose — medical care, counselling and life-skill training at SSWF.',
    'image' => 'assets/uploads/sswf/service-rehabilitation.jpg',
    'path' => '/rehabilitation',
], 'seoBreadcrumbs' => [['Home', '/'], ['Services', '/services'], ['Rehabilitation', '/rehabilitation']]])
@include('partials.theme-head')
@endsection

@section('content')
@include('partials.service-page', [
    'slug'       => 'rehabilitation',
    'title'      => 'Rehabilitation',
    'icon'       => 'fa-seedling',
    'image'      => 'assets/uploads/sswf/service-rehabilitation.jpg',
    'heroImage'  => 'assets/uploads/sswf/page-rehabilitation.jpg',
    'tagline'    => 'Residential rehabilitation that rebuilds strength, confidence and purpose for a healthy, self-reliant life.',
    'heading'    => 'From dependency to a <em>confident, self-reliant</em> life',
    'intro'      => ['Rehabilitation is more than recovery—it is the process of rebuilding strength, confidence, and purpose after overcoming addiction or personal challenges. Our rehabilitation program is designed to support individuals as they transition from dependency to a healthy, self-reliant, and fulfilling life.', 'We offer a structured environment where medical care, counselling, and life-skill training come together to promote long-term healing. Each program is personalized to meet the unique physical, emotional, and psychological needs of every individual. Through therapy sessions, wellness activities, and community living, we encourage personal growth and social reintegration.'],
    'highlights' => ['Structured residential programme', 'Medical care & counselling', 'Life-skill training', 'Social reintegration support'],
    'includes'   => [['fa-house-medical', 'Residential care', 'A safe, supervised campus with a calm daily routine and 24×7 support.'], ['fa-user-doctor', 'Medical supervision', 'Regular health checks and care from doctors and nursing staff.'], ['fa-comments', 'Therapy sessions', 'Individual and group therapy to address the roots of dependency.'], ['fa-screwdriver-wrench', 'Life-skill training', 'Practical skills, discipline and confidence for life after the programme.'], ['fa-person-running', 'Wellness activities', 'Yoga, exercise, recreation and nutrition that rebuild the body.'], ['fa-handshake-angle', 'Reintegration', 'Step-by-step support to return to family, work and community.']],
    'steps'      => [['Admission', 'A warm welcome, assessment and a personalised recovery plan.'], ['Stabilise', 'Medical care and routine to restore physical and emotional balance.'], ['Rebuild', 'Therapy, life skills and community living to grow confidence.'], ['Return', 'Planned discharge with family guidance and regular follow-ups.']],
])
@endsection

@section('scripts')
@include('partials.theme-scripts')
@endsection
