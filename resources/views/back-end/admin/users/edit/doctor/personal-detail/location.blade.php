<div class="dc-tabscontenttitle">
        <h3>{{ trans('lang.your_loc') }}</h3>
    </div>
    <div class="dc-sidepadding dc-tabsinfo">
        <div class="dc-formtheme dc-userform">
            <fieldset>
                <div class="form-group form-group">
                    <span class="">
{{--                        {!! Form::select('location', $locations, e(Auth::user()->location_id) , array('class' => '','id' =>'userLocation', 'placeholder' => trans('lang.select_locations'))) !!}--}}

                        <select name="location" id="userLocation" class="select2">
                            <option value="" data-tokens="" selected disabled>Choose City</option>
                            @foreach($allLocations as $location)
                                <option value="{{$location->id}}">{{$location->title}}</option>
                            @endforeach
                        </select>

                    </span>
                </div>
                <div class="form-group form-group">
                    <select name="address" id="address" class="select2" data-live-search="true">

                    </select>
                </div>
                {{--@if (!empty($longitude) && !empty($latitude))
                    <div class="form-group dc-formmap">
                        <div class="dc-locationmap">
                            <custom-map :latitude="{{($latitude)}}" :longitude="{{$longitude}}"></custom-map>
                        </div>
                    </div>
                @endif--}}
                 <div class="form-group form-group-half">
                    {!! Form::hidden( 'address_lat', e($add_latitude), ['class' =>'form-control', 'id'=>'address_lat', 'placeholder' => trans('lang.enter_latitude')]) !!}
                </div>
                <div class="form-group form-group-half">
                    {!! Form::hidden( 'address_long', e($add_longitude), ['class' =>'form-control','id'=>'address_long','placeholder' => trans('lang.enter_longitude')]) !!}
                </div>
                <div class="form-group form-group-half">
                    {!! Form::hidden( 'latitude', e($latitude), ['class' =>'form-control','id' => 'latitude', 'placeholder' => trans('lang.enter_latitude')]) !!}
                </div>
                <div class="form-group form-group-half">
                    {!! Form::hidden( 'longitude', e($longitude), ['class' =>'form-control','id' => 'longitude', 'placeholder' => trans('lang.enter_longitude')]) !!}
                </div>

            </fieldset>
        </div>
    </div>

