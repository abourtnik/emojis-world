<?php

namespace App\Enums;

enum SkinTone: int
{
    case None        = 0;
    case Light       = 1;
    case MediumLight = 2;
    case Medium      = 3;
    case MediumDark  = 4;
    case Dark        = 5;

    public function codepoint(): ?string
    {
        return match ($this) {
            self::None        => null,
            self::Light       => '1F3FB',
            self::MediumLight => '1F3FC',
            self::Medium      => '1F3FD',
            self::MediumDark  => '1F3FE',
            self::Dark        => '1F3FF',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::None        => 'Default',
            self::Light       => 'Light',
            self::MediumLight => 'Medium-light',
            self::Medium      => 'Medium',
            self::MediumDark  => 'Medium-dark',
            self::Dark        => 'Dark',
        };
    }

    public static function casesWithoutNone(): array
    {
        return array_filter(self::cases(), fn(self $case) => $case !== self::None);
    }
}
