@extends('layout')

@section('title', '✂️ Copy & Paste All Emojis 📋')
@section('description', 'Quickly copy and paste emojis with search system and categories - 3702 emojis available')
@section('image', asset('images/logo.png'))

@section('content')
    <header class="h-16 bg-white flex items-center justify-between p-3 border-b border-gray-300">
        <a href="{{route('pages.index')}}" class="flex items-center space-x-3">
            <img src="{{asset('images/logo.png')}}" class="h-8" alt="{{config('app.name')}} Logo">
            <span class="self-center text-xl sm:text-2xl font-semibold whitespace-nowrap text-yellow-500">{{config('app.name')}}</span>
        </a>
        <h1 class="text-xl sm:text-2xl text-center hidden sm:block">✂️ Copy and Paste Emojis 📋</h1>
        <a class="text-white bg-black hover:bg-black/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs sm:text-sm px-3 py-2 text-center" href={{route('pages.api')}}>
            Try our API
        </a>
    </header>
    <main class="container mx-auto py-3 flex-1">
        <div class="px-3 sm:px-0">
            <section class="flex gap-3 w-full overflow-x-auto scrollbar-hide mb-4">
                @forelse ($events as $event)
                    <article class="border rounded-lg flex-shrink-0 basis-1/2 sm:basis-1/3 md:basis-1/4 lg:basis-1/4 xl:basis-1/5">
                        <a href="{{$event->route}}">
                            <div class="w-full h-full relative">
                                <span class="absolute top-0 left-0 w-full h-full bg-black/35 rounded-lg"></span>
                                <img src="{{$event->imageUrl}}" alt="image {{$event->name}}" class="w-full h-auto object-cover rounded-lg">
                                <h2 class="absolute w-full top-1/2 -translate-y-1/2 text-white z-1 text-2xl font-bold text-center">{{$event->name}}</h2>
                            </div>
                        </a>
                    </article>
                @empty
                @endforelse
            </section>
            <aside class="w-full overflow-x-auto scrollbar-hide">
                <ul class="flex gap-3">
                @foreach($allCategories as $category)
                    <li>
                        <a href="#{{$category->slug}}" class="bg-white font-medium border rounded-lg text-sm border-gray-300 cursor-pointer px-5 py-2.5 hover:bg-gray-100 text-nowrap flex gap-2">
                            <span>{{$category->emoji}}</span>
                            <span>{{$category->name}}</span>
                        </a>
                    </li>
                @endforeach
                </ul>
            </aside>
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
            <h2 class="text-xl my-3 font-bold ps-3 sm:ps-0" id="{{$category->slug}}">{{$category->name}}</h2>
            <section class="grid grid-cols-5 sm:grid-cols-10 md:grid-cols-12 lg:grid-cols-17 xl:grid-cols-20 gap-1">
                @each('emojis.emoji', $category->emojis, 'emoji')
            </section>
        @empty
            <div class="flex flex-col items-center bg-white px-3 py-8 border border-gray-300 justify-center">
                <h2 class="text-3xl my-3 font-bold">🤔 No emojis found</h2>
                <p class="text-md text-black">There are no emojis that match your current search. Try other keywords to get better results.</p>
                <a href="{{route('pages.index')}}" class="mt-8 text-white bg-black hover:bg-black/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs sm:text-sm px-3 py-2 text-center">Clear Search</a>
            </div>
        @endforelse
    </main>
@endsection
