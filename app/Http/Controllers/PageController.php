<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Emoji;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $emojis = false;

        if ($search) {
            $emojis = Emoji::search($search)
                ->options([
                    'query_by' => 'name,category_name,sub_category_name,keywords',
                    'query_by_weights' => '20,5,2,7',
                    'num_typos'=> 2,
                    'drop_tokens_threshold' => 0,
                    'typo_tokens_threshold' => 1,
                    'prefix' => true
                ])
                ->get();
        }

        return view('pages.index', [
            'allCategories' => Category::query()->orderBy('id')->get(),
            'categories' => Category::query()
                ->withWhereHas(
                    'emojis', function ($query) use ($emojis) {
                            $query
                                ->when($emojis, function ($query) use ($emojis) {
                                    $query->whereIn('id', $emojis->pluck('id')->toArray());
                                })
                                ->scopes('withoutChildren')
                                ->withCount('children')
                                ->with('children')
                                ->orderBy('sub_category_id');
                        }
                )
                ->get(),
        ]);
    }

    public function api(): View
    {
        return view('pages.api', [
            'endpoints' => config('endpoints'),
            'emojis_count' => Emoji::count(),
        ]);
    }
}
