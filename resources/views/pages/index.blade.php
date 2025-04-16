@use(Illuminate\Support\Str)

@extends('layout')

@section('title', '✂️ Copy and 📋 Paste Emoji')
@section('title', 'Emojis World is a Open Source REST API allows developers to simply integrate all of the best emojis into their applications. More than 2400 are available.')

@section('content')
    <header class="h-16 bg-white flex items-center justify-between p-3 border-b border-gray-300">
        <a href="{{route('pages.index')}}" class="flex items-center space-x-3">
            <img src="{{asset('images/logo.png')}}" class="h-8" alt="{{config('app.name')}} Logo">
            <span class="self-center text-xl sm:text-2xl font-semibold whitespace-nowrap text-yellow-500">{{config('app.name')}}</span>
        </a>
        <h1 class="text-xl sm:text-2xl text-center hidden sm:block">✂️ Copy and 📋 Paste Emoji</h1>
        <a class="text-white bg-black hover:bg-black/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs sm:text-sm px-3 py-2 text-center" href={{route('pages.api')}}>
            Try our API
        </a>
    </header>
    <section class="container mx-auto py-3 flex-1">
        <div class="px-3 sm:px-0">
            <div class="flex gap-3 w-full overflow-x-auto scrollbar-hide">
                @foreach($allCategories as $category)
                    <a href="#{{Str::slug($category->name)}}" class="bg-white font-medium border rounded-lg text-sm border-gray-300 cursor-pointer px-5 py-2.5 hover:bg-gray-100 text-nowrap flex gap-2">
                        <span>{{$category->emojis->first()?->emoji}}</span>
                        <span>{{$category->name}}</span>
                    </a>
                @endforeach
            </div>
            <form method="get" action="/" class="my-4">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <input
                        id="search"
                        type="search"
                        class="bg-white border border-gray-300 w-full text-gray-900 p-2 focus:outline-hidden rounded"
                        placeholder="Search emoji"
                        name="search"
                        autofocus
                        value="{{request('search', '')}}"
                        required
                    />
                    @if(request('search', ''))
                        <a href="{{route('pages.index')}}" class="text-gray-500 absolute end-10 top-0 h-full font-medium text-sm px-4 py-2 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                    <button type="submit" class="text-white absolute end-0 top-0 bg-black hover:bg-black/90 h-full font-medium text-sm px-4 py-2 rounded rounded-l-none cursor-pointer">
                        <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        @forelse($categories as $category)
            <h2 class="text-xl my-3 font-bold" id="{{Str::slug($category->name)}}">{{$category->name}}</h2>
            <div class="grid grid-cols-5 sm:grid-cols-10 md:grid-cols-12 lg:grid-cols-17 xl:grid-cols-20 gap-1">
                @foreach($category->emojis as $emoji)
                    <div class="bg-white" x-data="emoji">
                        @if($emoji->children_count > 0)
                            <div
                                id="children-{{$emoji->id}}"
                                @class([
                                    'bg-white border border-gray-300 flex gap-1.5 absolute top-0 left-0 w-max p-1 shadow-lg text-center',
                                    'flex-col gap-2' => $emoji->children_count > 5
                                ])
                                x-cloak
                                x-show.important="open"
                                role="tooltip"
                                x-ref="tooltip"
                            >
                                <span class="text-4xl">{{$emoji->emoji}}</span>
                                @if($emoji->children_count <= 5)
                                    <span class="border-r border-gray-300"></span>
                                    @foreach($emoji->children as $child)
                                        <button
                                            data-clipboard-target="{{'#emojis-'.$child->id}}"
                                            id="{{'emojis-'.$child->id}}"
                                            class="text-4xl cursor-pointer"
                                            @click="copy({{$child->id}})"
                                        >
                                            {{$child->emoji}}
                                        </button>
                                    @endforeach
                                @else
                                    <span class="border-b border-gray-300 h-1 w-24 mx-auto"></span>
                                    <div class="grid grid-cols-5 gap-2">
                                        @foreach($emoji->children as $child)
                                            <button
                                                data-clipboard-target="{{'#emojis-'.$child->id}}"
                                                id="{{'emojis-'.$child->id}}"
                                                class="text-4xl cursor-pointer"
                                                @click="copy({{$child->id}})"
                                            >
                                                {{$child->emoji}}
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <button class="relative w-full parent" id="parent-{{$emoji->id}}" aria-describedby="tooltip" @click="toggle()" @click.away="open = false" x-ref="button">
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
                            <button class="relative w-full" @click="copy({{$emoji->id}})">
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
                @endforeach
            </div>
        @empty
            <div class="flex flex-col items-center bg-white px-3 py-8 border border-gray-300 justify-center">
                <h2 class="text-3xl my-3 font-bold">🤔 No emojis found</h2>
                <p class="text-md text-black">There are no emojis that match your current search. Try other keywords to get better results.</p>
                <a href="{{route('pages.index')}}" class="mt-8 text-white bg-black hover:bg-black/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs sm:text-sm px-3 py-2 text-center">Clear Search</a>
            </div>
        @endforelse
    </section>
    <footer class="h-12 bg-white flex items-center justify-between p-3 border-t border-gray-300 w-full">
        <p class="text-xs text-gray-500">Made with ❤️ by <a class="text-blue-500" href="https://github.com/abourtnik">Anton Bourtnik</a> </p>
        <p class="text-xs text-gray-500">Copyright © {{date('Y')}} EmojisWorld - All Rights Reserved</p>
    </footer>
@endsection
