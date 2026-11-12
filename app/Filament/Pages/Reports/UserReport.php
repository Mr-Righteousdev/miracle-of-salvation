<?php

namespace App\Filament\Pages\Reports;

use App\Models\User;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Spatie\Permission\Models\Role;
use UnitEnum;

class UserReport extends Page
{
    use HasPageShield;

    protected string $view = 'filament.pages.reports.user-report';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'User Report';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'totalUsers' => User::count(),
            'users' => User::with('roles')->latest()->get(),
            'roles' => Role::withCount('users')->orderBy('name')->get(),
        ];
    }
}
