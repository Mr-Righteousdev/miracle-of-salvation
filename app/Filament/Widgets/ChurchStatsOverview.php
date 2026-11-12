<?php

namespace App\Filament\Widgets;

use App\Enums\StreamStatus;
use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\PrayerRequest;
use App\Models\Stream;
use App\Models\User;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ChurchStatsOverview extends StatsOverviewWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = false;

    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Admin users', User::count())
                ->icon(Heroicon::Users)
                ->color('info'),
            Stat::make('Upcoming events', Event::upcoming()->count())
                ->icon(Heroicon::OutlinedCalendarDays)
                ->color('primary'),
            Stat::make('Pending prayer requests', PrayerRequest::query()->where('is_prayed_for', false)->count())
                ->icon(Heroicon::OutlinedHandRaised)
                ->color('warning'),
            Stat::make('Unread contact messages', ContactMessage::unread()->count())
                ->icon(Heroicon::OutlinedEnvelope)
                ->color('warning'),
            Stat::make('Published announcements', Announcement::published()->count())
                ->icon(Heroicon::OutlinedMegaphone)
                ->color('success'),
            Stat::make('Streams', Stream::count())
                ->icon(Heroicon::OutlinedVideoCamera)
                ->description(Stream::query()->where('status', StreamStatus::Live)->exists()
                    ? 'One stream is live now'
                    : 'No stream is live')
                ->color(Stream::query()->where('status', StreamStatus::Live)->exists() ? 'danger' : 'gray'),
        ];
    }
}
