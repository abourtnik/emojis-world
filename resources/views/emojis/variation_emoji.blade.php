<td
    @class([
        'border text-center',
        'bg-blue-200 border-blue-300 border-2' => $variationEmoji->is($currentEmoji),
        'border-gray-300' => !$variationEmoji->is($currentEmoji)
    ])
>
    @if ($variationEmoji->is($currentEmoji))
        <span
            class="text-5xl block p-3 w-full h-full"
            role="img"
            aria-label="{{ $variationEmoji->name }}"
            aria-current="page"
        >
            {{ $variationEmoji->emoji }}
        </span>
    @else
        <a
            class="text-5xl block p-3 w-full h-full"
            href="{{ $variationEmoji->route }}"
            title="{{ $variationEmoji->name }}"
            aria-label="{{ $variationEmoji->name }}"
        >
            <span aria-hidden="true">{{ $variationEmoji->emoji }}</span>
        </a>
    @endif
</td>
