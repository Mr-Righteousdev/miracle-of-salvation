<?php

namespace App\Filament\Resources\Leaders\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LeaderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('name'),
                TextEntry::make('role'),
                TextEntry::make('bio')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('photo')
                    ->disk('public')
                    ->placeholder('-'),
                TextEntry::make('published_at')
                    ->label('Publish date')
                    ->dateTime()
                    ->placeholder('Hidden'),
            ]);
    }
}
