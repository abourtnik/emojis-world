@extends('layout')

@section('title', $event->name. ' Emojis')
@section('description', 'Quickly copy and paste ' .$event->name. ' Emojis')
@section('image', $event->image_url)

@section('content')
    <header class="h-16 bg-white flex items-center justify-between p-3 border-b border-gray-300">
        <a href="{{route('pages.index')}}" class="flex items-center space-x-3">
            <img src="{{asset('images/logo.png')}}" class="h-8" alt="{{config('app.name')}} Logo">
            <span class="self-center text-xl sm:text-2xl font-semibold whitespace-nowrap text-yellow-500">{{config('app.name')}}</span>
        </a>
        <h1 class="text-xl sm:text-2xl text-center hidden sm:block">✂️ Copy and 📋 Paste Emoji Keyboard</h1>
        <a class="text-white bg-black hover:bg-black/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs sm:text-sm px-3 py-2 text-center" href={{route('pages.api')}}>
            Try our API
        </a>
    </header>
    <main class="flex-1">
        <div class="relative">
            <img class="w-full h-96 object-cover" src="{{$event->image_url}}" alt="event {{$event->name}}">
            <h1 class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white z-1 text-2xl font-bold">{{$event->name}}</h1>
            <span class="absolute top-0 left-0 w-full h-full bg-black/40"></span>
            <div class="absolute bottom-0 end-0 text-white p-2 font-bold">{{$emojis->count()}} emojis</div>
        </div>
        <section class="grid grid-cols-5 sm:grid-cols-10 md:grid-cols-12 lg:grid-cols-17 xl:grid-cols-20 gap-1 container mx-auto py-3">
            @each('emojis.emoji', $emojis, 'emoji')
        </section>
    </main>
@endsection
