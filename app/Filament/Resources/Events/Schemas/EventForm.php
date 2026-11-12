<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Enums\EventCategory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventForm
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
                Textarea::make('description')
                    ->required()
                    ->autosize()
                    ->columnSpanFull(),
                DateTimePicker::make('starts_at')
                    ->label('Starts at')
                    ->required()
                    ->seconds(false),
                TextInput::make('location')
                    ->maxLength(255),
                Select::make('category')
                    ->options(EventCategory::options())
                    ->default(EventCategory::ChurchProgram->value)
                    ->required()
                    ->native(false),
                FileUpload::make('image')
                    ->disk('public')
                    ->image()
                    ->imageEditor()
                    ->directory('events')
                    ->imageResizeMode('cover')
                    ->maxSize(5120)
                    ->columnSpanFull(),
            ]);
    }
}
