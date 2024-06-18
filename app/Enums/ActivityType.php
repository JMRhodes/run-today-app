<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ActivityType: string implements HasLabel, HasColor
{
    case RUN  = 'run';
    case WALK = 'walk';

    public function getLabel(): string
    {
        return match ($this) {
            self::RUN => 'Run',
            self::WALK => 'Walk'
        };
    }


    public function getColor(): string|array|null
    {
        return match ($this) {
            self::RUN => 'success',
            self::WALK => 'warning'
        };
    }
}
