<?php

namespace App\Filament\Resources\Streams;

use App\Filament\Resources\Streams\Pages\CreateStream;
use App\Filament\Resources\Streams\Pages\EditStream;
use App\Filament\Resources\Streams\Pages\ListStreams;
use App\Filament\Resources\Streams\Pages\ViewStream;
use App\Filament\Resources\Streams\RelationManagers\StreamCommentsRelationManager;
use App\Filament\Resources\Streams\Schemas\StreamForm;
use App\Filament\Resources\Streams\Schemas\StreamInfolist;
use App\Filament\Resources\Streams\Tables\StreamsTable;
use App\Models\Stream;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StreamResource extends Resource
{
    protected static ?string $model = Stream::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Stream';

    protected static ?string $pluralModelLabel = 'Streams';

    public static function form(Schema $schema): Schema
    {
        return StreamForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StreamInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StreamsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            StreamCommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStreams::route('/'),
            'create' => CreateStream::route('/create'),
            'view' => ViewStream::route('/{record}'),
            'edit' => EditStream::route('/{record}/edit'),
        ];
    }
}
