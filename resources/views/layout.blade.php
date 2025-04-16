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

    <meta name="google-site-verification" content="QvvYRETEgZ3Rwiv1CcJVSA4azGqIwWgWvWpE1fU7WJE">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (config('app.statistics_enabled'))
        <script defer src="https://stats.antonbourtnik.fr/script.js" data-website-id="42ab7417-1920-4a14-a7e8-59d54df89726"></script>
    @endif

   {{-- @viteReactRefresh--}}
    @vite(['resources/js/app.ts'])
</head>
<body class="bg-gray-200 min-h-screen flex flex-col">
    @yield('content')
</body>
</html>
