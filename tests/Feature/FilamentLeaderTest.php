<?php

use App\Filament\Resources\Leaders\LeaderResource;
use App\Filament\Resources\Leaders\Pages\CreateLeader;
use App\Models\Leader;
use Livewire\Livewire;

test('super admins can view the leaders list', function () {
    $this->actingAs(superAdminUser())
        ->get(LeaderResource::getUrl())
        ->assertOk();
});

test('super admins can add a leader and they appear on the leadership page', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateLeader::class)
        ->fillForm(['name' => 'Rev. Grace Kahindo', 'role' => 'Senior Pastor'])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->get(route('about.leadership'))
        ->assertOk()
        ->assertSee('Rev. Grace Kahindo')
        ->assertSee('Senior Pastor');
});

test('a leader requires a name and role', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateLeader::class)
        ->fillForm([])
        ->call('create')
        ->assertHasFormErrors(['name' => 'required', 'role' => 'required']);
});

test('the leadership page lists published leaders in order and hides unpublished ones', function () {
    Leader::factory()->create(['name' => 'Second Leader', 'sort_order' => 2]);
    Leader::factory()->create(['name' => 'First Leader', 'sort_order' => 1]);
    Leader::factory()->unpublished()->create(['name' => 'Hidden Leader']);

    $this->get(route('about.leadership'))
        ->assertOk()
        ->assertSeeInOrder(['First Leader', 'Second Leader'])
        ->assertDontSee('Hidden Leader');
});
