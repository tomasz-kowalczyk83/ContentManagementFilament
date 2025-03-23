<?php

namespace App\Filament\Resources\TrainStationResource\Pages;

use App\Filament\Resources\TrainStationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTrainStation extends ViewRecord
{
    protected static string $resource = TrainStationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
