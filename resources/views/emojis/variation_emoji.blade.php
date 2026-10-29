<td
    @class([
        'border text-center',
        'bg-blue-200 border-blue-300 border-2' => $variationEmoji->is($currentEmoji),
        'border-gray-300' => !$variationEmoji->is($currentEmoji)
    ])
>
    <a class="text-5xl block p-3 w-full h-full" href="{{$variationEmoji->route}}" title="{{$variationEmoji->name}}">
        {{$variationEmoji->emoji}}
    </a>
</td>
