<?php

namespace App\Filament\Resources;

use App\Filament\Enums\FormStatesOptionsEnum;
use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use \Nnjeim\World\Models\Country;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Locations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('region')
                    ->required(),
                Forms\Components\TextInput::make('subregion')
                    ->required(),
                Forms\Components\ToggleButtons::make('status')
                    ->options(FormStatesOptionsEnum::class)
                    ->inline(true)
                    ->grouped()
                    ->default(1)
                    ->required(),
                Forms\Components\TextInput::make('iso2')
                    ->required(),
                Forms\Components\TextInput::make('iso3')
                    ->required(),
                Forms\Components\TextInput::make('phone_code')
                    ->tel()
                    ->required(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('name'),
                Infolists\Components\TextEntry::make('status'),
                Infolists\Components\TextEntry::make('region'),
                Infolists\Components\TextEntry::make('subregion'),
                Infolists\Components\TextEntry::make('iso2'),
                Infolists\Components\TextEntry::make('iso3'),
                Infolists\Components\TextEntry::make('phone_code'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('iso2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('iso3')
                    ->searchable(),
                Tables\Columns\TextColumn::make('region')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subregion')
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'view' => Pages\ViewCountry::route('/{record}'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
