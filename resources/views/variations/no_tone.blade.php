@use('App\Enums\Gender')

<div class="flex">
    <h2 class="text-lg text-gray-600">Variations ({{$variationsCount}})</h2>
</div>
<div class="overflow-x-auto">
    <table class="min-w-full border-separate text-sm text-left border-spacing-0">
        <thead>
        <tr>
            @foreach(Gender::withoutMix() as $gender)
                <th scope="col" class="p-3 bg-gray-50 border border-gray-300 font-semibold text-center whitespace-nowrap sticky top-0 z-10">{{$gender->label()}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($variations as $gender => $emojis)
            <tr>
                @foreach($emojis as $variationEmoji)
                    @include('emojis.variation_emoji', ['variationEmoji' => $variationEmoji, 'currentEmoji' => $emoji])
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
