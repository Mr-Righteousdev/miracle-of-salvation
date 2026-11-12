<?php

namespace App\Filament\Resources\PaymentTypes\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PaymentTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('sort_order')
                    ->label('Order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                Textarea::make('description')
                    ->autosize()
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Visitors can give to this')
                    ->default(true),
            ]);
    }
}
