<?php

namespace App\Filament\Resources\PrayerRequests;

use App\Filament\Resources\PrayerRequests\Pages\CreatePrayerRequest;
use App\Filament\Resources\PrayerRequests\Pages\EditPrayerRequest;
use App\Filament\Resources\PrayerRequests\Pages\ListPrayerRequests;
use App\Filament\Resources\PrayerRequests\Pages\ViewPrayerRequest;
use App\Filament\Resources\PrayerRequests\Schemas\PrayerRequestForm;
use App\Filament\Resources\PrayerRequests\Schemas\PrayerRequestInfolist;
use App\Filament\Resources\PrayerRequests\Tables\PrayerRequestsTable;
use App\Models\PrayerRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PrayerRequestResource extends Resource
{
    protected static ?string $model = PrayerRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHandRaised;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Prayer request';

    protected static ?string $pluralModelLabel = 'Prayer requests';

    public static function form(Schema $schema): Schema
    {
        return PrayerRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PrayerRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrayerRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrayerRequests::route('/'),
            'create' => CreatePrayerRequest::route('/create'),
            'view' => ViewPrayerRequest::route('/{record}'),
            'edit' => EditPrayerRequest::route('/{record}/edit'),
        ];
    }
}
