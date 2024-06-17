<?php

namespace app\Enums;

use Filament\Support\Contracts\HasLabel;

enum ActivityType: string implements HasLabel
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
}
