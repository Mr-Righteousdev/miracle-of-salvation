<?php

use App\Livewire\StreamInteractions;
use App\Models\Stream;
use App\Models\StreamComment;
use Livewire\Livewire;

test('the live stream page is rendered', function () {
    $this->get('/live')->assertOk();
});

test('the live stream page shows the current stream player', function () {
    $stream = Stream::factory()->create(['title' => 'Sunday Worship']);

    $this->get('/live')
        ->assertOk()
        ->assertSee('Sunday Worship')
        ->assertSee('youtube.com/embed/'.$stream->video_id);
});

test('the live stream page shows the empty state when no streams exist', function () {
    $this->get('/live')
        ->assertOk()
        ->assertSee('No stream yet');
});

test('current stream prefers a live stream over a past one', function () {
    Stream::factory()->past()->create();
    $live = Stream::factory()->create();

    expect(Stream::current()->id)->toBe($live->id);
});

test('current stream falls back to the most recent past stream', function () {
    Stream::factory()->past()->create(['starts_at' => now()->subDays(5)]);
    $recent = Stream::factory()->past()->create(['starts_at' => now()->subDays(1)]);

    expect(Stream::current()->id)->toBe($recent->id);
});

test('only approved comments are shown on the live stream page', function () {
    $stream = Stream::factory()->create();
    StreamComment::factory()->create(['stream_id' => $stream->id, 'message' => 'Approved message']);
    StreamComment::factory()->unapproved()->create(['stream_id' => $stream->id, 'message' => 'Hidden message']);

    $this->get('/live')
        ->assertOk()
        ->assertSee('Approved message')
        ->assertDontSee('Hidden message');
});

test('the comment form is hidden when comments are disabled', function () {
    $stream = Stream::factory()->commentsDisabled()->create();

    $this->get('/live')
        ->assertOk()
        ->assertDontSee('Leave a comment')
        ->assertDontSee('Submit comment');
});

test('existing comments are hidden when comments are not visible', function () {
    $stream = Stream::factory()->commentsHidden()->create();
    StreamComment::factory()->create(['stream_id' => $stream->id, 'message' => 'Approved message']);

    $this->get('/live')
        ->assertOk()
        ->assertDontSee('Approved message');
});

test('the comments are turned off notice shows when both toggles are off', function () {
    $stream = Stream::factory()->commentsDisabled()->commentsHidden()->create();

    $this->get('/live')
        ->assertOk()
        ->assertSee('Comments are turned off for this stream.');
});

test('comment submissions are ignored when comments are disabled', function () {
    $stream = Stream::factory()->commentsDisabled()->create();

    Livewire::test(StreamInteractions::class, ['stream' => $stream])
        ->set('message', 'Sneaky comment')
        ->call('addComment')
        ->assertHasNoErrors();

    expect($stream->comments()->count())->toBe(0);
});

test('visitors can like a stream', function () {
    $stream = Stream::factory()->create();

    Livewire::test(StreamInteractions::class, ['stream' => $stream])
        ->call('toggleLike')
        ->assertSet('liked', true);

    expect($stream->likes()->count())->toBe(1);
});

test('liking a stream twice removes the like', function () {
    $stream = Stream::factory()->create();

    Livewire::test(StreamInteractions::class, ['stream' => $stream])
        ->call('toggleLike')
        ->call('toggleLike')
        ->assertSet('liked', false);

    expect($stream->likes()->count())->toBe(0);
});

test('a submitted comment is stored for moderation', function () {
    $stream = Stream::factory()->create();

    Livewire::test(StreamInteractions::class, ['stream' => $stream])
        ->set('message', 'Great service!')
        ->call('addComment')
        ->assertHasNoErrors();

    expect($stream->comments()->count())->toBe(1);
    expect($stream->comments()->first()->is_approved)->toBeFalse();
});

test('the comment name is optional', function () {
    $stream = Stream::factory()->create();

    Livewire::test(StreamInteractions::class, ['stream' => $stream])
        ->set('message', 'No name here')
        ->call('addComment')
        ->assertHasNoErrors();

    expect($stream->comments()->first()->name)->toBeNull();
});

test('a comment requires a message', function () {
    $stream = Stream::factory()->create();

    Livewire::test(StreamInteractions::class, ['stream' => $stream])
        ->call('addComment')
        ->assertHasErrors(['message']);
});

test('extractVideoId handles supported youtube url formats', function (string $url, string $id) {
    expect(Stream::extractVideoId($url))->toBe($id);
})->with([
    'watch' => ['https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'dQw4w9WgXcQ'],
    'watch with query' => ['https://www.youtube.com/watch?v=dQw4w9WgXcQ&t=30s', 'dQw4w9WgXcQ'],
    'short link' => ['https://youtu.be/dQw4w9WgXcQ', 'dQw4w9WgXcQ'],
    'embed' => ['https://www.youtube.com/embed/dQw4w9WgXcQ', 'dQw4w9WgXcQ'],
    'live' => ['https://www.youtube.com/live/dQw4w9WgXcQ', 'dQw4w9WgXcQ'],
    'shorts' => ['https://www.youtube.com/shorts/dQw4w9WgXcQ', 'dQw4w9WgXcQ'],
]);

test('extractVideoId returns null for unsupported urls', function (string $url) {
    expect(Stream::extractVideoId($url))->toBeNull();
})->with([
    'missing id' => ['https://www.youtube.com/watch?v='],
    'not youtube' => ['https://example.com/watch?v=dQw4w9WgXcQ'],
    'not a url' => ['not a url'],
]);
