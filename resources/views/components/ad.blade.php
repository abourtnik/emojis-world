@if(config('app.ads_enabled'))
    <div class="h-full flex flex-col min-h-[300px]">
        <div class="flex justify-between mb-1">
            <span class="text-black text-sm">Ad</span>
        </div>
        <div class="flex items-center justify-center bg-gray-300 border border-gray-500 flex-1 overflow-hidden">
            @if(app()->isProduction())
                <ins class="adsbygoogle"
                     style="display:block; width:100%; height: 100%"
                     data-ad-client="ca-pub-3386885268137177"
                     data-ad-slot="9976332725"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            @else
                <span class="font-bold">Ad here</span>
            @endif
       </div>
    </div>
@endif
