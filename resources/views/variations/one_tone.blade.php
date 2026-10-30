@use('App\Enums\SkinTone')
@use('App\Enums\Direction')

<div class="flex justify-between items-center">
    <h2 class="text-lg text-gray-600">Variations ({{$variationsCount}})</h2>
    @if($hasDirectionVariation)
        <div class="flex justify-end items-center gap-1">
            @foreach(Direction::cases() as $direction)
                <a
                    href="{{route('pages.emoji', $emoji->directionSlug($direction))}}"
                    @class(["font-medium text-sm px-2 py-1 rounded cursor-pointer", 'text-white bg-black' => $emoji->direction === $direction, 'border border-black text-black'])
                >
                    {{$direction->label()}}
                </a>
            @endforeach
        </div>
    @endif
</div>
<div class="overflow-x-auto">
    <table class="min-w-full border-separate text-sm text-left border-spacing-0">
        <thead>
        <tr>
            <th class="p-3 bg-gray-50 border border-gray-300 sticky top-0 left-0 z-20"></th>
            @foreach(SkinTone::cases() as $skinTone)
                <th scope="col" class="p-3 bg-gray-50 border border-gray-300 font-semibold text-center whitespace-nowrap sticky top-0 z-10">{{$skinTone->label()}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($variations as $gender => $emojis)
            <tr>
                <th scope="row" class="p-3 bg-gray-50  border-l border-r border-b border-gray-300 font-semibold sticky left-0 z-10">{{$gender}}</th>
                @foreach($emojis as $variationEmoji)
                    @if($variationEmoji)
                        @include('emojis.variation_emoji', ['variationEmoji' => $variationEmoji, 'currentEmoji' => $emoji])
                    @else
                        <td class="border text-center border-gray-300"></td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
