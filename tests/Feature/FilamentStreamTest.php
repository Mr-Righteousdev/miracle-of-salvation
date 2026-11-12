<?php

use App\Filament\Resources\Streams\Pages\CreateStream;
use App\Filament\Resources\Streams\Pages\ViewStream;
use App\Filament\Resources\Streams\RelationManagers\StreamCommentsRelationManager;
use App\Filament\Resources\Streams\StreamResource;
use App\Models\Stream;
use App\Models\StreamComment;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('super admins can view the streams list', function () {
    $this->actingAs(superAdminUser())
        ->get(StreamResource::getUrl())
        ->assertOk();
});

test('users without the view permission cannot access the streams list', function () {
    $role = Role::findOrCreate('editor');
    $user = User::factory()->create();
    $user->assignRole($role);

    $this->actingAs($user)
        ->get(StreamResource::getUrl())
        ->assertForbidden();
});

test('super admins can create a stream and the video id is extracted', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateStream::class)
        ->fillForm([
            'title' => 'Sunday Worship',
            'youtube_url' => 'https://youtu.be/dQw4w9WgXcQ',
            'starts_at' => now(),
            'status' => 'live',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('streams', [
        'title' => 'Sunday Worship',
        'video_id' => 'dQw4w9WgXcQ',
        'comments_enabled' => true,
        'comments_visible' => true,
    ]);
});

test('super admins can toggle comment settings when creating a stream', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateStream::class)
        ->fillForm([
            'title' => 'Q&A Evening',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'status' => 'live',
            'comments_enabled' => false,
            'comments_visible' => false,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('streams', [
        'title' => 'Q&A Evening',
        'comments_enabled' => false,
        'comments_visible' => false,
    ]);
});

test('streams with invalid youtube urls are rejected', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateStream::class)
        ->fillForm([
            'title' => 'Bad link',
            'youtube_url' => 'https://example.com/not-youtube',
            'status' => 'live',
        ])
        ->call('create')
        ->assertHasFormErrors(['youtube_url']);
});

test('super admins can approve an unapproved comment in the relation manager', function () {
    $stream = Stream::factory()->create();
    $comment = StreamComment::factory()->unapproved()->create(['stream_id' => $stream->id]);

    Livewire::actingAs(superAdminUser())
        ->test(StreamCommentsRelationManager::class, [
            'ownerRecord' => $stream,
            'pageClass' => ViewStream::class,
        ])
        ->assertSuccessful()
        ->callTableAction('toggleApproval', $comment);

    expect($comment->refresh()->is_approved)->toBeTrue();
});
