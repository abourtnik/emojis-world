@extends('layout')

@section('title', 'Page not found')
@section('description', 'Page not found')

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
    <section class="container mx-auto py-3 flex-1 flex justify-center items-center">
        <div class="flex flex-col items-center bg-white px-3 py-8 border border-gray-300 justify-center w-full text-center">
            <div class="text-8xl mb-4">😅</div>
            <h2 class="text-3xl my-3 font-bold uppercase">oops ! Page not found</h2>
            <p class="text-md text-black">The page you are looking for cannot be found</p>
            <a href="{{route('pages.index')}}" class="mt-8 text-white bg-black hover:bg-black/90 font-medium rounded-lg text-sm px-3 py-2 text-center text-uppercase">
                Back to Home
            </a>
        </div>
    </section>
@endsection
