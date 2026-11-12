@extends('layout')

@section('title', 'All Emoji Events: Holidays, Seasons & Celebrations')
@section('description', 'Browse all emoji events: holidays, seasons and celebrations. Find the perfect emojis for every occasion, from Christmas to Halloween, and copy them in one click.')

@section('content')
    @include('pages.partials.header')
    <main class="flex-1">
        <section class="bg-white p-6 md:p-12 border-b border-gray-300 flex flex-col-reverse md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col gap-4 max-w-200 text-left">
                <h1 class="text-black text-5xl font-bold">All Emoji Events: Holidays, Seasons & Celebrations</h1>
                <p class="text-md">Browse all emoji events: holidays, seasons and celebrations. Find the perfect emojis for every occasion, from Christmas to Halloween, and copy them in one click.</p>
                <div class="font-bold">{{$events->count()}} events</div>
            </div>
            <span class="text-9xl">📅</span>
        </section>
        <section class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-3 p-4">
        @foreach ($events as $event)
            <article class="border rounded-lg">
                <a href="{{$event->route}}">
                    <div class="w-full h-full relative">
                        <span class="absolute top-0 left-0 w-full h-full bg-black/35 rounded-lg"></span>
                        <img src="{{$event->imageUrl}}" alt="image {{$event->name}}" class="w-full h-auto object-cover rounded-lg" loading="lazy">
                        <h2 class="absolute w-full top-1/2 -translate-y-1/2 text-white z-1 text-2xl font-bold text-center">{{$event->name}}</h2>
                    </div>
                </a>
            </article>
        @endforeach
        </section>
    </main>
@endsection
