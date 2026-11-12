<?php

namespace App\Filament\Resources\Streams\Schemas;

use App\Enums\StreamStatus;
use App\Models\Stream;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StreamForm
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
                TextInput::make('youtube_url')
                    ->label('YouTube URL')
                    ->url()
                    ->required()
                    ->helperText('Any YouTube link works, e.g. youtube.com/watch?v=…, youtu.be/…, youtube.com/live/…')
                    ->rule(function (): \Closure {
                        return function (string $attribute, mixed $value, \Closure $fail): void {
                            if (! is_string($value) || Stream::extractVideoId($value) === null) {
                                $fail('The YouTube URL does not contain a valid video ID.');
                            }
                        };
                    }),
                TextInput::make('video_id')
                    ->hidden()
                    ->dehydrated(false),
                DateTimePicker::make('starts_at')
                    ->seconds(false)
                    ->helperText('The date and time of the service. Leave blank to feature now.'),
                Select::make('status')
                    ->options(StreamStatus::class)
                    ->default(StreamStatus::Live->value)
                    ->required(),
                Section::make('Comments')
                    ->description('Control how viewers interact with comments, just like on YouTube.')
                    ->schema([
                        Toggle::make('comments_enabled')
                            ->label('Allow comments')
                            ->helperText('When on, visitors can post comments under the video.')
                            ->default(true),
                        Toggle::make('comments_visible')
                            ->label('Show comments')
                            ->helperText('When on, existing comments are displayed under the video.')
                            ->default(true),
                    ]),
            ]);
    }
}
