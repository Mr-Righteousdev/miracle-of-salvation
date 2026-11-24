@extends('layouts.site')

@section('title', 'Our Branches')

@section('content')
<div class="wip-banner">🚧 Branch activities — page not yet done (dev note)</div>

<section class="branches-section">
    <div class="container">
        <div class="branches-grid">
            @foreach ($branches as $branch)
                <article class="branch-card" id="{{ $branch->slug }}">
                    @if ($branch->image)
                        <img class="branch-photo" src="{{ asset('storage/'.$branch->image) }}" alt="{{ $branch->name }}" loading="lazy">
                    @else
                        <div class="branch-card-top">
                            <span class="branch-label">CHURCH BRANCH</span>
                            <span class="branch-cross">✝</span>
                        </div>
                    @endif

                    <div class="branch-card-content">
                        <h3>{{ $branch->name }}</h3>
                        <p class="branch-location">{{ $branch->location }}</p>
                        <p>{{ $branch->description }}</p>

                        @if ($branch->pastor || $branch->service_times || $branch->phone)
                            <ul class="branch-details">
                                @if ($branch->pastor)
                                    <li><strong>Pastor:</strong> {{ $branch->pastor }}</li>
                                @endif
                                @if ($branch->service_times)
                                    <li><strong>Services:</strong> {{ $branch->service_times }}</li>
                                @endif
                                @if ($branch->phone)
                                    <li><strong>Phone:</strong> <a href="tel:{{ $branch->phone }}">{{ $branch->phone }}</a></li>
                                @endif
                            </ul>
                        @endif

                        @if ($branch->map_url)
                            <a href="{{ $branch->map_url }}" class="branch-link" target="_blank" rel="noopener">GET DIRECTIONS →</a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
