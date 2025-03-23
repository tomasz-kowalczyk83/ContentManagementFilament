<?php

namespace App\Filament\Resources\TimezoneResource\Pages;

use App\Filament\Resources\TimezoneResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTimezone extends ViewRecord
{
    protected static string $resource = TimezoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
