<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ActivityType: string implements HasColor, HasLabel
{
    case RUN = 'run';
    case TREADMILL = 'treadmill';
    case WALK = 'walk';

    public function getLabel(): string
    {
        return match ($this) {
            self::RUN => 'Run',
            self::TREADMILL => 'Treadmill',
            self::WALK => 'Walk'
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::RUN => 'success',
            self::TREADMILL => 'info',
            self::WALK => 'warning'
        };
    }
}
