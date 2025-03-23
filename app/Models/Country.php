<?php

namespace App\Models;

use App\Filament\Enums\FormStatesOptionsEnum;
use Illuminate\Database\Eloquent\Model;

class Country extends \Nnjeim\World\Models\Country
{
    protected function casts(): array
    {
        return [
            'status' => FormStatesOptionsEnum::class,
        ];
    }
}
