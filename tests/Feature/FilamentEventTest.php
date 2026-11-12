<?php

use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('super admins can view the events list', function () {
    $this->actingAs(superAdminUser())
        ->get(EventResource::getUrl())
        ->assertOk();
});

test('users without the view permission cannot access the events list', function () {
    $role = Role::findOrCreate('editor');
    $user = User::factory()->create();
    $user->assignRole($role);

    $this->actingAs($user)
        ->get(EventResource::getUrl())
        ->assertForbidden();
});

test('super admins can create an event', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateEvent::class)
        ->fillForm([
            'title' => 'Harvest Thanksgiving',
            'description' => 'Come and celebrate with us.',
            'starts_at' => now()->addWeeks(2),
            'location' => 'Church Grounds',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('events', [
        'title' => 'Harvest Thanksgiving',
        'location' => 'Church Grounds',
    ]);
});
