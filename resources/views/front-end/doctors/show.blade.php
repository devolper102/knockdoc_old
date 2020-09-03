@extends('front-end.master')
@section('title'){{ Helper::getUserName($user->id) }} @stop
@section('description', clean($user->profile->description))
@section('keywords', '')
@push('PackageStyle')
    <link href="{{ asset('css/antd.css') }}" rel="stylesheet">
    <link href="{{ asset('css/prettyPhoto.css') }}" rel="stylesheet">
@endpush
@section('content')
@include('includes.pre-loader')
    {!! Helper::displayBreadcrumbs('userProfile', $user) !!}
    <div class="dc-haslayout dc-main-section" id="user-profile">
        @if (Session::has('message'))
            <div class="flash_msg">
                <flash_messages :message_class="'success'" :time ='5' :message="'{{{ Session::get('message') }}}'" v-cloak></flash_messages>
            </div>
        @elseif (Session::has('error'))
            <div class="flash_msg">
                <flash_messages :message_class="'danger'" :time ='5' :message="'{{{ Session::get('error') }}}'" v-cloak></flash_messages>
            </div>
        @endif
        <div class="dc-preloader-section" v-if="loading" v-cloak>
            <div class="dc-preloader-holder">
                <div class="dc-loader"></div>
            </div>
        </div>

        @if ($display_chat == true)
            @if (Auth::user())
                @if ($user->id != Auth::user()->id && $role_type != 'hospital')
                    <chat 
                        :trans_image_alt="'{{trans('lang.img')}}'" 
                        :ph_new_msg="'{{ trans('lang.ph_new_msg') }}'" 
                        :trans_placeholder="'{{ trans('lang.ph_type_msg') }}'" 
                        :receiver_id="'{{$user->id}}'" 
                        :receiver_profile_image="'{{{ asset(Helper::getImage('uploads/users/'.$user->id.'/', $user->profile->avatar, 'medium-', 'user.jpg')) }}}'"
                        :empty_error="'{{trans('lang.empty_fields_not_allowed')}}'">
                    </chat>
                @endif
            @endif
        @endif
        @php $columns = 'col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'; @endphp
        @if ($display_sidebar == 'true')
            @php
                $columns = 'col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-9';
            @endphp
        @endif
        <div class="container">
            <div class="row">
                <div class="dc-twocolumns dc-haslayout">
                    <div class="{{ $columns }} float-left">
                        <div class="dc-docsingle-header">
                            <figure class="dc-docsingleimg">
                                <img src="{{ asset(Helper::getImage('uploads/users/'.$user->id.'/', $user->profile->avatar)) }}"
                                     alt="{{$user->profile->avatar}}" alt-text="{{$user->first_name}}.' '.{{$user->last_name}}">
                                @if ($featured == 'true')
                                    <figcaption>
                                        <span class="dc-featuredtag"><i class="fa fa-bolt"></i></span>
                                    </figcaption>
                                @endif
                            </figure>
                            <div class="dc-docsingle-content">
                                <div class="dc-title">
                                    <h2>
                                        <a href="javascript:void(0);">
                                            {{ !empty($gender_title) ? Helper::getDoctorArray(clean($gender_title)) : '' }} {{ Helper::getUserName($user->id) }} 
                                        </a> 
                                        {{ Helper::verifyUser(intVal(clean($user->id)), true) }}
                                        {{ Helper::verifyMedical(intVal(clean($user->id)), true) }} 
                                    </h2>
                                    <ul class="dc-docinfo">
                                        @if($user->profile->total_experience > 0)
                                            <li><em><b>{{ html_entity_decode(clean($user->profile->total_experience)) ?? '' }} Year</b> Experience</em></li>
                                        @endif
                                        <li><em>{{ html_entity_decode(clean($user->profile->sub_heading)) ?? '' }}</em></li>
                                        <li>
                                            @if($user->feedbacks->count() > 0)
                                                <span class="dc-stars"><span style="width: {{ $stars }}%;"></span></span><em>{{ clean($user->feedbacks->count()) }} {{ trans('lang.feedbacks') }}</em>
                                            @else
                                                <span class="dc-stars"><span style="width: {{ $stars }}%;"></span></span><em>{{ trans('lang.no_feedback') }}</em>
                                            @endif
                                        </li>
                                        <li>{{ html_entity_decode(clean($query_desc)) }}</li>
                                    </ul>
                                    @if (in_array($user->id,array($saved_doctors)))
                                        <a href="javascrip:void(0);" class="dc-like dc-clicksave dc-btndisbaled">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    @else
                                        <a href="javascrip:void(0);" class="dc-like" id="doctor-{{ intVal(clean($user->id)) }}" @click.prevent="add_wishlist('doctor-{{ intVal(clean($user->id)) }}', '{{ intVal(clean($user->id)) }}', 'saved_doctors', '')" v-cloak>
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    @endif
                                </div>
                                <div class="dc-description">
                                    <p>{{  html_entity_decode(clean($user->profile->description)) ?? '' }}</p>
                                </div>
                                <div class="dc-btnarea doctor_detail_btn">
                                    <a href="javascript:void(0);" class="dc-btn feedback-btn" v-b-modal.modal-md v-on:click="showModal('feedback_modal', {{$user->id}},'{{ ( Auth::check() && Helper::getRoleTypeByUserID(Auth::user()->id) == 'patient' ? 'authorise' : 'not_authorise' ) }}')">{{ trans('lang.add_feedback') }}</a>
                                    @if(Auth::check())
                                        <a href="javascript:void(0);" class="dc-btn" v-b-modal.modal-sm v-on:click="showModal('appointment_modal', {{$user->id}}, '{{ (Auth::check() && Helper::getRoleTypeByUserID(Auth::user()->id) == 'patient' ? 'authorise' : 'not_authorise' ) }}', '{{count($teams)}}' )">{{ trans('lang.book_now') }}</a>
                                    @else
                                        <a href="javascript:void(0);" class="dc-btn" v-b-modal.modal-sm v-on:click="showModal('appointment_modal', 'authorise', '','{{count($teams)}}' )">{{ trans('lang.book_now') }}</a>
                                    @endif

                                    @php
                                        $online_cons = $teams->where('user_id', 'online');
                                    @endphp
                                    @if(Auth::check())
                                        <a href="javascript:void(0);" class="dc-btn" v-b-modal.modal-sm v-on:click="showModal('online_consultation_modal', '{{ (Auth::check() && Helper::getRoleTypeByUserID(Auth::user()->id) == 'patient' ? 'authorise' : 'not_authorise' ) }}', '{{count($online_cons)}}' )" <?php if (count($online_cons) < '1'){ ?> disabled <?php   } ?> > {{ trans('lang.book_now_video')}} </a>
                                    @else
                                        <a href="javascript:void(0);" class="dc-btn" v-b-modal.modal-sm v-on:click="showModal('online_cons_reg_modal', 'authorise', '{{count($online_cons)}}' )" <?php if (count($online_cons) < '1'){ ?> disabled <?php   } ?> > {{ trans('lang.book_now_video')}} </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 float-left">
                         @if (!empty($display_query_section) && $display_query_section == 'true')
                            @include('front-end.sidebar.ask-online')
                        @endif
                    </div>
                    <div class="{{ $columns }} float-left">
                        <div class="dc-docsingle-holder">
                            <ul class="dc-navdocsingletab doctor_tabs nav navbar-nav">
                                <li class="nav-item">
                                    <a class="active" id="locations-tab" data-toggle="tab" href="#location_tab">{{ trans('lang.available_locs') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a id="userdetails-tab" data-toggle="tab" href="#userdetails">{{ trans('lang.detail_gallery') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a id="faq-tab" data-toggle="tab" href="#doc-faq">{{ trans('lang.faq') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a id="feedback-tab" data-toggle="tab" href="#feedback" autofocus>{{ trans('lang.feedback') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a id="articles-tab" data-toggle="tab" href="#doc-articles">{{ trans('lang.articles') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a id="consultation-tab" data-toggle="tab" href="#consultation">{{ trans('lang.online_consultation') }}</a>
                                </li>

                            </ul>
                            <div class="tab-content dc-haslayout">
                                <div class="dc-contentdoctab dc-location-holder tab-pane fade active show" id="location_tab">
                                    <div class="dc-searchresult-holder">
                                        <div class="dc-searchresult-head">
                                            <div class="dc-title"><h4>“{{ !empty($gender_title) ? Helper::getDoctorArray(clean($gender_title)) : '' }} {{ Helper::getUserName($user->id) }}” {{ trans('lang.locations') }}</h4></div>
                                        </div>
                                        @include('front-end.doctors.profile-details.locations.index')
                                    </div>
                                    @include('front-end.doctors.profile-details.share-profile.index')
                                </div>
                                <div class="dc-contentdoctab dc-userdetails-holder tab-pane" id="userdetails">
                                    <div class="dc-aboutdoc dc-aboutinfo">
                                        <div class="dc-infotitle">
                                            <h3>
                                                {{ trans('lang.about') }}
                                                “{{ !empty($gender_title) ? Helper::getDoctorArray(clean($gender_title)) : '' }} {{ Helper::getUserName($user->id) }}”
                                            </h3>
                                        </div>
                                        <div class="dc-description"><p>{{  html_entity_decode(clean($user->profile->description)) }}</p></div>
                                    </div>
                                    @if (!empty($gallery_images))
                                        <div class="dc-aboutgallery-holder dc-aboutinfo">
                                            <div class="dc-infotitle">
                                                <h3>{{ trans('lang.gallery') }}</h3>
                                            </div>
                                            <div class="dc-aboutgallery">
                                                <div class="dc-aboutgallery-img">
                                                    @foreach ($gallery_images as $gallery_image)
                                                        <figure>
                                                            <a data-rel="prettyPhoto[video]" href="{{asset('/uploads/users/'.$user->id.'/gallery/images/'.$gallery_image)}}" rel="prettyPhoto[video]">
                                                                <img src="{{ asset(Helper::getImage('uploads/users/'.$user->id.'/gallery/images/', $gallery_image, 'small-', '')) }}" alt="image description"><i class="ti-plus"></i>
                                                            </a>
                                                        </figure>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if (!empty($gallery_videos))
                                        <div class="dc-aboutgallery-video dc-aboutinfo">
                                            <div class="dc-infotitle">
                                                <h3>{{ trans('lang.gallery_videos') }}</h3>
                                            </div>
                                            <div class="dc-aboutgallery">
                                                <div class="dc-aboutgallery-img">
                                                    @foreach ($gallery_videos as $gallery_video)

                                                        <figure>
                                                            @php
                                                                $width 	= 367;
                                                                $height 		= 206;
                                                                $url = parse_url($gallery_video['url']);
                                                                if ( isset( $url['host'] ) && ( $url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com' ) ) {
                                                                    $content_exp = explode("/", $media);
                                                                    $content_vimo = array_pop($content_exp);
                                                                    echo '<iframe width="' . intval($width) . '" height="' . intval($height) . '" src="https://player.vimeo.com/video/' . $content_vimo . '"
                                                            ></iframe>';
                                                                } elseif ( isset( $url['host'] ) && $url['host'] == 'soundcloud.com') {
                                                                    $video = wp_oembed_get($media, array('height' => intval($height)));
                                                                    $search = array('webkitallowfullscreen', 'mozallowfullscreen', 'frameborder="no"', 'scrolling="no"');
                                                                    $video = str_replace($search, '', $video);
                                                                    echo str_replace('&', '&amp;', $video);
                                                                } else {
                                                                    echo '<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.str_replace("v=", '', $url['query'] ?? '').'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                                                }
                                                            @endphp
                                                        </figure>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @include('front-end.doctors.profile-details.user-details.offered-services')
                                    @include('front-end.doctors.profile-details.user-details.experience')
                                    @include('front-end.doctors.profile-details.user-details.education')
                                    @include('front-end.doctors.profile-details.user-details.awards')
                                    @include('front-end.doctors.profile-details.user-details.memberships')
                                    @include('front-end.doctors.profile-details.user-details.registrations')
                                    @include('front-end.doctors.profile-details.user-details.downloads')
                                    @include('front-end.doctors.profile-details.share-profile.index')
                                </div>
                                <div class="dc-contentdoctab dc-location-holder tab-pane" id="doc-faq">
                                    <div class="dc-searchresult-holder">
                                        
                                        @include('front-end.doctors.profile-details.faq.faq')
                                    </div>
                                    
                                </div>
                                <div class="dc-contentdoctab dc-feedback-holder tab-pane" id="feedback">
                                    <div class="dc-feedback">
                                        <div class="dc-searchresult-head">
                                            <div class="dc-title"><h4>{{ trans('lang.patient_feedback') }}</h4></div>
                                        </div>
                                        <div class="dc-consultation-content dc-feedback-content">
                                            @if (!empty($user->feedbacks) && $user->feedbacks->count() > 0 )
                                                @foreach ($user->feedbacks as $feedback)
                                                    @if($feedback->approval == '1')
                                                        <div class="dc-consultation-details">
                                                            @if($feedback->approval == '1')
                                                                @if ($feedback->keep_anonymous == 'off')
                                                                    @php $patient = App\User::findOrFail($feedback->patient_id); @endphp
                                                                    <figure class="dc-consultation-img">
                                                                        <img src="{{ asset(Helper::getImage('uploads/users/'.$patient->id.'/', $patient->profile->avatar, 'small-', 'user-logo-def.jpg')) }}"
                                                                             alt="{{$user->profile->avatar}}" alt-text="{{$user->first_name}}.' '.{{$user->last_name}}">
                                                                    </figure>
                                                                    <div class="dc-consultation-title">
                                                                        <h5><a href="javascript:void(0);"><em>{{ Helper::getUserName($feedback->patient_id) }} {{ Helper::verifyUser(clean($feedback->patient_id)) }}</em></a></h5>
                                                                        <span>{{ \Carbon\Carbon::parse($feedback->created_at)->format('M d, Y') }}</span>
                                                                    </div>
                                                                @else
                                                                    <figure class="dc-consultation-img">
                                                                        <img src="{{ asset(Helper::getImage('', '', '', 'user-logo-def.jpg')) }}" alt="{{ trans('lang.img_desc') }}">
                                                                    </figure>
                                                                    <div class="dc-consultation-title">
                                                                        <h5><a href="javascript:void(0);"><em>{{ trans('lang.anonymous') }}</em></a></h5>
                                                                        <span>{{ \Carbon\Carbon::parse($feedback->created_at)->format('M d, Y') }}</span>
                                                                    </div>
                                                                @endif

                                                                <div class="rating_stars">
                                                                    <span class="dc-stars"><span style="width: 75%;"></span></span>
                                                                </div>
                                                                <div class="doctor_recomend">
                                                                    <label for="yes">
                                                                        <i class="ti-thumb-up"></i> Yes I recommend the doctor
                                                                    </label>
                                                                    <!-- <label for="no">
                                                                        <i class="ti-thumb-down"></i> No I recommend the doctor
                                                                    </label> -->
                                                                </div>
                                                                @php
                                                                    $ratings = unserialize($feedback->rating);
                                                                    $behaviour = $ratings[0];
                                                                    $communication = $ratings[1];
                                                                    $humble = $ratings[2];
                                                                    $safety  = $ratings[3];
                                                                    $time = $feedback->waiting_time;
                                                                    $waitings = '';
                                                                    if ($time == 1) {
                                                                        $waitings = "0 to 15 mins";
                                                                    }
                                                                    elseif ($time == 2){
                                                                        $waitings = "15 to 30 mins";
                                                                    }
                                                                    elseif ($time == 3){
                                                                        $waitings = "30 min to 1 hr";
                                                                    }
                                                                    else {
                                                                        $waitings = "More than 1 hour";
                                                                    }
                                                                @endphp
                                                                <div class="doctor_info">
                                                                    <span>Average Wait Time</span>
                                                                    <span class="total_duration">{{$waitings}}</span>

                                                                    <div class="doc_detials">
                                                                        <label>Behavior of Doctor</label>
                                                                        <span class="dc-stars doc_performance"><span style="width: {{$behaviour['rating']/5*100}}%;"></span></span>
                                                                    </div>
                                                                    <div class="doc_detials">
                                                                        <label>Doctor communication skills</label>
                                                                        <span class="dc-stars doc_performance"><span style="width: {{$communication['rating']/5*100}}%;"></span></span>
                                                                    </div>
                                                                    <div class="doc_detials">
                                                                        <label>Was the doctor humble</label>
                                                                        <span class="dc-stars doc_performance"><span style="width: {{$humble['rating']/5*100}}%;"></span></span>
                                                                    </div>
                                                                    <div class="doc_detials">
                                                                        <label>Safety measures taken by doctor</label>
                                                                        <span class="dc-stars doc_performance"><span style="width: {{$safety['rating']/5*100}}%;"></span></span>
                                                                    </div>
                                                                </div>
                                                                    <div class="dc-description">
                                                                        <p>{{  html_entity_decode(clean($feedback->comment)) }}</p>
                                                                    </div>
                                                                    <div class="dc-consultation-title" style="overflow: unset !important;;">
                                                                        <span>{{ $feedback->user()->first()->phone_number }}</span>
                                                                    </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endforeach
                                                <a href="javascript:void(0);" class="dc-btn feedback-btn" v-b-modal.modal-md v-on:click="showModal('feedback_modal', {{$user->id}},'{{ ( Auth::check() && Helper::getRoleTypeByUserID(Auth::user()->id) == 'patient' ? 'authorise' : 'not_authorise' ) }}')">{{ trans('lang.add_feedback') }}</a>
                                                @if ( method_exists($user->feedbacks,'links') )
                                                    {{ $user->feedbacks->links('pagination.custom') }}
                                                @endif
                                            @else
                                                @include('errors.no-record')
                                            @endif
                                        </div>

                                        

                                    </div>

                                    @include('front-end.doctors.profile-details.share-profile.index')
                                </div>
                                <div class="dc-contentdoctab dc-articles-holder tab-pane" id="doc-articles">
                                    @include('front-end.doctors.profile-details.articles.index')
                                </div>
                                <div class="dc-contentdoctab dc-consultation-holder tab-pane" id="consultation">
                                    @include('front-end.doctors.profile-details.consultation.index')
                                    @include('front-end.doctors.profile-details.share-profile.index')
                                </div>


                            </div>
                        </div>
                    </div>
                    @if ($display_sidebar == 'true')
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 float-left">
                            @include('front-end.sidebar.index')
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{--  FeedBack Modal  --}}
        <b-modal ref="feedback_modal" class="dc-feedbackpopup" id="la-addfeedbackpopup" size="md" hide-footer title="{{ trans('lang.add_feedback') }}" no-close-on-backdrop>
            <div class="dc-appointmentpopup">
                <div class="dc-modalcontent modal-content">
                    <div class="modal-body">
                        {!! Form::open(['class' => 'dc-formtheme dc-formfeedback', 'id' => 'submit-feedback', '@submit.prevent' => 'submitFeedback("'.$user->id.'")']) !!}
                            <div class="dc-popupsubtitle dc-subtitlewithbtn">
                                <h3>{{ trans('lang.i_recomend') }}</h3>
                                <div class="dc-btnarea dc-tabbtns">
                                   <div class="dc-radio">
                                        {!! Form::radio('votes', 1, 1, ['id' => 'yes', 'class' => 'dc-btn']) !!}
                                        {!! Html::decode(Form::label('yes', '<i class="ti-thumb-up"></i> Yes', [])) !!}
                                    </div>
                                    <div class="dc-radio">
                                        {!! Form::radio('votes', 0, 0, ['id' => 'no', 'class' => 'dc-btn']) !!}
                                        {!! Html::decode(Form::label('no', '<i class="ti-thumb-down"></i> No', [])) !!}
                                    </div>
                                </div>
                            </div>
                            <fieldset class="dc-improvedinfo">
                                <div class="dc-popupsubtitle"><h3>{{ trans('lang.long_waite') }}</h3></div>
                                <div id="dc-productrangeslider" class="dc-productrangeslider dc-themerangeslider">
                                <ul class="dc-timerange">
                                    @foreach (Helper::getWaitingTime() as $key => $value)
                                        <li id="time"><span>{{html_entity_decode(clean($value))}}</span></li>
                                    @endforeach
                                </ul>
                                </div>
                                <div class="dc-popupsubtitle"><h3>{{ trans('lang.rate_doc') }}</h3></div>
                                @if(!empty($feedback_questions))
                                    @foreach ($feedback_questions as $key => $option)
                                        <div class="form-group dc-rating-holder">
                                            <div class="dc-ratingtitle">
                                                <h3><span>{{ html_entity_decode(clean($option->title)) }}</span></h3>
                                            </div>
                                            <div class="dc-ratingarea">
                                                <div class="dc-jrate">
                                                    <vue-stars
                                                        :name="'rating[{{ $key }}][rate]'"
                                                        :active-color="'#fecb02'"
                                                        :inactive-color="'#999999'"
                                                        :shadow-color="'#ffff00'"
                                                        :hover-color="'#dddd00'"
                                                        :max="5"
                                                        :value="0"
                                                        :readonly="false"
                                                        :char="'★'"
                                                        id="rating-{{ $key }}"
                                                    />
                                                    <div class="counter wt-pointscounter"></div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="rating[{{ $key }}][reason]" value="{{{ clean($option->id) }}}">
                                            <span class="dc-rating-content"></span>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="form-group">
                                    <textarea class="form-control" name="comments" placeholder="{{ trans('lang.share_exp') }}"></textarea>
                                </div>
                            </fieldset>
                            <fieldset class="dc-formsubmit">
                                <div class="dc-btnarea">
                                    <span class="dc-checkbox">
                                        <input id="feedbackpublicly" type="checkbox" name="feedbackpublicly">
                                        <label for="feedbackpublicly"><span>{{ trans('lang.keep_anonymous') }}</span></label>
                                    </span>
                                    {!! Form::submit(trans('lang.submit_now'), ['class' => 'dc-btn']) !!}
                                </div>
                            </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </b-modal>
        @include('front-end.includes.appointment_modal')
    </div>
@endsection
@push('front_end_scripts')
@if(!empty($script_data_doctor))
<script type="application/ld+json">
    {!! $script_data_doctor !!}
</script>
@endif
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/prettyPhoto.js') }}"></script>
<script>
    jQuery("a[data-rel]").each(function () {
		jQuery(this).attr("rel", jQuery(this).data("rel"));
	});
	jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
		animation_speed: 'normal',
		theme: 'dark_square',
		slideshow: 3000,
		default_width: 800,
        default_height: 500,
        allowfullscreen: true,
		autoplay_slideshow: false,	
		social_tools: false,
		iframe_markup: "<iframe src='{path}' width='{width}' height='{height}' frameborder='no' allowfullscreen='true'></iframe>", 
		deeplinking: false
	})
    $(".feedback-btn").on('click', function(event) {
        $(function() {
            jQuery("#dc-productrangeslider").slider({
            range: "max",
            min: 1,
            max: 4,
            value: 1,
            slide: function( event, ui ) {
                $("#time").val( ui.value );
            }
            });
            jQuery("#time").val( jQuery("#dc-productrangeslider").slider("value"));
        } );
    });

    jQuery(document).ready(function (){
            /* THEME ACCORDION */
        function themeAccordion() {
            jQuery('.dc-panelcontent').hide();
            jQuery('.dc-accordion .dc-paneltitle:first').addClass('active').next().slideDown('slow');
            jQuery('.dc-accordion .dc-paneltitle').on('click',function() {
                if(jQuery(this).next().is(':hidden')) {
                    jQuery('.dc-accordion .dc-paneltitle').removeClass('active').next().slideUp('slow');
                    jQuery(this).toggleClass('active').next().slideDown('slow');
                }
            });
        }
        themeAccordion();
        function childAccordion() {
            jQuery('.dc-subpanelcontent').hide();
            jQuery('.dc-childaccordion .dc-subpaneltitle:first').addClass('active').next().slideDown('slow');
            jQuery('.dc-childaccordion .dc-subpaneltitle').on('click',function() {
                if(jQuery(this).next().is(':hidden')) {
                    jQuery('.dc-childaccordion .dc-subpaneltitle').removeClass('active').next().slideUp('slow');
                    jQuery(this).toggleClass('active').next().slideDown('slow');
                }
            });
        }
        childAccordion();
        console.log(window.location.href )
        });
</script>
@endpush
