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
                class="text-4xl cursor-pointer border border-transparent hover:bg-blue-100 hover:border-blue-300 transition selection:bg-transparent p-1.5 z-10"
                data-clipboard-target="{{'#emojis-'.$emoji->id}}"
                @click="copy({{$emoji->id}})"
                title="{{$emoji->name}}"
                aria-label="{{$emoji->name}}"
                type="button"
            >
                {{$emoji->emoji}}
            </button>
            @if($emoji->children_count <= 5)
                <span class="border-r border-gray-300"></span>
                @foreach($emoji->children as $child)
                    <button
                        data-clipboard-target="{{'#emojis-'.$child->id}}"
                        id="{{'emojis-'.$child->id}}"
                        class="text-4xl cursor-pointer border border-transparent hover:bg-blue-100 hover:border-blue-300 transition selection:bg-transparent p-1"
                        @click="copy({{$child->id}})"
                        title="{{$child->name}}"
                        aria-label="{{$child->name}}"
                        type="button"
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
                            class="text-4xl cursor-pointer border border-transparent hover:bg-blue-100 hover:border-blue-300 transition selection:bg-transparent p-1.5"
                            @click="copy({{$child->id}})"
                            title="{{$child->name}}"
                            aria-label="{{$child->name}}"
                        >
                            {{$child->emoji}}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
        <div
            class="group relative w-full parent"
            @mouseenter="hovered = true"
            @mouseleave="hovered = false"
        >
            <button
                class="block w-full border border-gray-300 cursor-pointer text-center py-1 hover:bg-blue-100 hover:border-blue-300 transition selection:bg-transparent"
                id="parent-{{$emoji->id}}"
                aria-describedby="tooltip"
                @click="toggle()"
                @click.away="open = false"
                x-ref="button"
                title="{{$emoji->name}}"
                aria-label="{{$emoji->name}}"
                type="button"
            >
                <span class="text-5xl" aria-hidden="true">{{$emoji->emoji}}</span>
            </button>
            <div
                role="status"
                class="bg-black text-white font-bold p-1 text-xs absolute top-0 left-0 w-full selection:bg-transparent text-center"
                x-show.important="copied"
                x-cloak
            >
                Copied !
            </div>
            <a
                href="{{$emoji->route}}"
                class="absolute bottom-1 right-1 text-xs font-bold rounded-md bg-black/75 text-white z-10 p-0.5 border border-white"
                x-show.important="hovered"
                x-transition.opacity.duration.150ms
                x-cloak
                title="More info"
                aria-label="More info"
                @click.stop
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"  viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
                <span class="sr-only">More info {{ $emoji->name }}</span>
            </a>
        </div>
    @else
        <div
            class="group relative w-full"
            @mouseenter="hovered = true"
            @mouseleave="hovered = false"
        >
            <button
                @click="copy({{$emoji->id}})"
                title="{{$emoji->name}}"
                aria-label="{{$emoji->name}}"
                data-clipboard-target="{{'#emojis-'.$emoji->id}}"
                type="button"
                class="block w-full border border-gray-300 cursor-pointer text-center py-1 hover:bg-blue-100 hover:border-blue-300 selection:bg-transparent"
            >
                <span id="{{'emojis-'.$emoji->id}}" class="text-5xl" aria-hidden="true">{{$emoji->emoji}}</span>
            </button>
            <div
                role="status"
                class="bg-black text-white font-bold p-1 text-xs absolute top-0 left-0 w-full selection:bg-transparent text-center"
                x-cloak
                x-show.important="copied"
            >
                Copied !
            </div>
            <a
                href="{{$emoji->route}}"
                class="absolute bottom-1 right-1 text-xs font-bold rounded-md bg-black/75 text-white z-10 p-0.5 border border-white"
                x-show.important="hovered"
                x-transition.opacity.duration.150ms
                x-cloak
                title="More info"
                aria-label="More info"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
                <span class="sr-only">More info {{ $emoji->name }}</span>
            </a>
        </div>
    @endif
</div>
