<?php

use App\Filament\Resources\Announcements\AnnouncementResource;
use App\Filament\Resources\Announcements\Pages\CreateAnnouncement;
use App\Models\Announcement;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('super admins can view the announcements list', function () {
    $this->actingAs(superAdminUser())
        ->get(AnnouncementResource::getUrl())
        ->assertOk();
});

test('users without the view permission cannot access the announcements list', function () {
    $role = Role::findOrCreate('editor');
    $user = User::factory()->create();
    $user->assignRole($role);

    $this->actingAs($user)
        ->get(AnnouncementResource::getUrl())
        ->assertForbidden();
});

test('super admins can create an announcement', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateAnnouncement::class)
        ->fillForm([
            'title' => 'Welcome Service',
            'body' => 'Join us this Sunday at 10:00 AM.',
            'published_at' => now(),
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('announcements', [
        'title' => 'Welcome Service',
        'body' => 'Join us this Sunday at 10:00 AM.',
    ]);
});

test('a scheduled announcement is hidden until its publish date', function () {
    $announcement = Announcement::factory()->scheduled()->create();

    expect($announcement->published_at->isFuture())->toBeTrue()
        ->and(Announcement::published()->find($announcement->id))->toBeNull();
});
