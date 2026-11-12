<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('amount')
                    ->money(fn ($record): string => $record->currency),
                TextEntry::make('status')
                    ->badge()
                    ->formatStateUsing(fn (PaymentStatus $state): string => $state->label())
                    ->color(fn (PaymentStatus $state): string => $state->color()),
                TextEntry::make('paymentType.name')
                    ->label('Type'),
                TextEntry::make('method')
                    ->formatStateUsing(fn (PaymentMethod $state): string => $state->label()),
                TextEntry::make('payer_name')
                    ->placeholder('Anonymous'),
                TextEntry::make('phone')
                    ->placeholder('-'),
                TextEntry::make('note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('prayerRequest.message')
                    ->label('Linked prayer request')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('provider_reference')
                    ->label('Provider reference')
                    ->placeholder('-')
                    ->copyable(),
                TextEntry::make('paid_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime(),
            ]);
    }
}
