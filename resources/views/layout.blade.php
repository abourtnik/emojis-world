<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{config('app.name')}}</title>
    <meta name="description" content="@yield('description')"/>
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
    <meta name="copyright" content="{{config('app.url')}}" />
    <meta name="author" content="Anton Bourtnik" />

    <meta name="theme-color" content="#FAB42E">
    <meta name="msapplication-navbutton-color" content="#FAB42E">
    <meta name="apple-mobile-web-app-status-bar-style" content="#FAB42E">

    <meta property="og:site_name" content="{{config('app.name')}}" />
    <meta property="og:url" content="{{url()->full()}}" />
    <meta property="og:title" content="@yield('title') - {{config('app.name')}}" />
    <meta property="og:description" content="@yield('description')" />
    <meta property="og:image" content={{asset('images/logo.png')}}>
    <meta property="og:language" content="{{ str_replace('_', '-', app()->getLocale()) }}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{asset('favicon.ico')}}" sizes="any">
    <link rel="apple-touch-icon" href="{{asset('icons/apple-touch-icon.png')}}">

    @if (config('app.statistics_enabled') && !in_array(request()->ip(), config('app.ignore_ips')))
    <script defer src="https://cloud.umami.is/script.js" data-website-id="b72c51a9-871d-4dd2-a951-ade554a3be31"></script>
    @endif

   {{-- @viteReactRefresh--}}
    @vite(['resources/js/app.ts'])
</head>
<body class="bg-gray-200 min-h-screen flex flex-col">
    @yield('content')
    <footer class="h-16 sm:h-12 bg-white flex flex-col sm:flex-row gap-2 items-center justify-center sm:justify-between p-3 border-t border-gray-300">
        <p class="text-xs text-gray-500">Made with ❤️ by <a class="text-blue-500" href="https://github.com/abourtnik">Anton Bourtnik</a> </p>
        <p class="text-xs text-gray-500">Copyright © {{date('Y')}} EmojisWorld - All Rights Reserved</p>
    </footer>
</body>
</html>
