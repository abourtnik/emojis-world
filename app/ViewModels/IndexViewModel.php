<?php

namespace App\ViewModels;

use App\Models\Category;
use App\Models\Emoji;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class IndexViewModel
{
    public function fromRequest(Request $request): array
    {
        $emojis = $this->searchEmojis($request->query('search'));

        return [
            'events' => $this->events(),
            'allCategories' => $this->allCategories(),
            'categories' => $this->categories($emojis)
        ];
    }

    private function searchEmojis(?string $term): Collection
    {
        if (!$term) {
            return collect();
        }

        return Emoji::search($term)
            ->options([
                'query_by' => 'name,emoji,category_name,sub_category_name,keywords',
                'query_by_weights' => '20,1,5,2,7',
                'num_typos'=> 2,
                'drop_tokens_threshold' => 0,
                'typo_tokens_threshold' => 1,
                'prefix' => true
            ])
            ->get();
    }

    private function events(): Collection
    {
        return Event::query()
            ->select('t.*')
            ->selectRaw("
                CASE
                    WHEN CURDATE() BETWEEN t.actual_start_date AND t.actual_end_date
                    THEN 1
                    ELSE 0
                END AS is_active
            ")
            ->fromSub(function (Builder $q) {
                $q->select('*')
                    ->selectRaw("STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', start_date), '%Y-%m-%d') AS actual_start_date")
                    ->selectRaw("STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', end_date), '%Y-%m-%d') AS actual_end_date")
                    ->selectRaw("
                        CASE
                            WHEN STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', start_date), '%Y-%m-%d') >= CURDATE()
                            THEN STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', start_date), '%Y-%m-%d')
                            ELSE STR_TO_DATE(CONCAT(YEAR(CURDATE())+1, '-', start_date), '%Y-%m-%d')
                        END AS next_start_date
                     ")
                    ->from('events');
            }, 't')
            ->orderBy('is_permanent', 'DESC')
            ->orderBy('is_active', 'DESC')
            ->orderBy('next_start_date', 'ASC')
            ->get();
    }

    private function allCategories(): Collection
    {
        return Category::query()
            ->orderBy('id')
            ->get();
    }

    private function categories(Collection $emojis): Collection
    {
        return Category::query()
            ->withWhereHas('emojis', function ($query) use ($emojis) {
                $query
                    ->when(request()->has('search'), function (EloquentBuilder $query) use ($emojis) {
                        $query->whereIn('id', $emojis->pluck('id')->toArray());
                    })
                    ->scopes('withoutChildren')
                    ->withCount('children')
                    ->with('children')
                    ->orderBy('sub_category_id')
                    ->orderBy('version')
                    ->orderBy('unicode');
            })->get();
    }
}
