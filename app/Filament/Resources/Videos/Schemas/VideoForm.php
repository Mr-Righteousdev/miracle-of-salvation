<?php

namespace App\Filament\Resources\Videos\Schemas;

use App\Models\Stream;
use Closure;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VideoForm
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
                    ->helperText('Upload the video to the church YouTube channel first, then paste its link here.')
                    ->rule(fn (): Closure => function (string $attribute, mixed $value, Closure $fail): void {
                        if (! is_string($value) || Stream::extractVideoId($value) === null) {
                            $fail('The YouTube URL does not contain a valid video ID.');
                        }
                    })
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                DateTimePicker::make('published_at')
                    ->label('Publish date')
                    ->helperText('Leave empty to hide the video from the public site.')
                    ->default(now()),
            ]);
    }
}
