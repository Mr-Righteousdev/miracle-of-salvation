@extends('layouts.site')

@section('title', 'Our Branches')

@section('content')
<div class="wip-banner">🚧 Branch activities — page not yet done (dev note)</div>

<section class="branches-section">
    <div class="container">
        <div class="branches-grid">
            @foreach (config('church.branches') as $branch)
                <article class="branch-card" id="{{ $branch['slug'] }}">
                    <div class="branch-card-top">
                        <span class="branch-label">CHURCH BRANCH</span>
                        <span class="branch-cross">✝</span>
                    </div>

                    <div class="branch-card-content">
                        <h3>{{ $branch['name'] }}</h3>
                        <p class="branch-location">{{ $branch['location'] }}</p>
                        <p>{{ $branch['description'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
