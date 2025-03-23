<?php

namespace App\Filament\Resources;

use App\Filament\Enums\FormStatesOptionsEnum;
use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Models\Country;
use Filament\Infolists;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Infolist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Nnjeim\World\Models\Currency;

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

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with('currency'))
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
//                Tables\Columns\TextColumn::make('timezones.name')
//                    ->listWithLineBreaks(),
                Tables\Columns\TextColumn::make('currency')
                    ->formatStateUsing(function (Currency $state) {
                        return sprintf('%s (%s)', $state->name, $state->code);
                    }),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('')
                    ->schema([
                        Fieldset::make('Details')
                            ->schema([
                                Infolists\Components\TextEntry::make('name'),
                                Infolists\Components\TextEntry::make('status')
                                    ->badge(),
                                Infolists\Components\TextEntry::make('region'),
                                Infolists\Components\TextEntry::make('subregion'),
                                Infolists\Components\TextEntry::make('iso2'),
                                Infolists\Components\TextEntry::make('iso3'),
                                Infolists\Components\TextEntry::make('phone_code'),
                            ]),
                        Fieldset::make('Currency')
                            ->schema([
                                Infolists\Components\TextEntry::make('currency.name')
                                    ->label('name'),
                                Infolists\Components\TextEntry::make('currency.symbol')
                                    ->label('symbol'),
                                Infolists\Components\TextEntry::make('currency.code')
                                    ->label('code'),
                            ])
                            ->columns(3),
                        Fieldset::make('Language')
                            ->schema([
                                Infolists\Components\TextEntry::make('language.name')
                                    ->label('name'),
                                Infolists\Components\TextEntry::make('language.name_native')
                                    ->label('name_native'),
                                Infolists\Components\TextEntry::make('language.code')
                                    ->label('code'),
                            ])
                            ->columns(3),
                        Fieldset::make('timezones')
                            ->schema([
                                RepeatableEntry::make('timezones')
                                    ->hiddenLabel()
                                    ->schema([
                                        Infolists\Components\TextEntry::make('name')->hiddenLabel(),
                                    ])
                                    ->columnSpan(2)
//                                    ->columns(2),
                            ])
//                            ->columnSpan(2)
//                            ->contained(false)

                    ])
                    ->columns(2),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StatesRelationManager::class,
            RelationManagers\CitiesRelationManager::class,
            RelationManagers\TimezonesRelationManager::class
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
