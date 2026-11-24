@extends('layouts.site')

@section('title', 'Videos')

@section('content')
@include('site.partials.page-hero', ['heading' => 'Videos', 'intro' => 'Ministry moments, outreaches and church life across our branches.'])

<div class="page-section">
    <div class="container">
        @if ($videos->isNotEmpty())
            <div class="media-grid">
                @foreach ($videos as $video)
                    <a href="{{ $video->youtube_url }}" target="_blank" rel="noopener" class="card media-card">
                        <img src="{{ $video->thumbnailUrl() }}" alt="{{ $video->title }}" loading="lazy">
                        <div class="media-card-body">
                            <h3>{{ $video->title }}</h3>
                            @if ($video->description)
                                <p>{{ $video->description }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            {{ $videos->links('site.partials.pagination') }}
        @else
            <p class="empty-state">No videos yet. For past services, see the <a href="{{ route('livestream.sermons') }}">sermons archive</a>.</p>
        @endif
    </div>
</div>
@endsection
