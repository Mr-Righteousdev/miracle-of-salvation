<?php

namespace App\Filament\Resources\Ministries\Schemas;

use App\Models\Ministry;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class MinistryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->placeholder('Youth Ministry')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state, string $operation) => $operation === 'create'
                        ? $set('slug', str($state)->beforeLast(' Ministry')->slug()->toString())
                        : null),
                TextInput::make('slug')
                    ->label('Link name')
                    ->helperText('The page address, e.g. /ministries/youth.')
                    ->required()
                    ->alphaDash()
                    ->unique(ignoreRecord: true)
                    ->rule(Rule::notIn(Ministry::RESERVED_SLUGS))
                    ->maxLength(255),
                TextInput::make('leader')
                    ->label('Ministry leader')
                    ->maxLength(255),
                TextInput::make('meeting_time')
                    ->placeholder('Saturdays 3:00 PM')
                    ->maxLength(255),
                TextInput::make('summary')
                    ->helperText('One sentence shown at the top of the page.')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->helperText('Leave a blank line between paragraphs.')
                    ->rows(8)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Cover photo')
                    ->disk('public')
                    ->image()
                    ->imageEditor()
                    ->automaticallyResizeImagesToWidth('1600')
                    ->directory('ministries')
                    ->maxSize(10240)
                    ->columnSpanFull(),
                DateTimePicker::make('published_at')
                    ->label('Publish date')
                    ->helperText('Leave empty to hide the ministry from the public site and menu.')
                    ->default(now()),
                TextInput::make('sort_order')
                    ->label('Order')
                    ->helperText('Lower numbers appear first in the menu. Drag rows in the list to reorder.')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
            ]);
    }
}
