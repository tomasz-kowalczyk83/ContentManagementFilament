<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimezoneResource\Pages;
use App\Filament\Resources\TimezoneResource\RelationManagers;
use \Nnjeim\World\Models\Timezone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimezoneResource extends Resource
{
    protected static ?string $model = Timezone::class;

    protected static ?string $navigationGroup = 'Locale';

    protected static ?int $navigationSort = 4;

//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('country_id')
                    ->relationship('country', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListTimezones::route('/'),
            'create' => Pages\CreateTimezone::route('/create'),
            'view' => Pages\ViewTimezone::route('/{record}'),
            'edit' => Pages\EditTimezone::route('/{record}/edit'),
        ];
    }
}
