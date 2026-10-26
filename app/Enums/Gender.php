<?php

namespace App\Enums;

enum Gender: int
{
    case Neutral = 0;
    case Male    = 1;
    case Female  = 2;

    public function label(): string
    {
        return match ($this) {
            self::Neutral => 'Person',
            self::Male    => 'Man',
            self::Female  => 'Woman',
        };
    }
}
