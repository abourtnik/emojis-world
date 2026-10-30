@use('App\Enums\SkinTone')
@use('App\Enums\Gender')

<div class="flex justify-between items-center">
    <h2 class="text-lg text-gray-600">Variations ({{$variationsCount}})</h2>
    <div class="flex justify-end items-center gap-1">
        @foreach(Gender::cases() as $gender)
            <a
                href="{{$emoji->genderSlugMultiple($gender)}}"
                @class(["font-medium text-sm px-2 py-1 rounded", 'text-white bg-black' => $emoji->gender === $gender, 'border border-black text-black'])
            >
                {{$gender->pluralLabel()}}
            </a>
        @endforeach
    </div>
</div>
<div class="overflow-x-auto">
    <table class="min-w-full border-separate text-sm text-left border-spacing-0">
        <thead>
            <tr>
                <th class="p-3 bg-gray-50 border border-gray-300 sticky top-0 left-0 z-20"></th>
                @foreach(SkinTone::cases() as $skinTone)
                    <th scope="col" class="p-3 bg-gray-50 border border-gray-300 font-semibold text-center whitespace-nowrap sticky top-0 z-10">
                        {{$skinTone->label()}}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
        @foreach($variations as $skinTone => $emojis)
            <tr>
                <th scope="row" class="p-3 bg-gray-50  border-l border-r border-b border-gray-300 font-semibold sticky left-0 z-10">{{$skinTone}}</th>
                @if($skinTone !== SkinTone::None->label())
                    <td class="border text-center border-gray-300 bg-gray-200 cursor-not-allowed"></td>
                @endif
                @foreach($emojis as $variationEmoji)
                    @include('emojis.variation_emoji', ['variationEmoji' => $variationEmoji, 'currentEmoji' => $emoji])
                @endforeach
                @if($skinTone === SkinTone::None->label())
                    @foreach(range(1, count(SkinTone::cases()) - 1) as $i)
                        <td class="border text-center border-gray-300 bg-gray-200 cursor-not-allowed"></td>
                    @endforeach
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
