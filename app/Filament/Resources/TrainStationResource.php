<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainStationResource\Pages;
use App\Filament\Resources\TrainStationResource\RelationManagers;
use App\Models\TrainStation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainStationResource extends Resource
{
    protected static ?string $model = TrainStation::class;

//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Travel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListTrainStations::route('/'),
            'create' => Pages\CreateTrainStation::route('/create'),
            'view' => Pages\ViewTrainStation::route('/{record}'),
            'edit' => Pages\EditTrainStation::route('/{record}/edit'),
        ];
    }
}
