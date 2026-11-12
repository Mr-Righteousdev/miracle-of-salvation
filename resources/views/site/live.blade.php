@extends('layouts.site')

@section('title', 'Watch Live')

@section('content')
@include('site.partials.page-hero', ['heading' => 'Watch Live', 'intro' => 'Worship with us online and join the conversation.'])

<div class="page-section">
    <div class="container">
        @if ($stream)
            <div class="card stream-card">
                <div class="player-frame">
                    <iframe
                        src="{{ $stream->embedUrl() }}"
                        title="{{ $stream->title }}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                    ></iframe>
                </div>

                <div class="stream-meta">
                    @if ($stream->status === \App\Enums\StreamStatus::Live)
                        <span class="badge-live"><span class="pulse"></span> Live now</span>
                    @else
                        <span class="badge-past">Past service</span>
                    @endif
                    @if ($stream->starts_at)
                        <span>{{ $stream->starts_at->format('l, F j, Y \a\t g:i A') }}</span>
                    @endif
                </div>

                <h2 class="stream-title">{{ $stream->title }}</h2>

                <livewire:stream-interactions :stream="$stream" />
            </div>
        @else
            <p class="empty-state">
                <strong>No stream yet.</strong>
                Check back soon — our next service will appear here.
            </p>
        @endif
    </div>
</div>
@endsection
