<?php

use App\Models\User;

test('the seeder creates a super admin who can access the admin panel', function () {
    $this->seed();

    $admin = User::query()->where('email', 'admin@firstchurch.test')->first();

    expect($admin)->not->toBeNull()
        ->and($admin->hasRole('super_admin'))->toBeTrue()
        ->and($admin->receives_prayer_emails)->toBeTrue();

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk();
});
