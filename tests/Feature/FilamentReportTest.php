<?php

use App\Filament\Pages\Reports\EventReport;
use App\Filament\Pages\Reports\PrayerRequestReport;
use App\Filament\Pages\Reports\UserReport;
use App\Models\Event;
use App\Models\PrayerRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

test('super admins can view the event report', function () {
    $this->actingAs(superAdminUser())
        ->get(EventReport::getUrl())
        ->assertOk();
});

test('super admins can view the prayer request report', function () {
    $this->actingAs(superAdminUser())
        ->get(PrayerRequestReport::getUrl())
        ->assertOk();
});

test('super admins can view the user report', function () {
    $this->actingAs(superAdminUser())
        ->get(UserReport::getUrl())
        ->assertOk();
});

test('users without the view permission cannot access the reports', function () {
    $role = Role::findOrCreate('editor');
    $user = User::factory()->create();
    $user->assignRole($role);

    foreach ([EventReport::class, PrayerRequestReport::class, UserReport::class] as $report) {
        $this->actingAs($user)
            ->get($report::getUrl())
            ->assertForbidden();
    }
});

test('the event report lists upcoming and past events', function () {
    $upcoming = Event::factory()->create(['title' => 'Upcoming Revival', 'starts_at' => now()->addWeek()]);
    $past = Event::factory()->create(['title' => 'Old Crusade', 'starts_at' => now()->subMonth()]);

    $this->actingAs(superAdminUser())
        ->get(EventReport::getUrl())
        ->assertOk()
        ->assertSee('Upcoming Revival')
        ->assertSee('Old Crusade');
});

test('the prayer request report shows the request summary', function () {
    PrayerRequest::factory()->count(2)->create();
    PrayerRequest::factory()->prayedFor()->create(['message' => 'Answered healing']);

    $this->actingAs(superAdminUser())
        ->get(PrayerRequestReport::getUrl())
        ->assertOk()
        ->assertSee('Answered healing')
        ->assertSee('Prayed for');
});

test('the user report lists admin users and roles', function () {
    $admin = User::factory()->create(['name' => 'Report Admin']);
    $admin->assignRole(Role::findOrCreate('super_admin'));

    $this->actingAs(superAdminUser())
        ->get(UserReport::getUrl())
        ->assertOk()
        ->assertSee('Report Admin');
});
