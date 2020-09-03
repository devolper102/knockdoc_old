@extends('front-end.master') 
@section('description', '') 
@section('keywords', '') 
@section('content')
<div class="container" id="user-profile">
    <hospitals-in-pakistan
            :hospitals-location="{{$locations}}"
            :top-specialities-data="{{$topspecialities}}"
    ></hospitals-in-pakistan>
    
</div>

@endsection