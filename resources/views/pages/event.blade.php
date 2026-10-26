@extends('layout')

@section('title', $event->name. ' Emojis')
@section('description', 'Quickly copy and paste ' .$event->name. ' Emojis')
@section('image', $event->image_url)

@section('content')
    @include('pages.partials.header')
    <main class="flex-1">
        <div class="relative">
            <img class="w-full h-96 object-cover" src="{{$event->image_url}}" alt="event {{$event->name}}">
            <h1 class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white z-1 text-2xl font-bold w-80 text-center">{{$event->name}}</h1>
            <span class="absolute top-0 left-0 w-full h-full bg-black/40"></span>
            <div class="absolute bottom-0 end-0 text-white p-2 font-bold">{{$emojis->count()}} emojis</div>
        </div>
        <section class="container mx-auto mt-3">
            <x-ad/>
        </section>
        <section class="grid grid-cols-5 sm:grid-cols-10 md:grid-cols-12 lg:grid-cols-17 xl:grid-cols-20 gap-1 container mx-auto py-3">
            @each('emojis.emoji', $emojis, 'emoji')
        </section>
    </main>
@endsection
