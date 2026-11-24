<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state, string $operation) => $operation === 'create'
                        ? $set('slug', str($state)->after('Miracle of Salvation')->slug()->toString())
                        : null),
                TextInput::make('slug')
                    ->label('Link name')
                    ->helperText('Used in the page link, e.g. /branches#kampala.')
                    ->required()
                    ->alphaDash()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('location')
                    ->placeholder('Kampala, Uganda')
                    ->required()
                    ->maxLength(255),
                TextInput::make('pastor')
                    ->label('Branch pastor')
                    ->maxLength(255),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('service_times')
                    ->placeholder('Sundays 9:00 AM & 11:00 AM')
                    ->maxLength(255),
                TextInput::make('map_url')
                    ->label('Google Maps link')
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Photo')
                    ->disk('public')
                    ->image()
                    ->imageEditor()
                    ->automaticallyResizeImagesToWidth('1600')
                    ->directory('branches')
                    ->maxSize(10240)
                    ->columnSpanFull(),
                DateTimePicker::make('published_at')
                    ->label('Publish date')
                    ->helperText('Leave empty to hide the branch from the public site.')
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
