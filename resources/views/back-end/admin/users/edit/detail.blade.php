<div class="dc-yourdetails dc-tabsinfo">
    <div class="dc-tabscontenttitle">
        <h3> {{ trans('lang.user_details') }} </h3>
    </div>
    <div class="dc-formtheme dc-userform">
        <fieldset>
        <!--  @if ($user_role == 'doctor')
            <div class="dc-name-wrapper">
                    <div class="form-group form-group-half gender-input">
                        <span class="dc-select">
                            {!! Form::select('base_name', Helper::getDoctorArray(), $gender_title, array()) !!}
                    </span>
                    </div>
            @endif -->
            <div class="form-group form-group-half">
                {!! Form::text( 'first_name', e($user->first_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph.first_name')] ) !!}
            </div>
            <div class="form-group form-group-half">
                {!! Form::text( 'last_name', e($user->last_name), ['class' =>'form-control', 'placeholder' => trans('lang.ph.last_name')] ) !!}
            </div>
        <!--  @if ($user_role == 'doctor')
            </div>
            @endif -->
            <div class="form-group form-group-half">
                {!! Form::number( 'starting_price', e($starting_price) ?? '', ['min' => 0, 'class' =>'form-control', 'placeholder' => trans('lang.starting_price')] ) !!}
            </div>
            <div class="form-group form-group-half">
                {!! Form::email( 'email', e($user->email), ['class' =>'form-control', 'placeholder' => trans('lang.ph.email')] ) !!}
            </div>
            <div class="form-group form-group-half">
                {!! Form::password('password', ['class' => 'form-control','placeholder' => trans('lang.ph.newpass')]) !!}
            </div>
            <div class="form-group form-group-half">
                {!! Form::tel('phone_number',e($user->phone_number), ['class' => 'form-control','placeholder' => trans('lang.ph_num')]) !!}
            </div>
            <div class="form-group form-group-half">
                {!! Form::tel('assistant_phone_number',e($user->assistant_phone_number), ['class' => 'form-control','placeholder' => trans('Assistant Phone Number')]) !!}
            </div>
            @if ($user_role != 'patient')
                <div class="form-group">
                    {!! Form::text( 'subheading', e($sub_heading), ['class' =>'form-control', 'placeholder' => trans('lang.ph.sub_heading_optional')] ) !!}
                </div>
                <div class="form-group">
                    {!! Form::text( 'short_desc', e($short_desc), ['class' =>'form-control', 'placeholder' => trans('lang.ph.short_description')] ) !!}
                </div>
            @endif
        </fieldset>
    </div>
</div>
<div class="dc-yourdetails dc-tabsinfo">
    <div class="dc-tabscontenttitle">
        <h3> {{ trans('lang.book_now_video') }} </h3>
    </div>
    <div class="dc-formtheme dc-userform">
        <div class="dc-formtheme dc-userform">
            <fieldset>

                @if ($user_role != 'patient')

                    <div class="form-group video_consultation">
                        <label>

                            <input type="checkbox" name="willing_video" class="willing_video" <?php echo ($willing_video=='on' ? 'checked' : '');?>> Willing For Video Consultancy
                        </label>

                        <label>
                            <input type="checkbox" name="willing_home_visit" class="willing_home_visit" <?php echo ($willing_home_visit=='on' ? 'checked' : '');?>> Willing To See Paitent At Home
                        </label>
                    </div>

                @endif
            </fieldset>
        </div>
    </div>
</div>
<div class="dc-yourdetails dc-tabsinfo">
    <div class="dc-tabscontenttitle">
        <h3> {{ trans('lang.gender') }} </h3>
    </div>
    <div class="dc-formtheme dc-userform">
        <div class="dc-formtheme dc-userform">
            <fieldset>
                <div class="form-group la-radio-holder">

                    <label style="display:inline-block"> Male:  {!! Form::radio( 'gender','male',($gender == 'male' ? true : false),['id' => 'male']) !!}</label>
                    <label style="display:inline-block; margin-left: 20px">Female:
                        {!! Form::radio('gender','female',($gender == 'female' ? true : false), ['id' => 'female']) !!}
                    </label>

                </div>
                <div class="form-group">
                    @if (!empty($roles))
                        <ul class="dc-startoption">
                            @foreach ($roles as $key => $role)
                                @if (!in_array($role['id'] == 1, $roles))
                                    <li>
                                        <span class="dc-radio">
                                            <input id="dc-company-{{$key}}" type="radio" v-on:change="changeRole('dc-company-{{$key}}', '{{$user_role}}')" name="role" value="{{{ $role['role_type'] }}}" {{$user_role == $role['role_type'] ? 'checked' : ''}}>
                                            <label for="dc-company-{{$key}}">{{{ $role['name'] }}}</label>
                                        </span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <div class="dc-description dc-update-role">
                            <p>{{ trans('lang.update_role_note') }}</p>
                        </div>
                    @endif
                </div>
            </fieldset>
        </div>
    </div>
</div>

