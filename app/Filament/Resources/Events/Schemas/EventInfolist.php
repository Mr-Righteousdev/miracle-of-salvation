<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Enums\EventCategory;
use App\Models\Event;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class EventInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->size(TextSize::Large),
                TextEntry::make('description'),
                ImageEntry::make('image')
                    ->disk('public')
                    ->hidden(fn (Event $record): bool => blank($record->image)),
                TextEntry::make('starts_at')
                    ->label('Starts at')
                    ->dateTime(),
                TextEntry::make('category')
                    ->badge()
                    ->formatStateUsing(fn (EventCategory $state): string => $state->label()),
                TextEntry::make('location')
                    ->placeholder('-'),
            ]);
    }
}
