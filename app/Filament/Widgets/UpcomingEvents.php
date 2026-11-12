<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class UpcomingEvents extends TableWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = false;

    protected static ?string $heading = 'Upcoming events';

    protected static ?int $sort = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => Event::upcoming()->take(5))
            ->paginated(false)
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('starts_at')
                    ->dateTime('D, M j, Y · g:i A'),
                TextColumn::make('location')
                    ->placeholder('-')
                    ->toggleable(),
            ]);
    }
}
