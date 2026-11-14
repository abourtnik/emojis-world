@unless ($breadcrumbs->isEmpty())
    <nav class="w-full">
        <ol class="flex flex-wrap text-sm  text-gray-800 items-center">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li>
                        <a href="{{ $breadcrumb->url }}" class="text-blue-600 hover:text-blue-900 hover:underline focus:text-blue-900 focus:underline">
                            {{ $breadcrumb->title }}
                        </a>
                    </li>
                @else
                    <li>
                        {{ $breadcrumb->title }}
                    </li>
                @endif
                @unless($loop->last)
                    <li class="text-gray-500 px-1">
                        <svg class="size-4 text-muted/50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endunless
