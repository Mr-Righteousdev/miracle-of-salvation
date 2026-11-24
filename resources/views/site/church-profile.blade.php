@extends('layouts.site')

@section('title', 'Church Profile')

@section('content')
@include('site.partials.page-hero', ['heading' => 'Church Profile', 'intro' => 'Who we are, where we come from and what we believe.'])

<section class="welcome-section">
    <div class="container welcome-grid">
        <div class="welcome-text">
            <span class="section-tag">OUR STORY</span>
            <h2>{{ $settings['church_name'] }}</h2>

            @if ($settings['church_history'])
                @include('site.partials.paragraphs', ['text' => $settings['church_history']])
            @else
                <p>
                    {{ $settings['church_name'] }} is a Christian ministry
                    dedicated to advancing the Kingdom of God and
                    proclaiming the Gospel of Jesus Christ to all people.
                </p>
            @endif
        </div>

        <div class="welcome-highlight">
            <div class="highlight-symbol">✝</div>
            @if ($settings['church_founded'] || $settings['church_founder'])
                <span>OUR BEGINNING</span>
                @if ($settings['church_founded'])
                    <h3>Founded {{ $settings['church_founded'] }}</h3>
                @endif
                @if ($settings['church_founder'])
                    <p>by {{ $settings['church_founder'] }}</p>
                @endif
            @else
                <span>OUR FOUNDATION</span>
                <h3>Jesus Christ and His Saving Grace</h3>
            @endif
            <strong>ACTS 4:12</strong>
        </div>
    </div>
</section>

@include('site.partials.mission-vision-values')
@endsection
