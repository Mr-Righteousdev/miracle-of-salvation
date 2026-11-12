<?php

use App\Filament\Widgets\ChurchStatsOverview;
use App\Filament\Widgets\PendingPrayerRequests;
use App\Filament\Widgets\UpcomingEvents;
use App\Models\Event;
use App\Models\PrayerRequest;
use App\Models\User;
use Filament\Pages\Dashboard;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('dashboard shows the church stats widgets for super admins', function () {
    Livewire::actingAs(superAdminUser())
        ->test(Dashboard::class)
        ->assertOk()
        ->assertSee('Admin users')
        ->assertSee('Upcoming events')
        ->assertSee('Pending prayer requests');
});

test('dashboard no longer shows the default filament widgets', function () {
    Livewire::actingAs(superAdminUser())
        ->test(Dashboard::class)
        ->assertOk()
        ->assertDontSeeHtml('fi-account-widget')
        ->assertDontSeeHtml('fi-filament-info-widget');
});

test('widgets are visible for super admins', function () {
    $this->actingAs(superAdminUser());

    expect(ChurchStatsOverview::canView())->toBeTrue();
    expect(UpcomingEvents::canView())->toBeTrue();
    expect(PendingPrayerRequests::canView())->toBeTrue();
});

test('widgets are hidden for users without the view permission', function () {
    $role = Role::findOrCreate('editor');
    $user = User::factory()->create();
    $user->assignRole($role);

    $this->actingAs($user);

    expect(ChurchStatsOverview::canView())->toBeFalse();
    expect(UpcomingEvents::canView())->toBeFalse();
    expect(PendingPrayerRequests::canView())->toBeFalse();
});

test('upcoming events widget lists only upcoming events', function () {
    $upcoming = Event::factory()->create(['starts_at' => now()->addWeek()]);
    Event::factory()->past()->create();

    Livewire::actingAs(superAdminUser())
        ->test(UpcomingEvents::class)
        ->assertOk()
        ->assertSee($upcoming->title);
});

test('pending prayer request widget can mark a request as prayed for', function () {
    $request = PrayerRequest::factory()->create(['is_prayed_for' => false]);

    Livewire::actingAs(superAdminUser())
        ->test(PendingPrayerRequests::class)
        ->callTableAction('markPrayed', $request)
        ->assertHasNoTableActionErrors();

    expect($request->refresh()->is_prayed_for)->toBeTrue();
});
