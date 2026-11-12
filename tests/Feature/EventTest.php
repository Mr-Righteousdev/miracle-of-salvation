<?php

use App\Models\Event;
use Illuminate\Support\Carbon;

test('the events page is rendered', function () {
    $this->get('/events')->assertOk();
});

test('upcoming events are shown on the events page', function () {
    $event = Event::factory()->create(['starts_at' => now()->addWeek()]);

    $this->get('/events')
        ->assertOk()
        ->assertSee($event->title)
        ->assertSee($event->description);
});

test('past events are not shown on the events page', function () {
    $event = Event::factory()->past()->create();

    $this->get('/events')
        ->assertOk()
        ->assertDontSee($event->title);
});

test('events in the selected calendar month are shown', function () {
    $nextMonth = now()->addMonth();
    $event = Event::factory()->create([
        'starts_at' => $nextMonth->startOfMonth()->addDays(5)->addHours(10),
    ]);

    $this->get(route('events', ['month' => $nextMonth->format('Y-m')]))
        ->assertOk()
        ->assertSee($event->title);
});

test('upcoming scope orders events by start date ascending', function () {
    $later = Event::factory()->create(['starts_at' => now()->addDays(5)]);
    $sooner = Event::factory()->create(['starts_at' => now()->addDay()]);

    expect(Event::upcoming()->pluck('id')->all())->toBe([$sooner->id, $later->id]);
});

test('google calendar url pre-fills the event details', function () {
    $event = Event::factory()->create([
        'title' => 'Sunday Service',
        'description' => 'Worship and teaching.',
        'location' => 'Church Hall',
        'starts_at' => Carbon::parse('2026-09-15 10:00:00'),
    ]);

    parse_str(parse_url($event->googleCalendarUrl(), PHP_URL_QUERY), $params);

    expect($params['action'])->toBe('TEMPLATE')
        ->and($params['text'])->toBe('Sunday Service')
        ->and($params['details'])->toBe('Worship and teaching.')
        ->and($params['location'])->toBe('Church Hall')
        ->and($params['dates'])->toContain('20260915T');
});

test('reminder url pre-fills a mailto link for the event', function () {
    $event = Event::factory()->create(['title' => 'Wednesday Fellowship']);

    parse_str(parse_url($event->reminderUrl(), PHP_URL_QUERY), $params);

    expect($event->reminderUrl())->toStartWith('mailto:?')
        ->and($params['subject'])->toBe('Reminder: Wednesday Fellowship')
        ->and($params['body'])->toContain('Wednesday Fellowship');
});
