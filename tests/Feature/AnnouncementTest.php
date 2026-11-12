<?php

use App\Models\Announcement;

test('the announcements page is rendered', function () {
    $this->get('/announcements')->assertOk();
});

test('published announcements are shown on the announcements page', function () {
    $announcement = Announcement::factory()->create(['published_at' => now()->subDay()]);

    $this->get('/announcements')
        ->assertOk()
        ->assertSee($announcement->title)
        ->assertSee($announcement->body);
});

test('scheduled announcements are not shown on the announcements page', function () {
    $announcement = Announcement::factory()->scheduled()->create();

    $this->get('/announcements')
        ->assertOk()
        ->assertDontSee($announcement->title);
});

test('unpublished announcements are not shown on the announcements page', function () {
    $announcement = Announcement::factory()->unpublished()->create();

    $this->get('/announcements')
        ->assertOk()
        ->assertDontSee($announcement->title);
});

test('published scope orders announcements by publish date descending', function () {
    $older = Announcement::factory()->create(['published_at' => now()->subDays(2)]);
    $newer = Announcement::factory()->create(['published_at' => now()->subDay()]);

    expect(Announcement::published()->pluck('id')->all())->toBe([$newer->id, $older->id]);
});
