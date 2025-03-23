<?php

namespace App\Filament\Resources\PortResource\Pages;

use App\Filament\Resources\PortResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPort extends ViewRecord
{
    protected static string $resource = PortResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
