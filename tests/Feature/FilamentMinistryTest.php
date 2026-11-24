<?php

use App\Filament\Resources\Ministries\MinistryResource;
use App\Filament\Resources\Ministries\Pages\CreateMinistry;
use App\Models\Ministry;
use Livewire\Livewire;

test('the original ministry pages keep their addresses', function (string $path) {
    $this->get($path)->assertOk();
})->with(['/ministries/youth', '/ministries/children', '/ministries/fathers-mothers']);

test('super admins can view the ministries list', function () {
    $this->actingAs(superAdminUser())
        ->get(MinistryResource::getUrl())
        ->assertOk();
});

test('super admins can add a ministry with its own page and menu link', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateMinistry::class)
        ->fillForm([
            'name' => 'Choir Ministry',
            'meeting_time' => 'Fridays 5:00 PM',
            'description' => "We sing.\n\nWe pray.",
        ])
        ->assertSchemaStateSet(['slug' => 'choir'])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->get(route('ministries.show', 'choir'))
        ->assertOk()
        ->assertSee('Fridays 5:00 PM')
        ->assertSee('<p>We pray.</p>', false);

    $this->get(route('home'))->assertSee(route('ministries.show', 'choir'));
});

test('a ministry cannot take a reserved or duplicate link name', function (string $slug) {
    Livewire::actingAs(superAdminUser())
        ->test(CreateMinistry::class)
        ->fillForm(['name' => 'Clash', 'slug' => $slug])
        ->call('create')
        ->assertHasFormErrors(['slug']);
})->with(['gallery', 'youth']);

test('unpublished ministries are hidden from the site and menu', function () {
    Ministry::factory()->unpublished()->create(['name' => 'Secret Ministry', 'slug' => 'secret']);

    $this->get('/ministries/secret')->assertNotFound();
    $this->get(route('home'))->assertDontSee('secret ministry');
});

test('the gallery still works under the ministries path', function () {
    $this->get(route('ministries.gallery'))->assertOk()->assertSee('Church Gallery');
});
