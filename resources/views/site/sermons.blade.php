@extends('layouts.site')

@section('title', 'Sermons Archive')

@section('content')
@include('site.partials.page-hero', ['heading' => 'Sermons Archive', 'intro' => 'Catch up on past services and messages.'])

<div class="page-section">
    <div class="container">
        @if ($streams->isNotEmpty())
            <div class="media-grid">
                @foreach ($streams as $stream)
                    <a href="{{ $stream->youtube_url }}" target="_blank" rel="noopener" class="card media-card">
                        <img src="{{ $stream->thumbnailUrl() }}" alt="{{ $stream->title }}" loading="lazy">
                        <div class="media-card-body">
                            <h3>{{ $stream->title }}</h3>
                            @if ($stream->starts_at)
                                <p>{{ $stream->starts_at->format('F j, Y') }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{ $streams->links('site.partials.pagination') }}
        @else
            <p class="empty-state">No past sermons yet.</p>
        @endif
    </div>
</div>
@endsection
