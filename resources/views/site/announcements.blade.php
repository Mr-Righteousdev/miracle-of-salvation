@extends('layouts.site')

@section('title', 'Announcements')

@section('content')
@include('site.partials.page-hero', ['heading' => 'Announcements', 'intro' => 'News and updates from the church.'])

<div class="page-section">
    <div class="container">
        @forelse ($announcements as $announcement)
            <article class="announcement card">
                @if ($announcement->image)
                    <img src="{{ asset('storage/'.$announcement->image) }}" alt="{{ $announcement->title }}">
                @endif
                <p class="announcement-date">{{ $announcement->published_at?->format('F j, Y') }}</p>
                <h3>{{ $announcement->title }}</h3>
                <p>{{ $announcement->body }}</p>
            </article>
        @empty
            <p class="empty-state">No announcements yet.</p>
        @endforelse
    </div>
</div>
@endsection
