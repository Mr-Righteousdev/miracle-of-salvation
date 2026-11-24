<?php

namespace App\Filament\Resources\Videos\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VideoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('title')
                    ->columnSpanFull(),
                TextEntry::make('youtube_url')
                    ->label('YouTube URL')
                    ->url(fn (string $state): string => $state, shouldOpenInNewTab: true),
                TextEntry::make('published_at')
                    ->label('Publish date')
                    ->dateTime()
                    ->placeholder('Hidden'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('thumbnail')
                    ->state(fn ($record): string => $record->thumbnailUrl()),
            ]);
    }
}
