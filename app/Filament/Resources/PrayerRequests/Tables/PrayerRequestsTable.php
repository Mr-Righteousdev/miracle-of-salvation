<?php

namespace App\Filament\Resources\PrayerRequests\Tables;

use App\Models\PrayerRequest;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PrayerRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->placeholder('Anonymous')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('message')
                    ->wrap()
                    ->limit(60),
                IconColumn::make('is_prayed_for')
                    ->label('Prayed for')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_prayed_for')
                    ->label('Prayer status'),
            ])
            ->recordActions([
                Action::make('togglePrayedFor')
                    ->label(fn (PrayerRequest $record): string => $record->is_prayed_for ? 'Mark as not prayed for' : 'Mark as prayed for')
                    ->icon(fn (PrayerRequest $record): Heroicon => $record->is_prayed_for ? Heroicon::OutlinedArrowPath : Heroicon::OutlinedCheckCircle)
                    ->color(fn (PrayerRequest $record): string => $record->is_prayed_for ? 'gray' : 'success')
                    ->action(function (PrayerRequest $record): void {
                        $record->update(['is_prayed_for' => ! $record->is_prayed_for]);
                    }),
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
