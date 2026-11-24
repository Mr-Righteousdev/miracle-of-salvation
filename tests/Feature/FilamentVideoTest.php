<?php

use App\Filament\Resources\Videos\Pages\CreateVideo;
use App\Filament\Resources\Videos\VideoResource;
use App\Models\Video;
use Livewire\Livewire;

test('super admins can view the videos list', function () {
    $this->actingAs(superAdminUser())
        ->get(VideoResource::getUrl())
        ->assertOk();
});

test('super admins can add a video and it appears on the videos page', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateVideo::class)
        ->fillForm([
            'title' => 'Kagadi Outreach 2026',
            'youtube_url' => 'https://youtu.be/dQw4w9WgXcQ',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Video::query()->sole()->video_id)->toBe('dQw4w9WgXcQ');

    $this->get(route('livestream.videos'))
        ->assertOk()
        ->assertSee('Kagadi Outreach 2026')
        ->assertSee('img.youtube.com/vi/dQw4w9WgXcQ');
});

test('a video needs a real YouTube link', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateVideo::class)
        ->fillForm(['title' => 'Bad link', 'youtube_url' => 'https://example.com/video'])
        ->call('create')
        ->assertHasFormErrors(['youtube_url']);
});

test('unpublished videos are hidden', function () {
    Video::factory()->unpublished()->create(['title' => 'Draft Video']);

    $this->get(route('livestream.videos'))
        ->assertOk()
        ->assertDontSee('Draft Video')
        ->assertSee('No videos yet');
});
