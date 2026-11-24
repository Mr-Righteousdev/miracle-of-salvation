<?php

use App\Filament\Resources\Branches\BranchResource;
use App\Filament\Resources\Branches\Pages\CreateBranch;
use App\Models\Branch;
use Livewire\Livewire;

test('the existing branches are loaded by the migration', function () {
    expect(Branch::published()->pluck('slug')->all())
        ->toBe(['kampala', 'rwamwanja', 'kagadi', 'kirianjagi', 'kinshasa', 'twin-falls']);
});

test('super admins can view the branch list', function () {
    $this->actingAs(superAdminUser())
        ->get(BranchResource::getUrl())
        ->assertOk()
        ->assertSee('Miracle of Salvation Kampala');
});

test('super admins can add a branch and it appears on the public site', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateBranch::class)
        ->fillForm([
            'name' => 'Miracle of Salvation Hoima',
            'location' => 'Hoima, Uganda',
            'pastor' => 'Pastor John',
            'service_times' => 'Sundays 10:00 AM',
        ])
        ->assertSchemaStateSet(['slug' => 'hoima'])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->get(route('branches'))
        ->assertOk()
        ->assertSee('id="hoima"', false)
        ->assertSee('Pastor John')
        ->assertSee('Sundays 10:00 AM');

    $this->get(route('home'))->assertSee(route('branches').'#hoima');
});

test('a branch link name must be unique', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreateBranch::class)
        ->fillForm(['name' => 'Duplicate', 'slug' => 'kampala', 'location' => 'Kampala'])
        ->call('create')
        ->assertHasFormErrors(['slug' => 'unique']);
});

test('unpublished branches are hidden from the public site', function () {
    Branch::factory()->unpublished()->create(['name' => 'Secret Branch']);

    $this->get(route('branches'))->assertDontSee('Secret Branch');
});
