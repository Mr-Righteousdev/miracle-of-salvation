<?php

namespace App\Filament\Pages\Reports;

use App\Models\Event;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class EventReport extends Page
{
    use HasPageShield;

    protected string $view = 'filament.pages.reports.event-report';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Event Report';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'totalEvents' => Event::count(),
            'upcomingEvents' => Event::upcoming()->get(),
            'pastEvents' => Event::past()->get(),
        ];
    }
}
