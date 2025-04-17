<?php

namespace App\Http\Resources;

use App\Models\Emoji;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Emoji
 */
class EmojiResource extends JsonResource
{

    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'emoji' => $this->emoji,
            'unicode' => $this->unicode,
            'version' => $this->version,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'sub_category' => [
                'id' => $this->subCategory->id,
                'name' => $this->subCategory->name,
            ],
            'children' => EmojiChildrenResource::collection($this->children),
            $this->mergeWhen(!is_null($this->parent), function () {
                return [
                    'parent' => EmojiParentResource::make($this->parent),
                ];
            })
        ];
    }
}
