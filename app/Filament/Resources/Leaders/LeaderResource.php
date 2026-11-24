<?php

namespace App\Filament\Resources\Leaders;

use App\Filament\Resources\Leaders\Pages\CreateLeader;
use App\Filament\Resources\Leaders\Pages\EditLeader;
use App\Filament\Resources\Leaders\Pages\ListLeaders;
use App\Filament\Resources\Leaders\Pages\ViewLeader;
use App\Filament\Resources\Leaders\Schemas\LeaderForm;
use App\Filament\Resources\Leaders\Schemas\LeaderInfolist;
use App\Filament\Resources\Leaders\Tables\LeadersTable;
use App\Models\Leader;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LeaderResource extends Resource
{
    protected static ?string $model = Leader::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 8;

    protected static ?string $modelLabel = 'Leader';

    protected static ?string $pluralModelLabel = 'Leaders';

    public static function form(Schema $schema): Schema
    {
        return LeaderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LeaderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeadersTable::configure($table);
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
            'index' => ListLeaders::route('/'),
            'create' => CreateLeader::route('/create'),
            'view' => ViewLeader::route('/{record}'),
            'edit' => EditLeader::route('/{record}/edit'),
        ];
    }
}
