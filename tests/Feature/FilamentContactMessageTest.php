<?php

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Filament\Resources\ContactMessages\Pages\ListContactMessages;
use App\Models\ContactMessage;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('super admins can view the contact messages list', function () {
    ContactMessage::factory()->create(['subject' => 'Wedding enquiry']);

    $this->actingAs(superAdminUser())
        ->get(ContactMessageResource::getUrl())
        ->assertOk()
        ->assertSee('Wedding enquiry');
});

test('users without the view permission cannot access contact messages', function () {
    $user = User::factory()->create();
    $user->assignRole(Role::findOrCreate('editor'));

    $this->actingAs($user)
        ->get(ContactMessageResource::getUrl())
        ->assertForbidden();
});

test('opening a contact message marks it as read', function () {
    $contactMessage = ContactMessage::factory()->create();

    $this->actingAs(superAdminUser())
        ->get(ContactMessageResource::getUrl('view', ['record' => $contactMessage]))
        ->assertOk()
        ->assertSee($contactMessage->message);

    expect($contactMessage->refresh()->read_at)->not->toBeNull();
});

test('super admins can toggle a message between read and unread', function () {
    $contactMessage = ContactMessage::factory()->create();

    $page = Livewire::actingAs(superAdminUser())->test(ListContactMessages::class);

    $page->callTableAction('toggleRead', $contactMessage);
    expect($contactMessage->refresh()->read_at)->not->toBeNull();

    $page->callTableAction('toggleRead', $contactMessage);
    expect($contactMessage->refresh()->read_at)->toBeNull();
});

test('contact messages cannot be created from the admin', function () {
    expect(ContactMessageResource::canCreate())->toBeFalse();
});
