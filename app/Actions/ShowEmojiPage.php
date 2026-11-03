<?php

namespace App\Actions;

use App\Enums\Direction;
use App\Enums\Gender;
use App\Enums\SkinTone;
use App\Enums\VariationType;
use App\Models\Emoji;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

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
            'similarEmojis' => $this->similarEmojis(),
        ];
    }

    private function variations(): Collection
    {
        if ($this->group->isEmpty()) {
            return collect();
        }

        if (in_array($this->variationType, [VariationType::TwoPeople, VariationType::TwoTones])) {
            return $this->group
                ->where('gender', $this->emoji->gender)
                ->groupBy(fn (Emoji $emoji) => $emoji->skin_tone->label());
        }

        $grouped = $this->group
            ->where('direction', $this->emoji->direction)
            ->groupBy(fn (Emoji $e) => $e->gender->label());

       return $this->withDefault($grouped);
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

    private function withDefault(Collection $group): Collection
    {
        // For emoji woman-with-headscarf
        if (!Arr::exists($group, Gender::Neutral->label())) {
             return $group;
        }

        if ($group[Gender::Neutral->label()]->contains((fn (Emoji $e) => $e->skin_tone === SkinTone::None))) {
            return $group;
        }

        // For emoji light-skin-tone
        $group[Gender::Neutral->label()]->prepend(null);

        return  $group;
    }

    private function similarEmojis(): Collection
    {
        return Cache::remember(
            "emoji:{$this->emoji->id}:similar",
            now()->addDay(),
            fn () => Emoji::query()
                ->where('sub_category_id', $this->emoji->sub_category_id)
                ->where(function (Builder $query) {
                    $query->whereNot('group_id', $this->emoji->group_id)
                        ->orWhereNull('group_id');
                })
                ->whereKeyNot($this->emoji->base_id)
                ->where('skin_tone', $this->emoji->skin_tone)
                ->where(function (Builder $query) {
                    $query->where('skin_tone_2', $this->emoji->skin_tone_2)
                        ->orWhereNull('skin_tone_2');
                })
                ->where('gender', $this->emoji->gender)
                ->orderBy('group_id')
                ->orderBy('direction')
                ->orderBy('gender')
                ->get()
        );
    }
}
