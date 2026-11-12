<?php

use App\Enums\EventCategory;
use App\Models\Event;

test('each category page only shows upcoming events in that category', function (EventCategory $category) {
    $inCategory = Event::factory()->category($category)->create();
    $otherCategory = collect(EventCategory::cases())->first(fn (EventCategory $case): bool => $case !== $category);
    $elsewhere = Event::factory()->category($otherCategory)->create();
    $past = Event::factory()->category($category)->past()->create();

    $this->get(route($category->routeName()))
        ->assertOk()
        ->assertSee($inCategory->title)
        ->assertDontSee($elsewhere->title)
        ->assertDontSee($past->title);
})->with(EventCategory::cases());

test('the upcoming events page shows events from every category', function () {
    $outreach = Event::factory()->category(EventCategory::CommunityOutreach)->create();
    $mission = Event::factory()->category(EventCategory::Mission)->create();

    $this->get(route('events'))
        ->assertOk()
        ->assertSee($outreach->title)
        ->assertSee($mission->title);
});

test('events default to the church program category', function () {
    $event = Event::query()->create([
        'title' => 'Sunday Service',
        'description' => 'Worship.',
        'starts_at' => now()->addDay(),
    ]);

    expect($event->refresh()->category)->toBe(EventCategory::ChurchProgram);
});
