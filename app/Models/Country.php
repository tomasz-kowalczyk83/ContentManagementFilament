<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends \Nnjeim\World\Models\Country
{
    protected function casts(): array
    {
        return [
            'status' => 'boolean'
        ];
    }
}
