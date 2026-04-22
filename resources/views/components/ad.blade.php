@if(config('app.ads_enabled'))
    <div class="mb-3 mx-3 sm:mx-0" x-data="{show: true}" x-show="show">
        <div class="flex justify-between mb-1">
            <span class="text-black text-sm">Ad</span>
            <button @click="show = !show" class="text-black cursor-pointer text-sm">Close</button>
        </div>
        <div class="bg-gray-300 border border-gray-500 h-[200px] overflow-hidden">
            @if(app()->isProduction())
                <ins class="adsbygoogle"
                     style="display:block; width:100%; height: 100%"
                     data-ad-client="ca-pub-3386885268137177"
                     data-ad-slot="9976332725"
                     data-ad-format="auto"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            @else
                <span>Ads here</span>
            @endif
       </div>
    </div>
@endif
