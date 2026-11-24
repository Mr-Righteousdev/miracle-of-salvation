<?php

namespace App\Filament\Resources\Leaders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('role')
                    ->placeholder('Senior Pastor')
                    ->required()
                    ->maxLength(255),
                Textarea::make('bio')
                    ->rows(4)
                    ->columnSpanFull(),
                FileUpload::make('photo')
                    ->disk('public')
                    ->image()
                    ->imageEditor()
                    ->imageAspectRatio('1:1')
                    ->automaticallyCropImagesToAspectRatio()
                    ->automaticallyResizeImagesToWidth('800')
                    ->directory('leaders')
                    ->maxSize(10240)
                    ->columnSpanFull(),
                DateTimePicker::make('published_at')
                    ->label('Publish date')
                    ->helperText('Leave empty to hide this leader from the public site.')
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
