<?php

use App\Filament\Pages\SiteSettings;
use App\Models\Setting;
use App\Models\User;
use Livewire\Livewire;

test('super admins can open the site settings page', function () {
    $this->actingAs(superAdminUser())
        ->get(SiteSettings::getUrl())
        ->assertOk()
        ->assertSee('P.O. Box 30501, Kampala, Uganda');
});

test('saved settings appear on the public site', function () {
    Livewire::actingAs(superAdminUser())
        ->test(SiteSettings::class)
        ->fillForm([
            'church_name' => 'Miracle of Salvation Church',
            'phone' => '+256 700 123456',
            'email' => 'info@example.org',
            'facebook_url' => 'https://facebook.com/example',
            'giving_instructions' => 'MTN MoMo: 0700 123456',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(Setting::get('phone'))->toBe('+256 700 123456');

    $this->get(route('contact'))
        ->assertSee('+256 700 123456')
        ->assertSee('info@example.org')
        ->assertSee('https://facebook.com/example');

    $this->get(route('give'))
        ->assertSee('MTN MoMo: 0700 123456')
        ->assertDontSee('Giving Platforms Coming Soon');
});

test('the give page says coming soon until giving instructions are set', function () {
    $this->get(route('give'))->assertSee('Giving Platforms Coming Soon');
});

test('settings validate links and email', function () {
    Livewire::actingAs(superAdminUser())
        ->test(SiteSettings::class)
        ->fillForm(['email' => 'not-an-email', 'youtube_url' => 'nope'])
        ->call('save')
        ->assertHasFormErrors(['email', 'youtube_url']);
});

test('users without a role cannot open the settings page', function () {
    $this->actingAs(User::factory()->create())
        ->get(SiteSettings::getUrl())
        ->assertForbidden();
});
