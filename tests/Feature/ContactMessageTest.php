<?php

use App\Livewire\ContactForm;
use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\NewContactMessage;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

test('the contact page includes the contact form', function () {
    $this->get(route('contact'))
        ->assertOk()
        ->assertSeeLivewire(ContactForm::class);
});

test('a visitor can send a contact message', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'Jane Doe')
        ->set('email', 'jane@example.com')
        ->set('subject', 'Visiting on Sunday')
        ->set('message', 'What time does the service start?')
        ->call('submit')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'subject' => 'Visiting on Sunday',
        'read_at' => null,
    ]);
});

test('all contact fields are required', function () {
    Livewire::test(ContactForm::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'subject', 'message']);

    expect(ContactMessage::count())->toBe(0);
});

test('an invalid email address is rejected', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'Jane Doe')
        ->set('email', 'not-an-email')
        ->set('subject', 'Hello')
        ->set('message', 'Hello church.')
        ->call('submit')
        ->assertHasErrors(['email']);
});

test('sending a contact message notifies admins with the email flag enabled', function () {
    Notification::fake();

    $subscribed = User::factory()->create(['receives_prayer_emails' => true]);
    $unsubscribed = User::factory()->create(['receives_prayer_emails' => false]);

    Livewire::test(ContactForm::class)
        ->set('name', 'Jane Doe')
        ->set('email', 'jane@example.com')
        ->set('subject', 'Hello')
        ->set('message', 'Hello church.')
        ->call('submit')
        ->assertHasNoErrors();

    Notification::assertSentTo($subscribed, NewContactMessage::class);
    Notification::assertNotSentTo($unsubscribed, NewContactMessage::class);
});

test('the notification mail includes the message and replies to the sender', function () {
    $contactMessage = ContactMessage::factory()->create([
        'name' => 'John Smith',
        'email' => 'john@example.com',
        'subject' => 'Wedding enquiry',
        'message' => 'Can we book the church hall?',
    ]);

    $mail = (new NewContactMessage($contactMessage))->toMail(User::factory()->create());

    expect($mail->subject)->toBe('New contact message: Wedding enquiry')
        ->and($mail->replyTo)->toBe([['john@example.com', 'John Smith']])
        ->and((string) $mail->render())->toContain('Can we book the church hall?');
});
