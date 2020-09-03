<div class="dc-yourdetails dc-tabsinfo">
    <div class="dc-tabscontenttitle">
        <h3>{{ trans('lang.your_details') }} </h3>
    </div>
    <div class="dc-formtheme dc-userform">
        <fieldset>
            <!-- <div class="form-group form-group-half">
                <span class="dc-select">
                    {!! Form::select('base_name', Helper::getDoctorArray(), $gender_title, array()) !!}
                </span>
            </div> -->
            <div class="form-group form-group-half">
                {!! Form::text( 'first_name', e(Auth::user()->first_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph.first_name')] ) !!}
            </div>
            <div class="form-group form-group-half">
                {!! Form::text( 'last_name', e(Auth::user()->last_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph.last_name')] ) !!}
            </div>
            <div class="form-group form-group-half">
                {!! Form::number( 'starting_price', e($starting_price) ?? '', ['min' => 0, 'class' =>'form-control', 'placeholder' => trans('lang.starting_price')] ) !!}
            </div>
             <div class="form-group form-group-half">
                {!! Form::text( 'subheading', e($sub_heading), ['class' =>'form-control', 'placeholder' => trans('lang.ph.sub_heading_optional')] ) !!}
            </div>
             <div class="form-group form-group-half">
                {!! Form::tel('phone_number',e(Auth::user()->phone_number), ['class' => 'form-control','placeholder' => trans('lang.ph_num')]) !!}
            </div>
             <div class="form-group form-group-half">
                {!! Form::tel('assistant_phone_number',e(Auth::user()->assistant_phone_number), ['class' => 'form-control','placeholder' => trans('Assistant Phone Number')]) !!}
            </div>
            <div class="form-group">
                {!! Form::text( 'short_desc', e($short_desc), ['class' =>'form-control', 'placeholder' => trans('lang.ph.short_description')] ) !!}
            </div>
        </fieldset>
    </div>



    <div class="dc-yourdetails dc-tabsinfo mt-3">
        <div class="dc-tabscontenttitle">
            <h3>{{ trans('lang.gender') }} </h3>
        </div>
        <div class="dc-formtheme dc-userform">
            <fieldset>
                <div class="form-group la-radio-holder">
                    <label style="display:inline-block"> Male:
                        {!! Form::radio( 'gender','male',($gender == 'male' ? true : false),['id' => 'male']) !!}</label>
                    <label style="display:inline-block; margin-left: 20px">Female:
                        {!! Form::radio('gender','female',($gender == 'female' ? true : false), ['id' => 'female']) !!}
                    </label>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="dc-yourdetails dc-tabsinfo">
        <div class="dc-tabscontenttitle">
            <h3>{{ trans('lang.book_now_video') }} </h3>
        </div>
        <div class="dc-formtheme dc-userform">
            <fieldset>
                <div class="form-group">
                    <label style="display:inline-block">
                        {!! Form::checkbox( 'user_check[]','willing_video','', ['class' =>'form-control'] ) !!} Willing For Video Consultancy</label>
                    <label class="checkbox_text">
                        {!! Form::checkbox( 'user_check[]','willing_home_visit','', ['class' =>'form-control','id'=>'willing_home_visit'] ) !!} Willing To See Paitent At Home </label>
                </div>
            </fieldset>
        </div>
    </div>
</div>
