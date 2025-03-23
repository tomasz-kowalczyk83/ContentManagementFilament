<?php

namespace App\Filament\Resources;

use App\Filament\Enums\FormStatesOptionsEnum;
use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Models\Country;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
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
                    ->required()
                    ->length(2),
                Forms\Components\TextInput::make('iso3')
                    ->required()
                    ->length(3),
                Forms\Components\TextInput::make('phone_code')
                    ->numeric()
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status'),
                Tables\Columns\TextColumn::make('region')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subregion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('iso2'),
                Tables\Columns\TextColumn::make('iso3'),
                Tables\Columns\TextColumn::make('phone_code'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(FormStatesOptionsEnum::class),
                SelectFilter::make('region')
                    ->multiple()
                    ->options(function () {
                        return Country::distinct()
                            ->pluck('region', 'region')
                            ->filter()
                            ->all();
                    })
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
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
