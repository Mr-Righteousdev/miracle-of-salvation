<?php

use App\Livewire\PrayerRequestForm;
use App\Models\PrayerRequest;
use App\Models\User;
use App\Notifications\NewPrayerRequest;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

test('the prayer requests page is rendered', function () {
    $this->get('/prayer-requests')->assertOk();
});

test('a visitor can submit a prayer request', function () {
    Livewire::test(PrayerRequestForm::class)
        ->set('name', 'Jane Doe')
        ->set('email', 'jane@example.com')
        ->set('message', 'Please pray for my family.')
        ->call('submit')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('prayer_requests', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'message' => 'Please pray for my family.',
        'is_prayed_for' => false,
    ]);
});

test('the name and email are optional', function () {
    Livewire::test(PrayerRequestForm::class)
        ->set('message', 'Pray for healing.')
        ->call('submit')
        ->assertHasNoErrors();

    $request = PrayerRequest::first();

    expect($request->name)->toBeNull();
    expect($request->email)->toBeNull();
});

test('a prayer request requires a message', function () {
    Livewire::test(PrayerRequestForm::class)
        ->call('submit')
        ->assertHasErrors(['message']);
});

test('an invalid email address is rejected', function () {
    Livewire::test(PrayerRequestForm::class)
        ->set('email', 'not-an-email')
        ->set('message', 'Pray for me.')
        ->call('submit')
        ->assertHasErrors(['email']);
});

test('submitting a prayer request notifies admins with the flag enabled', function () {
    Notification::fake();

    $admin = User::factory()->create(['receives_prayer_emails' => true]);

    Livewire::test(PrayerRequestForm::class)
        ->set('message', 'Please pray for my exams.')
        ->call('submit')
        ->assertHasNoErrors();

    Notification::assertSentTo($admin, NewPrayerRequest::class);
});

test('admins without the flag are not notified', function () {
    Notification::fake();

    $admin = User::factory()->create(['receives_prayer_emails' => false]);

    Livewire::test(PrayerRequestForm::class)
        ->set('message', 'Please pray for my exams.')
        ->call('submit')
        ->assertHasNoErrors();

    Notification::assertNotSentTo($admin, NewPrayerRequest::class);
});

test('the notification mail includes the request details', function () {
    $prayerRequest = PrayerRequest::factory()->create([
        'name' => 'John Smith',
        'email' => 'john@example.com',
        'message' => 'Please pray for our ministry.',
    ]);
    $admin = User::factory()->create(['receives_prayer_emails' => true]);

    $mail = (new NewPrayerRequest($prayerRequest))->toMail($admin);

    expect($mail->subject)->toBe('New prayer request');

    $html = (string) $mail->render();

    expect($html)->toContain('A new prayer request has been submitted')
        ->toContain('Please pray for our ministry.')
        ->toContain('John Smith')
        ->toContain('john@example.com');
});
