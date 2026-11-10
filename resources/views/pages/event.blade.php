@extends('layout')

@section('title', $event->name. ' Emojis List')
@section('description', $event->description ?: '')
@section('image', $event->image_url)

@section('content')
    @include('pages.partials.header')
    <main class="flex-1">
        <section class="bg-white p-6 md:p-12 border-b border-gray-300 flex flex-col-reverse md:flex-row justify-between items-center gap-8">
            <div class="flex flex-col gap-4 max-w-200 text-left">
                <h1 class="text-black text-5xl font-bold">{{$event->name}} Emojis List</h1>
                @if($event->description)
                    <p class="text-md">{{$event->description}}</p>
                @endif
                <div class="font-bold">{{$emojis->count()}} emojis</div>
            </div>
            <span class="text-9xl">{{$event->emoji}}</span>
        </section>
        <div class="flex flex-col lg:flex-row gap-3 lg:gap-5 p-3">
            <section class="w-full lg:w-5/6">
                <div class="grid grid-cols-4 sm:grid-cols-9 md:grid-cols-11 lg:grid-cols-14 xl:grid-cols-16 gap-1">
                    @each('emojis.emoji', $emojis, 'emoji')
                </div>
            </section>
            <section class="w-full lg:w-1/6">
                <x-ad/>
            </section>
        </div>
    </main>
@endsection
