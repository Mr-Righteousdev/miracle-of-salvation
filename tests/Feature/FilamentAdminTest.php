<?php

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('admin panel login screen can be rendered', function () {
    $this->get('/admin/login')->assertOk();
});

test('guests are redirected from the admin panel to the login screen', function () {
    $this->get('/admin')->assertRedirect('/admin/login');
});

test('users without a role cannot access the admin panel', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/admin')->assertForbidden();
});

test('users with a role can access the admin panel', function () {
    $user = superAdminUser();

    $this->actingAs($user)->get('/admin')->assertOk();
});

test('super admins can view the admin users list', function () {
    $this->actingAs(superAdminUser())
        ->get(UserResource::getUrl())
        ->assertOk();
});

test('users without the view permission cannot access the admin users list', function () {
    $role = Role::findOrCreate('editor');
    $user = User::factory()->create();
    $user->assignRole($role);

    $this->actingAs($user)
        ->get(UserResource::getUrl())
        ->assertForbidden();
});

test('super admins can create an admin user with a role', function () {
    $role = Role::findOrCreate('editor');

    Livewire::actingAs(superAdminUser())
        ->test(CreateUser::class)
        ->fillForm([
            'name' => 'Jane Doe',
            'email' => 'jane@firstchurch.test',
            'password' => 'password',
            'roles' => [$role->getKey()],
            'receives_prayer_emails' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $user = User::where('email', 'jane@firstchurch.test')->first();

    expect($user)->not->toBeNull()
        ->and($user->hasRole('editor'))->toBeTrue()
        ->and($user->receives_prayer_emails)->toBeTrue()
        ->and($user->email_verified_at)->not->toBeNull();
});

test('password is not required when editing an admin user', function () {
    $user = User::factory()->create();
    $originalPasswordHash = $user->password;

    Livewire::actingAs(superAdminUser())
        ->test(EditUser::class, ['record' => $user->getKey()])
        ->fillForm([
            'name' => 'Updated Name',
            'email' => $user->email,
            'password' => '',
            'roles' => [],
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $user->refresh();

    expect($user->name)->toBe('Updated Name')
        ->and($user->password)->toBe($originalPasswordHash);
});
