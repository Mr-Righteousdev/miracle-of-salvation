@extends('layouts.site')

@section('title', 'Leadership')

@section('content')
@include('site.partials.page-hero', ['heading' => 'Our Leadership', 'intro' => 'The servants God has placed to shepherd His church.'])

<div class="page-section">
    <div class="container">
        @if ($leaders->isNotEmpty())
            <div class="media-grid">
                @foreach ($leaders as $leader)
                    <article class="card media-card leader-card">
                        @if ($leader->photo)
                            <img src="{{ asset('storage/'.$leader->photo) }}" alt="{{ $leader->name }}" loading="lazy">
                        @endif
                        <div class="media-card-body">
                            <h3>{{ $leader->name }}</h3>
                            <p class="leader-role">{{ $leader->role }}</p>
                            @if ($leader->bio)
                                <p>{{ $leader->bio }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="empty-state">Leadership profiles are coming soon.</p>
        @endif
    </div>
</div>
@endsection
