<?php

namespace App\Filament\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum FormStatesOptionsEnum: int implements HasColor, HasLabel
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

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'active',
            self::Inactive => 'inactive',
        };
    }
}
