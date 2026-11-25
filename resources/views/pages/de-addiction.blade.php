@extends('layouts.app')

@section('bodyclass','no-sidebar site-layout-full-width is-page footer-no-widget elementor-default elementor-kit-7 vv-page-service ss-service-de-addiction')

@section('head')
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
@include('partials.seo', ['seoKey' => 'de-addiction', 'seoDefaults' => [
    'title' => 'De-Addiction Centre in Madurai | Soil Sons Welfare Foundation',
    'description' => 'Medically supervised de-addiction in Madurai — detox, counselling, behavioural therapy and family support at Soil Sons Welfare Foundation, Sellur.',
    'image' => 'assets/uploads/sswf/service-de-addiction.jpg',
    'path' => '/de-addiction',
], 'seoBreadcrumbs' => [['Home', '/'], ['Services', '/services'], ['De-Addiction', '/de-addiction']]])
@include('partials.theme-head')
@endsection

@section('content')
@include('partials.service-page', [
    'slug'       => 'de-addiction',
    'title'      => 'De-Addiction',
    'icon'       => 'fa-hand-holding-heart',
    'image'      => 'assets/uploads/sswf/service-de-addiction.jpg',
    'heroImage'  => 'assets/uploads/sswf/page-de-addiction.jpg',
    'tagline'    => 'Medically supervised detox and a structured programme to break free from alcohol and drug dependence — with dignity.',
    'heading'    => 'Recovery is not just quitting — it is <em>rebuilding a life</em>',
    'intro'      => ['Addiction can take control of one’s life—impacting health, relationships, and self-worth. At our de-addiction centre, we believe that recovery is not just about quitting a habit, but about rebuilding a life filled with purpose, balance, and dignity.', 'Our comprehensive de-addiction program focuses on holistic healing—addressing physical dependence, emotional trauma, and mental well-being. Through personalized counselling, medical support, behavioral therapy, and peer group sessions, we help individuals break free from the cycle of addiction and rediscover their inner strength.'],
    'highlights' => ['Alcohol & drug de-addiction', 'Safe, supervised detox', 'Personalised therapy plan', 'Family counselling & aftercare'],
    'includes'   => [['fa-kit-medical', 'Medical detox', 'Safe, doctor-supervised withdrawal management with round-the-clock monitoring.'], ['fa-comments', 'Personal counselling', 'One-to-one sessions to understand triggers and build lasting coping skills.'], ['fa-brain', 'Behavioural therapy', 'Practical CBT-based tools to change thought and habit patterns.'], ['fa-people-group', 'Peer group sessions', 'Shared experiences that build hope, accountability and belonging.'], ['fa-spa', 'Yoga & meditation', 'Daily routine, yoga and mindfulness to restore calm and focus.'], ['fa-house-chimney-user', 'Family support', 'Guidance for families to heal together and prevent relapse.']],
    'steps'      => [['Assessment', 'A confidential medical and psychological evaluation to understand your needs.'], ['Detox', 'Supervised detoxification to safely clear the body of substances.'], ['Therapy', 'Counselling, group work and wellness activities to heal the mind.'], ['Aftercare', 'Follow-ups and relapse-prevention support once you return home.']],
])
@endsection

@section('scripts')
@include('partials.theme-scripts')
@endsection
