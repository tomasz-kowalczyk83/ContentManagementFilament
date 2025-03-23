<?php

namespace App\Filament\Enums;

use Filament\Support\Contracts\HasColor;

enum FormStatesOptionsEnum: int implements HasColor
{
    case Active = 1;
    case Inactive = 0;

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'danger',
        };
    }
}
