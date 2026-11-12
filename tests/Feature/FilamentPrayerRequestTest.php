<?php

use App\Filament\Resources\PrayerRequests\Pages\ListPrayerRequests;
use App\Filament\Resources\PrayerRequests\PrayerRequestResource;
use App\Models\PrayerRequest;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('super admins can view the prayer requests list', function () {
    $this->actingAs(superAdminUser())
        ->get(PrayerRequestResource::getUrl())
        ->assertOk();
});

test('users without the view permission cannot access the prayer requests list', function () {
    $role = Role::findOrCreate('editor');
    $user = User::factory()->create();
    $user->assignRole($role);

    $this->actingAs($user)
        ->get(PrayerRequestResource::getUrl())
        ->assertForbidden();
});

test('prayer requests are shown in the list with their message', function () {
    $prayerRequest = PrayerRequest::factory()->create(['message' => 'Pray for our church.']);

    $this->actingAs(superAdminUser())
        ->get(PrayerRequestResource::getUrl())
        ->assertOk()
        ->assertSee('Pray for our church.');
});

test('super admins can mark a prayer request as prayed for', function () {
    $prayerRequest = PrayerRequest::factory()->create();

    Livewire::actingAs(superAdminUser())
        ->test(ListPrayerRequests::class)
        ->callTableAction('togglePrayedFor', $prayerRequest);

    expect($prayerRequest->refresh()->is_prayed_for)->toBeTrue();
});

test('super admins can unmark a prayed for request', function () {
    $prayerRequest = PrayerRequest::factory()->prayedFor()->create();

    Livewire::actingAs(superAdminUser())
        ->test(ListPrayerRequests::class)
        ->callTableAction('togglePrayedFor', $prayerRequest);

    expect($prayerRequest->refresh()->is_prayed_for)->toBeFalse();
});
