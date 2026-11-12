<?php

namespace App\Filament\Resources\PrayerRequests\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PrayerRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->maxLength(255),
                Textarea::make('message')
                    ->rows(5)
                    ->required()
                    ->maxLength(5000)
                    ->columnSpanFull(),
                Toggle::make('is_prayed_for')
                    ->label('Prayed for')
                    ->default(false),
            ]);
    }
}
