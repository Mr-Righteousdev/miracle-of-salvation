<?php

namespace App\Filament\Resources\GalleryImages\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GalleryImageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image')
                    ->disk('public'),
                TextEntry::make('caption')
                    ->placeholder('-'),
                TextEntry::make('published_at')
                    ->label('Publish date')
                    ->dateTime()
                    ->placeholder('Hidden'),
            ]);
    }
}
