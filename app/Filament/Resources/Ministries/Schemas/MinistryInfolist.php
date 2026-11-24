<?php

namespace App\Filament\Resources\Ministries\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MinistryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('name'),
                TextEntry::make('slug')
                    ->label('Link name'),
                TextEntry::make('leader')
                    ->label('Ministry leader')
                    ->placeholder('-'),
                TextEntry::make('meeting_time')
                    ->placeholder('-'),
                TextEntry::make('summary')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('image')
                    ->label('Cover photo')
                    ->disk('public')
                    ->placeholder('-'),
                TextEntry::make('published_at')
                    ->label('Publish date')
                    ->dateTime()
                    ->placeholder('Hidden'),
            ]);
    }
}
