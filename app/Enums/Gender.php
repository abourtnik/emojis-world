<?php

namespace App\Enums;

enum Gender: int
{
    case Neutral = 0;
    case Male    = 1;
    case Female  = 2;
    case Mix  = 3;

    public function label(): string
    {
        return match ($this) {
            self::Neutral => 'Person',
            self::Male    => 'Man',
            self::Female  => 'Woman',
            self::Mix  => 'Woman/Man',
        };
    }

    public function pluralLabel(): string
    {
        return match ($this) {
            self::Neutral => 'People',
            self::Male    => 'Men',
            self::Female  => 'Women',
            self::Mix  => 'Women/Men',
        };
    }

    public function coupleLabel(): string
    {
        return match ($this) {
            self::Neutral => 'people',
            self::Male    => 'men',
            self::Female  => 'women',
            self::Mix  => 'woman-and-man',
        };
    }

    public static function withoutMix(): array
    {
        return array_filter(self::cases(), fn(self $case) => $case !== self::Mix);
    }
}
