<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Emoji;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class ShowIndexPage
{
    public function fromRequest(Request $request): array
    {
        $emojis = $this->searchEmojis($request->query('search'));

        return [
            'events' => EventService::getEvents(),
            'allCategories' => $this->allCategories(),
            'categories' => $this->categories($emojis),
            'history' => $this->history($emojis)
        ];
    }

    private function searchEmojis(?string $term): Collection
    {
        if (!$term) {
            return collect();
        }

        return Emoji::search($term)
            ->options([
                'query_by' => 'name,emoji,description,category_name,sub_category_name,keywords',
                'query_by_weights' => '20,1,10,5,2,7',
                'num_typos'=> 2,
                'drop_tokens_threshold' => 0,
                'typo_tokens_threshold' => 1,
                'prefix' => true
            ])
            ->get();
    }

    private function allCategories(): Collection
    {
        return Cache::rememberForever('all_categories', function () {
            return Category::query()
                ->orderBy('id')
                ->get();
        });
    }

    private function categories(Collection $emojis): Collection
    {
        $query = Category::query()
            ->withWhereHas('emojis', function ($query) use ($emojis) {
                $query
                    ->when(request()->has('search'), function (EloquentBuilder $query) use ($emojis) {
                        $query->whereIn('id', $emojis->pluck('id')->toArray());
                    })
                    ->scopes('withoutChildren')
                    ->withCount('children')
                    ->with('children')
                    ->orderBy('sub_category_id')
                    ->orderBy('group_id')
                    ->orderBy('direction')
                    ->orderBy('gender');
            });

        if (request()->has('search')) {
            return $query->get();
        }

        return Cache::rememberForever('categories', fn () => $query->get());
    }

    private function history(Collection $emojis): Collection
    {
        $visitorId = Cookie::get('visitor_id');

        if (!$visitorId) {
            return collect();
        }

        $query = Emoji::select('emojis.*')
            ->join('history', 'history.emoji_id', '=', 'emojis.id')
            ->where('history.visitor_id', $visitorId)
            ->orderByDesc('history.date')
            ->withCount('children')
            ->with('children');

        if (request()->has('search')) {
            return $query->whereIn('emojis.id', $emojis->pluck('id')->toArray())->get();
        }

        return Cache::rememberForever('visitor-' .$visitorId. '-history', fn () => $query->get());
    }
}
