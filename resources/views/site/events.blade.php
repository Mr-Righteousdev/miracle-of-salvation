@extends('layouts.site')

@section('title', 'Upcoming Events')

@section('content')
@include('site.partials.page-hero', ['heading' => 'Upcoming Events', 'intro' => 'Church services, programs, outreach and missions. Plan to join us at our next gathering.'])

<div class="page-section">
    <div class="container">
        @include('site.partials.event-categories')

        <div class="calendar">
            <div class="calendar-head">
                <div class="calendar-nav">
                    <a href="{{ route('events', ['month' => $prevMonth]) }}" aria-label="Previous month">&lsaquo;</a>
                </div>
                <h2>{{ $month->format('F Y') }}</h2>
                <div class="calendar-nav">
                    <a href="{{ route('events', ['month' => $nextMonth]) }}" aria-label="Next month">&rsaquo;</a>
                </div>
            </div>

            <div class="calendar-dow">
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <span>{{ $day }}</span>
                @endforeach
            </div>

            @foreach ($weeks as $week)
                <div class="calendar-week">
                    @foreach ($week as $day)
                        <div class="calendar-day {{ $day['inMonth'] ? '' : 'is-outside' }} {{ $day['today'] ? 'is-today' : '' }}">
                            <span class="calendar-daynum">{{ $day['date']->format('j') }}</span>
                            <div class="calendar-events">
                                @foreach ($day['events'] as $event)
                                    <span class="calendar-event" title="{{ $event->title }}">
                                        <strong>{{ $event->starts_at->format('g:i A') }}</strong> {{ $event->title }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="page-section">
    <div class="container">
        <div class="section-header">
            <h2>All upcoming events</h2>
        </div>

        @forelse ($upcomingEvents as $event)
            @include('site.partials.event-row')
        @empty
            <p class="empty-state">No upcoming events.</p>
        @endforelse
    </div>
</div>
@endsection
