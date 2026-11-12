<?php

namespace App\Filament\Resources\Streams\RelationManagers;

use App\Models\StreamComment;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class StreamCommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static string|BackedEnum|null $icon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $title = 'Comments';

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                IconColumn::make('is_approved')
                    ->label('Approved')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('name')
                    ->placeholder('Anonymous'),
                TextColumn::make('message')
                    ->wrap()
                    ->limit(80),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_approved')
                    ->label('Approval status'),
            ])
            ->recordActions([
                Action::make('toggleApproval')
                    ->label(fn (StreamComment $record): string => $record->is_approved ? 'Unapprove' : 'Approve')
                    ->icon(fn (StreamComment $record): Heroicon => $record->is_approved ? Heroicon::OutlinedEyeSlash : Heroicon::OutlinedCheckCircle)
                    ->color(fn (StreamComment $record): string => $record->is_approved ? 'gray' : 'success')
                    ->action(function (StreamComment $record): void {
                        $record->update(['is_approved' => ! $record->is_approved]);
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
