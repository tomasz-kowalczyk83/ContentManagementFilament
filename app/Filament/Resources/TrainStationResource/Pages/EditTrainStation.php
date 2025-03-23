<?php

namespace App\Filament\Resources\TrainStationResource\Pages;

use App\Filament\Resources\TrainStationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainStation extends EditRecord
{
    protected static string $resource = TrainStationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
