<?php

namespace App\Filament\Resources\Ministries;

use App\Filament\Resources\Ministries\Pages\CreateMinistry;
use App\Filament\Resources\Ministries\Pages\EditMinistry;
use App\Filament\Resources\Ministries\Pages\ListMinistries;
use App\Filament\Resources\Ministries\Pages\ViewMinistry;
use App\Filament\Resources\Ministries\Schemas\MinistryForm;
use App\Filament\Resources\Ministries\Schemas\MinistryInfolist;
use App\Filament\Resources\Ministries\Tables\MinistriesTable;
use App\Models\Ministry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MinistryResource extends Resource
{
    protected static ?string $model = Ministry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 9;

    protected static ?string $modelLabel = 'Ministry';

    protected static ?string $pluralModelLabel = 'Ministries';

    public static function form(Schema $schema): Schema
    {
        return MinistryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MinistryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MinistriesTable::configure($table);
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
            'index' => ListMinistries::route('/'),
            'create' => CreateMinistry::route('/create'),
            'view' => ViewMinistry::route('/{record}'),
            'edit' => EditMinistry::route('/{record}/edit'),
        ];
    }
}
