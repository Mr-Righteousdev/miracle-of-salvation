<?php

namespace App\Filament\Resources\GalleryImages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GalleryImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                FileUpload::make('image')
                    ->disk('public')
                    ->image()
                    ->imageEditor()
                    ->directory('gallery')
                    ->required()
                    ->maxSize(5120)
                    ->columnSpanFull(),
                TextInput::make('caption')
                    ->maxLength(255)
                    ->columnSpanFull(),
                DateTimePicker::make('published_at')
                    ->label('Publish date')
                    ->helperText('Leave empty to keep the photo hidden from the public gallery.')
                    ->default(now()),
                TextInput::make('sort_order')
                    ->label('Order')
                    ->helperText('Lower numbers appear first. Drag rows in the list to reorder.')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
            ]);
    }
}
