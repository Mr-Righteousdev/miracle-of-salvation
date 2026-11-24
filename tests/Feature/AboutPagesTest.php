<?php

use App\Filament\Pages\AboutPages;
use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('the about pages render with placeholders before any content is entered', function () {
    $this->get(route('about.vision-bearer'))
        ->assertOk()
        ->assertSee('Our Vision Bearer')
        ->assertSee('story is coming soon');

    $this->get(route('about.church-profile'))
        ->assertOk()
        ->assertSee('Our Mission')
        ->assertSee('Our Core Values');
});

test('the home page still shows the mission, vision and core values', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Our Mission')
        ->assertSee('Our Vision')
        ->assertSee('Authority of the Holy Scriptures');
});

test('super admins can open the about pages editor', function () {
    $this->actingAs(superAdminUser())
        ->get(AboutPages::getUrl())
        ->assertOk();
});

test('saved about content appears on the public pages', function () {
    Storage::fake('public');

    Livewire::actingAs(superAdminUser())
        ->test(AboutPages::class)
        ->fillForm([
            'vision_bearer_name' => 'Apostle John Kahindo',
            'vision_bearer_title' => 'Founder & Senior Pastor',
            'vision_bearer_photo' => UploadedFile::fake()->image('apostle.jpg'),
            'vision_bearer_bio' => "Called in 1998.\n\nPlanted six branches.",
            'vision_bearer_quote' => 'Go ye into all the world',
            'vision_bearer_quote_reference' => 'Mark 16:15',
            'church_founded' => '2001',
            'church_history' => 'It began with a prayer meeting.',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $photo = Setting::get('vision_bearer_photo');
    expect($photo)->toStartWith('about/');
    Storage::disk('public')->assertExists($photo);

    $this->get(route('about.vision-bearer'))
        ->assertSee('Apostle John Kahindo')
        ->assertSee('Founder &amp; Senior Pastor', false)
        ->assertSee('<p>Planted six branches.</p>', false)
        ->assertSee('MARK 16:15')
        ->assertSee('storage/'.$photo);

    $this->get(route('about.church-profile'))
        ->assertSee('Founded 2001')
        ->assertSee('It began with a prayer meeting.');
});
