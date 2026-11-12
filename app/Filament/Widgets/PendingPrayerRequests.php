<?php

namespace App\Filament\Widgets;

use App\Models\PrayerRequest;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class PendingPrayerRequests extends TableWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = false;

    protected static ?string $heading = 'Pending prayer requests';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => PrayerRequest::query()->where('is_prayed_for', false)->latest()->take(5))
            ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->placeholder('Anonymous'),
                TextColumn::make('message')
                    ->wrap()
                    ->limit(60),
                TextColumn::make('created_at')
                    ->dateTime('M j, Y')
                    ->toggleable(),
            ])
            ->recordActions([
                Action::make('markPrayed')
                    ->label('Mark as prayed for')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->action(function (PrayerRequest $record): void {
                        $record->update(['is_prayed_for' => true]);
                    }),
            ]);
    }
}
