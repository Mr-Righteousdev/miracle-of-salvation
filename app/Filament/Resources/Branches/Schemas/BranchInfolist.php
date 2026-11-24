<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BranchInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('name'),
                TextEntry::make('location'),
                TextEntry::make('pastor')
                    ->label('Branch pastor')
                    ->placeholder('-'),
                TextEntry::make('phone')
                    ->placeholder('-'),
                TextEntry::make('service_times')
                    ->placeholder('-'),
                TextEntry::make('map_url')
                    ->label('Google Maps link')
                    ->url(fn (?string $state): ?string => $state, shouldOpenInNewTab: true)
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('image')
                    ->label('Photo')
                    ->disk('public')
                    ->placeholder('-'),
                TextEntry::make('published_at')
                    ->label('Publish date')
                    ->dateTime()
                    ->placeholder('Hidden'),
            ]);
    }
}
