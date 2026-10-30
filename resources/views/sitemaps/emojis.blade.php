{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($emojis as $emoji)
        <url>
            <loc>{{ $emoji->route }}</loc>
        </url>
    @endforeach
</urlset>
