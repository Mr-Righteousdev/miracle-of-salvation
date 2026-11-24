@extends('layouts.site')

@section('title', 'Vision Bearer')

@section('content')
@include('site.partials.page-hero', [
    'heading' => $settings['vision_bearer_name'] ?? 'Our Vision Bearer',
    'intro' => $settings['vision_bearer_title'],
])

<section class="welcome-section">
    <div class="container welcome-grid">
        <div class="welcome-text">
            <span class="section-tag">THE VISION BEARER</span>

            @if ($settings['vision_bearer_bio'])
                @include('site.partials.paragraphs', ['text' => $settings['vision_bearer_bio']])
            @else
                <p class="empty-state">The Vision Bearer's story is coming soon.</p>
            @endif
        </div>

        <div class="welcome-highlight">
            @if ($settings['vision_bearer_photo'])
                <img class="vision-bearer-photo" src="{{ asset('storage/'.$settings['vision_bearer_photo']) }}" alt="{{ $settings['vision_bearer_name'] ?? 'Vision Bearer' }}">
            @else
                <div class="highlight-symbol">✝</div>
            @endif

            @if ($settings['vision_bearer_quote'])
                <h3>"{{ $settings['vision_bearer_quote'] }}"</h3>
                @if ($settings['vision_bearer_quote_reference'])
                    <strong>{{ str($settings['vision_bearer_quote_reference'])->upper() }}</strong>
                @endif
            @endif
        </div>
    </div>
</section>
@endsection
