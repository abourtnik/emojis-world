<div class="bg-white" x-data="emoji">
    @if($emoji->children_count > 0)
        <div
            id="children-{{$emoji->id}}"
            @class([
                'bg-white border border-gray-400 flex absolute top-0 left-0 w-max shadow-xl text-center',
                'flex-col gap-2' => $emoji->children_count > 5
            ])
            x-cloak
            x-show.important="open"
            role="tooltip"
            x-ref="tooltip"
        >
            <button
                id="{{'emojis-'.$emoji->id}}"
                class="text-4xl cursor-pointer hover:bg-gray-200 selection:bg-transparent p-1.5"
                data-clipboard-target="{{'#emojis-'.$emoji->id}}"
                @click="copy({{$emoji->id}})"
                title="{{$emoji->name}}"
            >
                {{$emoji->emoji}}
            </button>
            @if($emoji->children_count <= 5)
                <span class="border-r border-gray-300"></span>
                @foreach($emoji->children as $child)
                    <button
                        data-clipboard-target="{{'#emojis-'.$child->id}}"
                        id="{{'emojis-'.$child->id}}"
                        class="text-4xl cursor-pointer hover:bg-gray-200 selection:bg-transparent p-1"
                        @click="copy({{$child->id}})"
                        title="{{$child->name}}"
                    >
                        {{$child->emoji}}
                    </button>
                @endforeach
            @else
                <span class="border-b border-gray-300 h-1 w-24 mx-auto"></span>
                <div class="grid grid-cols-5">
                    @foreach($emoji->children as $child)
                        <button
                            data-clipboard-target="{{'#emojis-'.$child->id}}"
                            id="{{'emojis-'.$child->id}}"
                            class="text-4xl cursor-pointer hover:bg-gray-200 selection:bg-transparent p-1.5"
                            @click="copy({{$child->id}})"
                            title="{{$child->name}}"
                        >
                            {{$child->emoji}}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
        <button
            class="relative w-full parent"
            id="parent-{{$emoji->id}}"
            aria-describedby="tooltip"
            @click="toggle()"
            @click.away="open = false" x-ref="button"
            title="{{$emoji->name}}"
        >
            <div class="border border-gray-300 cursor-pointer text-center py-1 hover:bg-gray-200 selection:bg-transparent">
                <span class="text-5xl">{{$emoji->emoji}}</span>
            </div>
            <div
                role="tooltip"
                class="bg-black text-white font-bold p-1 text-xs absolute top-0 left-0 w-full selection:bg-transparent"
                x-show.important="copied"
                x-cloak
            >
                Copied !
            </div>
        </button>
    @else
        <button class="relative w-full" @click="copy({{$emoji->id}})" title="{{$emoji->name}}">
            <div data-clipboard-target="{{'#emojis-'.$emoji->id}}" class="border border-gray-300 cursor-pointer text-center py-1 hover:bg-gray-200 selection:bg-transparent">
                <span id="{{'emojis-'.$emoji->id}}" class="text-5xl">{{$emoji->emoji}}</span>
            </div>
            <div
                role="tooltip"
                class="bg-black text-white font-bold p-1 text-xs absolute top-0 left-0 w-full selection:bg-transparent"
                x-cloak
                x-show.important="copied"
            >
                Copied !
            </div>
        </button>
    @endif
</div>
