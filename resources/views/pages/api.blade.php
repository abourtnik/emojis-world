@extends('layout')

@section('title', 'Open Source REST API for Emojis')
@section('description', "Emojis World is a Open Source REST API allows developers to simply integrate all of the best emojis into their applications. More than $emojis_count are available.")

@section('content')
    <header class="h-16 bg-white flex items-center justify-between p-3 border-b border-gray-300">
        <a href="{{route('pages.index')}}" class="flex items-center space-x-3">
            <img src="{{asset('images/logo.png')}}" class="h-8" alt="{{config('app.name')}} Logo">
            <span class="self-center text-xl sm:text-2xl font-semibold whitespace-nowrap text-yellow-500">{{config('app.name')}}</span>
        </a>
        <a href="https://github.com/abourtnik/emojis-world" target="_blank" class="no-underline">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" class="w-8">
                <path d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3 .3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5 .3-6.2 2.3zm44.2-1.7c-2.9 .7-4.9 2.6-4.6 4.9 .3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3 .7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3 .3 2.9 2.3 3.9 1.6 1 3.6 .7 4.3-.7 .7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3 .7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3 .7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"></path>
            </svg>
        </a>
    </header>
    <section class="bg-gray-700 h-100 flex items-center">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl lg:text-6xl text-white">Open Source REST API For Emojis</h1>
            <h2 class="mb-8 text-lg font-normal lg:text-xl sm:px-16 text-white">A free emoji sourced directly from unicode.org - {{$emojis_count}} emojis available</h2>
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                <a
                    href="https://github.com/abourtnik/emojis-world"
                    class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-indigo-600"
                    target="_blank"
                >
                    <span>Get started</span>
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <section class="container mx-auto my-10">
        <section class="bg-white p-5 rounded border border-gray-300">
            <h3 class="text-2xl my-3 font-bold">Endpoints</h3>
            <hr class="text-gray-300">
            @foreach($endpoints as $index => $endpoint)
                <section class="my-4">
                    <h4 class="text-xl my-3 font-bold">{{$endpoint['name']}}</h4>
                    <div class="flex items-start gap-4 flex-wrap lg:flex-nowrap">
                        <div class="w-full">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="border border-blue-300 py-0.5 px-2 bg-blue-100 text-blue-500 rounded-3xl">GET</div>
                                <div class="relative w-full">
                                    <input
                                        id="{{'endpoint-'. $index}}"
                                        type="text"
                                        class="col-span-6 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full px-2.5 py-4"
                                        value="{{config('app.api_url') .'/v'.config('app.api_version'). $endpoint['path']}}"
                                        readonly
                                    >
                                    <button
                                        data-clipboard-target="{{'#endpoint-'. $index}}"
                                        class="absolute end-2.5 top-1/2 -translate-y-1/2 text-gray-900 hover:bg-gray-100 rounded-lg py-2 px-2.5 inline-flex items-center justify-center bg-white border-gray-200 border h-8 cursor-pointer"
                                        x-data="{copied: false}"
                                        @click="copied = true;setInterval(() => copied = false, 2000)"
                                    >
                                        <span x-show="!copied">
                                            <span class="inline-flex items-center">
                                                <svg class="w-3 h-3 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                                    <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                                                </svg>
                                                <span class="text-xs font-semibold">Copy</span>
                                            </span>
                                        </span>
                                        <span x-show="copied">
                                            <span class="inline-flex items-center">
                                                <svg class="w-3 h-3 text-blue-700 dark:text-blue-500 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                                </svg>
                                                <span class="text-xs font-semibold text-blue-700">Copied</span>
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <p class="text-black">{{$endpoint['description']}}</p>
                            @isset($endpoint['params'])
                                <div class="mt-8 mb-3">
                                    <h4 class="text-lg font-bold">Search parameters</h4>
                                    @foreach($endpoint['params'] as $param)
                                        <div class="my-5">
                                            <div class="flex items-center gap-4 mb-2">
                                                <span class="bg-gray-50 border border-gray-300 px-2 rounded">{{$param['name']}}</span>
                                                <div class="flex gap-1">
                                                    @if($param['required'])
                                                        <span class="font-bold text-gray-500">required</span>
                                                    @else
                                                        <span class="text-gray-500">optional</span>
                                                    @endif
                                                    <span class="text-gray-500">-</span>
                                                    <code class="text-gray-500">{{$param['type']}}</code>
                                                </div>
                                            </div>
                                            <p class="text-sm text-black">{{$param['description']}}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endisset
                        </div>
                        <div class="border rounded-lg border-gray-300 w-full ">
                            <div class="bg-gray-100 p-3 border-b border-gray-300">
                                <div class="flex justify-between items-center mb-3">
                                    <div class="text-black font-bold">Response</div>
                                    <code class="text-black">application/json</code>
                                </div>
                                <div class="text-gray-500 break-all text-sm">{{config('app.api_url') .'/v'.config('app.api_version'). $endpoint['example']}}</div>
                            </div>
                            <div class="h-100 bg-gray-200 px-3 py-2 overflow-y-auto"><pre><code class="whitespace-pre">{{json_encode($endpoint['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)}}</code></pre>
                            </div>
                        </div>
                    </div>
                </section>
            @endforeach
        </section>
    </section>
@endsection
