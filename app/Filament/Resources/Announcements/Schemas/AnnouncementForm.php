<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('body')
                    ->required()
                    ->autosize()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->disk('public')
                    ->image()
                    ->imageEditor()
                    ->directory('announcements')
                    ->imageResizeMode('cover')
                    ->maxSize(5120),
                DateTimePicker::make('published_at')
                    ->label('Publish date')
                    ->helperText('Set a future date to schedule the announcement.')
                    ->default(now()),
            ]);
    }
}
