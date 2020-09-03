@extends('front-end.master')
@section('title') @stop
@section('description', '')
@section('keywords', '')
@section('content')
@include('includes.pre-loader')
<div class="container" id="user-profile">
    <doctors-in-pakistan
            :doctors-location="{{$locations}}"
            :top-specialities-data="{{$topspecialities}}"
    >

    </doctors-in-pakistan>
</div>
@endsection
