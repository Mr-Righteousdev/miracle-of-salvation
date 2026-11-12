<?php

use App\Models\Stream;

test('the sermons archive lists past streams but not live ones', function () {
    $past = Stream::factory()->past()->create(['title' => 'Easter Sunday Sermon']);
    $live = Stream::factory()->create(['title' => 'Live Midweek Service']);

    $this->get(route('livestream.sermons'))
        ->assertOk()
        ->assertSee('Easter Sunday Sermon')
        ->assertSee($past->thumbnailUrl())
        ->assertDontSee('Live Midweek Service');
});

test('the sermons archive shows an empty state without past streams', function () {
    $this->get(route('livestream.sermons'))
        ->assertOk()
        ->assertSee('No past sermons yet.');
});
