<?php

namespace App\Filament\Resources\Streams\Schemas;

use App\Enums\StreamStatus;
use App\Models\Stream;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class StreamInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                ImageEntry::make('thumbnail')
                    ->label('Video')
                    ->getStateUsing(fn (Stream $record): string => $record->thumbnailUrl())
                    ->height(180)
                    ->columnSpanFull(),
                TextEntry::make('title')
                    ->size(TextSize::Large)
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn (StreamStatus $state): string => $state === StreamStatus::Live ? 'success' : 'gray')
                    ->formatStateUsing(fn (StreamStatus $state): string => $state->label()),
                TextEntry::make('starts_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('likes_count')
                    ->label('Likes')
                    ->getStateUsing(fn (Stream $record): int => $record->likes()->count()),
                TextEntry::make('youtube_url')
                    ->url(fn (Stream $record): string => $record->youtube_url)
                    ->placeholder('-')
                    ->columnSpanFull(),
            ]);
    }
}
