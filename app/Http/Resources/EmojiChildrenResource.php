<?php

namespace App\Http\Resources;

use App\Models\Emoji;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Emoji
 */
class EmojiChildrenResource extends JsonResource
{

    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'emoji' => $this->emoji,
            'unicode' => $this->unicode,
        ];
    }
}
