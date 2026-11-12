<div class="event-row">
    <div class="event-date-badge">
        <span class="month">{{ $event->starts_at->format('M') }}</span>
        <span class="day">{{ $event->starts_at->format('j') }}</span>
    </div>
    <div class="event-body">
        <span class="event-category">{{ $event->category->label() }}</span>
        <h3>{{ $event->title }}</h3>
        <p class="event-meta">
            <span>{{ $event->starts_at->format('l, F j, Y \a\t g:i A') }}</span>
            @if ($event->location)
                <span>&middot; {{ $event->location }}</span>
            @endif
        </p>
        <p>{{ $event->description }}</p>
        <div class="event-actions">
            <a href="{{ $event->googleCalendarUrl() }}" target="_blank" rel="noopener" class="btn btn-light">Add to Google Calendar</a>
            <a href="{{ $event->reminderUrl() }}" class="btn btn-light">Set Reminder</a>
        </div>
    </div>
</div>
