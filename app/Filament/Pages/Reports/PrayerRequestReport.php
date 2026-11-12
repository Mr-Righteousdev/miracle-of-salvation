<?php

namespace App\Filament\Pages\Reports;

use App\Models\PrayerRequest;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Carbon;
use UnitEnum;

class PrayerRequestReport extends Page
{
    use HasPageShield;

    protected string $view = 'filament.pages.reports.prayer-request-report';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHandRaised;

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Prayer Request Report';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $start = now()->subMonths(11)->startOfMonth();

        $submitted = PrayerRequest::query()
            ->where('created_at', '>=', $start)
            ->get()
            ->groupBy(fn (PrayerRequest $request): string => $request->created_at->format('Y-m'));

        $monthly = collect();
        $cursor = Carbon::instance($start);

        while ($cursor->lte(now()->endOfMonth())) {
            $monthly->put($cursor->format('Y-m'), $submitted->get($cursor->format('Y-m'), collect())->count());
            $cursor->addMonth();
        }

        return [
            'total' => PrayerRequest::count(),
            'prayedFor' => PrayerRequest::query()->where('is_prayed_for', true)->count(),
            'pending' => PrayerRequest::query()->where('is_prayed_for', false)->count(),
            'monthly' => $monthly,
            'recent' => PrayerRequest::query()->latest()->take(10)->get(),
        ];
    }
}
