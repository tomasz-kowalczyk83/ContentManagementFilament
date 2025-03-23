<?php

namespace App\Filament\Resources\TrainStationResource\Pages;

use App\Filament\Resources\TrainStationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainStations extends ListRecords
{
    protected static string $resource = TrainStationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
