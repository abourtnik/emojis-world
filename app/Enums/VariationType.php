<?php

namespace App\Enums;

enum VariationType
{
    case NoTone;
    case OneTone;
    case TwoTones;
    case TwoPeople;

    public function view(): string
    {
        return match ($this) {
            self::NoTone => 'variations.no_tone',
            self::OneTone    => 'variations.one_tone',
            self::TwoTones  => 'variations.two_tones',
            self::TwoPeople  => 'variations.two_people',
        };
    }
}
