<?php

namespace App\Filament\Resources\Streams\Tables;

use App\Enums\StreamStatus;
use App\Models\Stream;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StreamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('starts_at', 'desc')
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Video')
                    ->getStateUsing(fn (Stream $record): string => $record->thumbnailUrl())
                    ->square()
                    ->toggleable(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (StreamStatus $state): string => $state === StreamStatus::Live ? 'success' : 'gray')
                    ->formatStateUsing(fn (StreamStatus $state): string => $state->label()),
                TextColumn::make('likes_count')
                    ->label('Likes')
                    ->getStateUsing(fn (Stream $record): int => $record->likes()->count()),
                TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(StreamStatus::class),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
