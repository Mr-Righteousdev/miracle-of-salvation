@extends('layouts.site')

@section('title', $ministry->name)

@section('content')
@include('site.partials.page-hero', ['heading' => $ministry->name, 'intro' => $ministry->summary])

<div class="page-section">
    <div class="container ministry-page">
        @if ($ministry->image)
            <img class="ministry-cover" src="{{ asset('storage/'.$ministry->image) }}" alt="{{ $ministry->name }}">
        @endif

        @if ($ministry->leader || $ministry->meeting_time)
            <ul class="branch-details">
                @if ($ministry->leader)
                    <li><strong>Leader:</strong> {{ $ministry->leader }}</li>
                @endif
                @if ($ministry->meeting_time)
                    <li><strong>We meet:</strong> {{ $ministry->meeting_time }}</li>
                @endif
            </ul>
        @endif

        @if ($ministry->description)
            @foreach (preg_split('/\R{2,}/', trim($ministry->description)) as $paragraph)
                <p>{!! nl2br(e($paragraph)) !!}</p>
            @endforeach
        @else
            <p class="empty-state">More about this ministry is coming soon.</p>
        @endif
    </div>
</div>
@endsection
