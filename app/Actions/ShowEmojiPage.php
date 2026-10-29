<?php

namespace App\Actions;

use App\Enums\Direction;
use App\Enums\Gender;
use App\Enums\SkinTone;
use App\Enums\VariationType;
use App\Models\Emoji;
use Illuminate\Support\Collection;
final class ShowEmojiPage
{
    private Collection $group;
    private VariationType $variationType;
    public function __construct(private readonly Emoji $emoji)
    {
        $this->group = $emoji->group()->get();
        $this->variationType = $this->resolveVariationType();
    }

    public static function for(Emoji $emoji): array
    {
        return (new self($emoji))->data();
    }

    public function data(): array
    {
        return [
            'emoji' => $this->emoji,
            'variations' => $this->variations(),
            'variationType' => $this->variationType,
            'variationsCount' => $this->group->count(),
            'hasDirectionVariation' => $this->hasDirectionVariation(),
        ];
    }

    private function variations(): Collection
    {
        if (in_array($this->variationType, [VariationType::TwoPeople, VariationType::TwoTones])) {
            return $this->group
                ->where('gender', $this->emoji->gender)
                ->groupBy(fn (Emoji $emoji) => $emoji->skin_tone->label());
        }

       return $this->group
           ->where('direction', $this->emoji->direction)
           ->groupBy(fn (Emoji $emoji) => $emoji->gender->label());
    }

    private function resolveVariationType(): VariationType
    {
        return match (true) {
            $this->group->contains('gender', Gender::Mix)                 => VariationType::TwoPeople,
            $this->group->every('skin_tone', SkinTone::None) => VariationType::NoTone,
            $this->group->whereNotNull('skin_tone_2')->isNotEmpty()  => VariationType::TwoTones,
            default                                                       => VariationType::OneTone,
        };
    }

    private function hasDirectionVariation(): bool
    {
        return $this->group->contains(fn (Emoji $e) => $e->direction === Direction::Right);
    }
}
