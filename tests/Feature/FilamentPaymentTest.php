<?php

use App\Enums\PaymentMethod;
use App\Filament\Resources\Payments\Pages\ListPayments;
use App\Filament\Resources\Payments\PaymentResource;
use App\Filament\Resources\PaymentTypes\Pages\CreatePaymentType;
use App\Filament\Resources\PaymentTypes\PaymentTypeResource;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('super admins can view payments and payment types', function () {
    Payment::factory()->successful()->create(['payer_name' => 'Grace Achieng']);

    $admin = superAdminUser();

    $this->actingAs($admin)->get(PaymentResource::getUrl())->assertOk()->assertSee('Grace Achieng');
    $this->actingAs($admin)->get(PaymentTypeResource::getUrl())->assertOk();
});

test('users without the view permission cannot access payments', function () {
    $user = User::factory()->create();
    $user->assignRole(Role::findOrCreate('editor'));

    $this->actingAs($user)->get(PaymentResource::getUrl())->assertForbidden();
});

test('payments can be filtered by method', function () {
    $mtn = Payment::factory()->create(['method' => PaymentMethod::MtnMobileMoney]);
    $airtel = Payment::factory()->create(['method' => PaymentMethod::AirtelMoney]);

    Livewire::actingAs(superAdminUser())
        ->test(ListPayments::class)
        ->filterTable('method', PaymentMethod::AirtelMoney->value)
        ->assertCanSeeTableRecords([$airtel])
        ->assertCanNotSeeTableRecords([$mtn]);
});

test('payments cannot be created from the admin', function () {
    expect(PaymentResource::canCreate())->toBeFalse();
});

test('super admins can add a payment type', function () {
    Livewire::actingAs(superAdminUser())
        ->test(CreatePaymentType::class)
        ->fillForm(['name' => 'Missions Fund'])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(PaymentType::query()->where('name', 'Missions Fund')->value('is_active'))->toBeTrue();
});

test('payment type names must be unique', function () {
    PaymentType::factory()->create(['name' => 'Tithe']);

    Livewire::actingAs(superAdminUser())
        ->test(CreatePaymentType::class)
        ->fillForm(['name' => 'Tithe'])
        ->call('create')
        ->assertHasFormErrors(['name' => 'unique']);
});

test('the active scope hides inactive payment types', function () {
    $active = PaymentType::factory()->create();
    PaymentType::factory()->inactive()->create();

    expect(PaymentType::active()->pluck('id')->all())->toBe([$active->id]);
});
