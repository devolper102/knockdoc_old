<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($specialities as $speciality)
        <url>
            <loc>{{ URL::route("diseasesDetails", [$speciality->slug]) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($speciality->updated_at)) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach

    @foreach($locations as $location)
        @foreach($specialities as $speciality)
            <url>
                <loc>{{ URL::route("specialityDetailsLocation", [$speciality->slug, $location->slug]) }}</loc>
                <lastmod>{{ gmdate(DateTime::W3C, strtotime($speciality->updated_at)) }}</lastmod>
                <changefreq>daily</changefreq>
                <priority>1.0</priority>
            </url>
        @endforeach
    @endforeach

    @foreach($specialities as $speciality)
        <url>
            <loc>{{ URL::route("specialityDetails", [$speciality->slug]) }}</loc>
            <lastmod>{{ gmdate(DateTime::W3C, strtotime($speciality->updated_at)) }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach

</urlset>