<?php

use App\Models\GalleryImage;

test('the gallery shows only published images', function () {
    GalleryImage::factory()->create(['caption' => 'Youth camp 2026']);
    GalleryImage::factory()->unpublished()->create(['caption' => 'Draft photo']);
    GalleryImage::factory()->create(['caption' => 'Future photo', 'published_at' => now()->addWeek()]);

    $this->get(route('ministries.gallery'))
        ->assertOk()
        ->assertSee('Youth camp 2026')
        ->assertDontSee('Draft photo')
        ->assertDontSee('Future photo');
});

test('published images are ordered by sort order', function () {
    $second = GalleryImage::factory()->create(['sort_order' => 2]);
    $first = GalleryImage::factory()->create(['sort_order' => 1]);

    expect(GalleryImage::published()->pluck('id')->all())->toBe([$first->id, $second->id]);
});
