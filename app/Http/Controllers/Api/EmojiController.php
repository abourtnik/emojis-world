<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\EmojiCollection;
use App\Http\Resources\EmojiResource;
use App\Models\Emoji;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;

class EmojiController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Welcome on Emojis World API (version ' .config('app.version'). ') !!'
        ]);
    }

    public function search(SearchRequest $request): EmojiCollection
    {
        $q = $request->validated('q');

        return new EmojiCollection(
            Emoji::search($q)
                ->query(fn (Builder $query) => $query->with(['category:id,name', 'subCategory:id,name', 'children']))
                ->options([
                    'query_by' => 'name,emoji,category_name,sub_category_name,keywords',
                    'query_by_weights' => '20,1,5,2,7',
                    'per_page' => $request->validated('limit'),
                    'num_typos'=> 2,
                    'drop_tokens_threshold' => 0,
                    'typo_tokens_threshold' => 1,
                    'prefix' => true
                ])
                ->when($request->validated('categories'), function ($query) use ($request) {
                    return $query->whereIn('category_id', $request->validated('categories'));
                })
                ->when($request->validated('sub_categories'), function ($query) use ($request) {
                    return $query->whereIn('sub_category_id', $request->validated('sub_categories'));
                })
                ->when($request->validated('versions'), function ($query) use ($request) {
                    return $query->whereIn('version', $request->validated('versions'));
                })
                ->get()
        );
    }

    public function random(SearchRequest $request): EmojiCollection
    {
        return new EmojiCollection(
            Emoji::query()
                ->select('id', 'name', 'emoji', 'unicode', 'version', 'category_id', 'sub_category_id')
                ->withoutChildren()
                ->filter($request->validated())
                ->with(['category:id,name', 'subCategory:id,name', 'children'])
                ->inRandomOrder()
                ->get()
        );
    }

    public function popular(SearchRequest $request): EmojiCollection
    {
        return new EmojiCollection(
            Emoji::query()
                ->select('id', 'name', 'emoji', 'unicode', 'version', 'category_id', 'sub_category_id', 'parent_id')
                ->filter($request->validated())
                ->with(['category:id,name', 'subCategory:id,name', 'children', 'parent'])
                ->orderBy('count', 'desc')
                ->get()
        );
    }

    public function emoji(Emoji $emoji): EmojiResource
    {
        return new EmojiResource(
            $emoji->load(['children', 'parent'])
        );
    }
}
