<?php

use App\Filament\Resources\GalleryImages\GalleryImageResource;
use App\Filament\Resources\GalleryImages\Pages\CreateGalleryImage;
use App\Models\GalleryImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('super admins can view the gallery list', function () {
    $this->actingAs(superAdminUser())
        ->get(GalleryImageResource::getUrl())
        ->assertOk();
});

test('super admins can upload a gallery image', function () {
    Storage::fake('public');

    Livewire::actingAs(superAdminUser())
        ->test(CreateGalleryImage::class)
        ->fillForm([
            'image' => UploadedFile::fake()->image('choir.jpg'),
            'caption' => 'Choir rehearsal',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $image = GalleryImage::query()->sole();

    expect($image->caption)->toBe('Choir rehearsal')
        ->and($image->image)->toStartWith('gallery/');
    Storage::disk('public')->assertExists($image->image);
});

test('a gallery image requires a file', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateGalleryImage::class)
        ->fillForm(['caption' => 'No file'])
        ->call('create')
        ->assertHasFormErrors(['image' => 'required']);
});
