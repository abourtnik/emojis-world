<?php

namespace App\Enums;

enum Direction: int
{
    case Default = 0;
    case Right   = 1;

    public function label(): string
    {
        return match ($this) {
            self::Default => 'Default',
            self::Right   => 'Facing Right',
        };
    }
}
