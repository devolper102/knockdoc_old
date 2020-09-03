<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Response;

class SiteMapController extends Controller
{
    //
    public function diseasesFunction() {
        $diseases = \App\Disease::orderBy("id", "desc")->take(50000)->get();
        $locations = \App\Location::orderBy("id", "desc")->take(50000)->get();
        $content = View::make('front-end.sitemap.diseases', ['diseases' => $diseases, 'locations' => $locations, ]);
        return Response::make($content)->header('Content-Type', 'text/xml;charset=utf-8');

    }
    public function specialitiesFunction() {
        $specialities = \App\Speciality::orderBy("id", "desc")->take(50000)->get();
        $locations = \App\Location::orderBy("id", "desc")->take(50000)->get();

        $content = View::make('front-end.sitemap.specialities',
            ['specialities' => $specialities, 'locations' => $locations]);
        return Response::make($content)->header('Content-Type', 'text/xml;charset=utf-8');

    }
    public function servicesFunction() {
        $services = \App\Service::orderBy("id", "desc")
            ->take(50000) // each Sitemap file must have no more than 50,000 URLs and must be no larger than 10MB
            ->get();
        $locations = \App\Location::orderBy("id", "desc")->take(50000)->get();


        $content = View::make('front-end.sitemap.services', ['services' => $services, 'locations' => $locations]);
        return Response::make($content)->header('Content-Type', 'text/xml;charset=utf-8');

    }
    public function doctorsFunction() {
        $doctors = \App\User::role('doctor')->orderBy("id", "desc")
            ->take(50000)->get();
        $locations = \App\Location::orderBy("id", "desc")->take(50000)->get();
        $specialities = \App\Speciality::orderBy("id", "desc")->take(50000)->get();

        $content = View::make('front-end.sitemap.doctors', ['doctors' => $doctors, 'locations' => $locations, 'specialities'=>$specialities]);
        return Response::make($content)->header('Content-Type', 'text/xml;charset=utf-8');

    }
    public function hospitalsFunction() {

        $hospitals = \App\User::role('hospital')->orderBy("id", "desc")
            ->take(50000)->get();
        $locations = \App\Location::orderBy("id", "desc")->take(50000)->get();
        $specialities = \App\Speciality::orderBy("id", "desc")->take(50000)->get();

        $content = View::make('front-end.sitemap.hospitals', ['hospitals' => $hospitals,'locations' => $locations,'specialities' => $specialities,]);
        return Response::make($content)->header('Content-Type', 'text/xml;charset=utf-8');

    }
    public function symptomsFunction() {
        $symptoms = \App\Symptom::orderBy("id", "desc")
            ->take(50000) // each Sitemap file must have no more than 50,000 URLs and must be no larger than 10MB
            ->get();

        $content = View::make('front-end.sitemap.symptoms', ['symptoms' => $symptoms]);
        return Response::make($content)->header('Content-Type', 'text/xml;charset=utf-8');

    }

}
