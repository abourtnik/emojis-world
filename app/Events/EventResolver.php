<?php

namespace App\Events;

use App\Models\Emoji;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use BadMethodCallException;

class EventResolver
{
    protected Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function resolve(): Collection
    {
        if (!$this->event->is_permanent) {
            return $this->default();
        }

        $method = Str::camel($this->event->slug);

        if (!method_exists($this, $method)) {
            throw new BadMethodCallException('Method does not exist');
        }

        return $this->$method();
    }

    private function default() : Collection
    {
        return Cache::rememberForever('event-' .$this->event->id. '-emojis', function () {
            return $this->event
                ->emojis()
                ->scopes('withoutChildren')
                ->withCount('children')
                ->with('children')
                ->orderBy('sub_category_id')
                ->orderBy('version')
                ->orderBy('unicode')
                ->get();
        });
    }

    private function top100(): Collection
    {
        return Emoji::query()
            ->select('id', 'name', 'emoji', 'unicode', 'version', 'category_id', 'sub_category_id', 'parent_id')
            ->with(['category:id,name', 'subCategory:id,name', 'children', 'parent'])
            ->withCount('children')
            ->with('children')
            ->orderBy('count', 'desc')
            ->limit(100)
            ->get();

    }
}
