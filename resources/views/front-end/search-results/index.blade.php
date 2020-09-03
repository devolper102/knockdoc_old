@extends('front-end.master')
@section('title'){{ clean($search_list_meta_title) }} @stop
@section('description', clean($search_list_meta_desc))
@section('keywords', '')
@section('content')
@include('includes.pre-loader')
<div class="dc-breadcrumbarea">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ol class="dc-breadcrumb">
                    <li><a href="{{ url('/') }}">{{ trans('lang.home') }}</a></li>
                    @php
                        $segments = '';
                    @endphp
                    @foreach(Request::segments() as $key => $segment)
                        @php
                            $segments .= '/'.$segment;
                        @endphp
                        <li>
                            <a href="/.{{$segments}}">{{$segment}}</a>
                        </li>
                    @endforeach

                    {{--<li>{{ trans('lang.dermatology') }}</li>--}}
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" id="user-profile">
    <div class="row">
    <div class="dc-main-section">
        <div class="dc-preloader-section" v-if="loading" v-cloak>
            <div class="dc-preloader-holder">
                <div class="dc-loader"></div>
            </div>
        </div>

            <div id="dc-twocolumns" class="dc-twocolumns dc-haslayout">
                @php $columns = 'col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'; @endphp
                    @include('front-end.includes.inner-banner')
                <div class="{{ $columns }} float-left">
                    <div class="dc-searchresult-holder">
                        <div class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo la-searchvlistvtwo">
                                @if (!empty($users) && $users->count() > 0)
                                @php
                                    $users_id = $users->pluck('id');
                                    $users_data = $AllUsers->whereIn('id',$users_id)->get();
                                    $location = !empty($location) ? $location : [];
                                    $service = !empty($service) ? $service : [];
                                    $diseases = !empty($diseases) ? $diseases : [];
                                    $speciality = !empty($speciality) ? $speciality : [];
                                    $faqs = !empty($faqs) ? $faqs : [];
                                    $keyword = !empty($keyword);
                                @endphp
                                    <search-page
                                            :user-data="{{$users_data}}"
                                            :result-type="'{{json_encode($type, true) }}'"
                                            :result-location="{{json_encode($location, true) }}"
                                            :result-service="{{json_encode($service, true) }}"
                                            :result-diseases="{{json_encode($diseases, true) }}"
                                            :result-speciality="{{json_encode($speciality, true)}}"
                                            :result-faqs="{{json_encode($faqs, true)}}"
                                            :result-keywords="{{json_encode($keyword, true)}}"
                                    ></search-page>
                                @else
                                    @include('errors.no-record')
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('front_end_scripts')
    <script src="https://sandbox.jazzcash.com.pk/Sandbox/Scripts/hmac-sha256.js"></script>

    @if(!empty($script_data_doctor))
        @foreach($script_data_doctor as $script)
<script type="application/ld+json">
    {!! $script !!}
</script>
        @endforeach
    @endif
     @if(!empty($script_data_hospital))
        @foreach($script_data_hospital as $script)
            <script type="application/ld+json">
                {!! $script !!}
            </script>
        @endforeach
    @endif

     @if(!empty($script_data_breadCrumbs))
        @foreach($script_data_breadCrumbs as $script)
            <script type="application/ld+json">
                {!! $script !!}
            </script>
        @endforeach
    @endif
     @if(!empty($script_data_faqs))
        @foreach($script_data_faqs as $script)
            <script type="application/ld+json">
                {!! $script !!}
            </script>
        @endforeach
    @endif
     @if(!empty($script_data_localBusiness))
        @foreach($script_data_localBusiness as $script)
            <script type="application/ld+json">
                {!! $script !!}
            </script>
        @endforeach
    @endif
    @if(!empty($script_data_organization))
        @foreach($script_data_organization as $script)
            <script type="application/ld+json">
                {!! $script !!}
            </script>
        @endforeach
    @endif
@endpush