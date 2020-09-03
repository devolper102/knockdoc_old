<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($doctors as $doctor)
        <url>
            <loc>{{ URL::route("userProfile", [$doctor->slug]) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($doctor->updated_at)) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach

    @foreach($locations as $location)
        @php $areas = \App\Location::where('parent', $location->id)->get(); @endphp
        @foreach($areas as $area)
            <url>
                <loc>{{ URL::route("doctors-location-area", [$location->slug, $area->slug]) }}</loc>
                <lastmod>{{ gmdate(DateTime::W3C, strtotime($location->updated_at)) }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>1.0</priority>
            </url>
        @endforeach
    @endforeach

    @foreach($locations as $location)
        @if($location->parent === '0')
            <url>
                <loc>{{ URL::route("doctors-by-city", [$location->slug]) }}</loc>
                <lastmod>{{ gmdate(DateTime::W3C, strtotime($location->updated_at)) }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>1.0</priority>
            </url>
        @endif
    @endforeach

    @foreach($specialities as $speciality)
        @foreach($locations as $location)
            <url>
                <loc>{{ URL::route("doctors-speciality-city", [$location->slug, $area->slug]) }}</loc>
                <lastmod>{{ gmdate(DateTime::W3C, strtotime($location->updated_at)) }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>1.0</priority>
            </url>
        @endforeach
    @endforeach

</urlset>