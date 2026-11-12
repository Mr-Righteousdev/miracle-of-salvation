@extends('layouts.site')

@section('title', $category->label())

@section('content')
@include('site.partials.page-hero', ['heading' => $category->label(), 'intro' => 'Upcoming '.strtolower($category->label()).' at Miracle of Salvation Church.'])

<div class="page-section">
    <div class="container">
        @include('site.partials.event-categories')

        @forelse ($events as $event)
            @include('site.partials.event-row')
        @empty
            <p class="empty-state">No upcoming {{ strtolower($category->label()) }} yet. Please check back soon.</p>
        @endforelse
    </div>
</div>
@endsection
