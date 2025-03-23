<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use \Nnjeim\World\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $navigationGroup = 'Locations';

    protected static ?int $navigationSort = 3;

//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('country_id')
                    ->relationship('country', 'name')
                    ->preload()
                    ->optionsLimit(20)
                    ->searchable()
                    ->reactive()
                    ->native(false)
                    ->afterStateUpdated(fn (callable $set) => $set('state_id', null))
                    ->required(),

                Forms\Components\Select::make('state_id')
                    ->relationship('state', 'name')
                    ->options(function (callable $get) {
                        $countryId = $get('country_id');
                        if (!$countryId) {
                            return State::all()->pluck('name', 'id');
                        }
                        return State::where('country_id', $countryId)->pluck('name', 'id');
                    })
                    ->preload()
                    ->afterStateUpdated(function (callable $set, $state) {
                        if ($state) {
                            $selectedState = State::find($state);
                            $set('country_id', $selectedState->country_id);
                        }
                    })
                    ->searchable()
                    ->reactive()
                    ->native(false)
                    ->required(),

                Forms\Components\TextInput::make('name')
                    ->required(),

                Forms\Components\TextInput::make('country_code')
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
                Tables\Columns\TextColumn::make('state.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country_code')
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
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'view' => Pages\ViewCity::route('/{record}'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
