@use('Illuminate\Support\Str')

@extends('layout')

@section('title', sprintf('%s %s Emoji Meaning & Copy', $emoji->emoji, Str::title($emoji->name)))
@section('description', $emoji->description)

@section('content')
    @include('pages.partials.header')
    <main class="p-3 flex-1">
        <div class="flex flex-col lg:flex-row gap-3">
            <div class="w-full lg:w-5/6">
                <div class="flex flex-col sm:flex-row gap-2">
                    <div class="bg-white border border-gray-400 shadow-xl w-full sm:w-1/4 flex flex-col gap-5 aling-center justify-center text-center p-4 sm:p-0">
                        <span  id="{{'emojis-'.$emoji->id}}" class="text-8xl selection:bg-transparent">{{$emoji->emoji}}</span>
                        <button
                            x-data="emoji"
                            data-clipboard-target="{{'#emojis-'.$emoji->id}}"
                            type="button"
                            class="font-medium text-sm px-4 py-2 rounded cursor-pointer w-1/2 mx-auto"
                            :class="{'text-white bg-black hover:bg-black/90': !copied, 'text-green-500 bg-green-100 hover:bg-green-200': copied}"
                            @click="copy({{$emoji->id}})"
                        >
                            <div x-show.important="!copied" class="flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <title>copy</title>
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                                    </g>
                                </svg>
                                <span>Copy</span>
                            </div>
                            <div x-show.important="copied" class="flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <title>check</title>
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6L9 17l-5-5"/>
                                </svg>
                                <span>Copied</span>
                            </div>
                        </button>
                    </div>
                    <div class="bg-white border border-gray-400 w-full sm:w-3/4 shadow-xl p-3 flex flex-col gap-3">
                        <h1 class="text-2xl">{{Str::title($emoji->name)}}</h1>
                        @if($emoji->description)
                            <div class="gap-2 flex flex-col">
                                {{$emoji->descriptionHtml}}
                            </div>
                        @endif
                        <hr class="text-gray-200">
                        <h2>Technical Information</h2>
                        <dl class="grid grid-cols-[30%_70%] gap-px overflow-hidden border border-gray-200 bg-gray-200 text-sm w-full lg:w-2/3">
                            <dt class="bg-gray-50 px-4 py-3 text-left font-medium text-gray-700">Code</dt>
                            <dd class="bg-white px-4 py-3 text-left text-gray-900">{{$emoji->codepoint}}</dd>
                            <dt class="bg-gray-50 px-4 py-3 text-left font-medium text-gray-700">Category</dt>
                            <dd class="bg-white px-4 py-3 text-left text-gray-900">{{$emoji->category->name}}</dd>
                            <dt class="bg-gray-50 px-4 py-3 text-left font-medium text-gray-700">Sub Category</dt>
                            <dd class="bg-white px-4 py-3 text-left text-gray-900">{{Str::headline($emoji->subCategory->name)}}</dd>
                            <dt class="bg-gray-50 px-4 py-3 text-left font-medium text-gray-700">Unicode Version</dt>
                            <dd class="bg-white px-4 py-3 text-left text-gray-900">{{$emoji->version}}</dd>
                            <dt class="bg-gray-50 px-4 py-3 text-left font-medium text-gray-700">Keywords</dt>
                            <dd class="bg-white px-4 py-3 text-left text-gray-900">
                                {{$emoji->keywordsAsString ?: $emoji->parent?->keywordsAsString}}
                            </dd>
                        </dl>
                    </div>
                </div>
                @if($variations->isNotEmpty())
                    <div class="bg-white border border-gray-400 shadow-xl text-center p-3 mt-2 w-full flex flex-col gap-4">
                        @include($variationType->view())
                    </div>
                @endif
            </div>
            <div class="w-full lg:w-1/6">
                <x-ad/>
            </div>
        </div>
    </main>
@endsection
