@extends('front-end.master', ['body_class' => 'dc-home dc-userlogin'])
@if (Schema::hasTable('site_managements')) 
    @php 
        $script_data = array (
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => config('app.name'),
            "url" => "https://dev.msnsoft.org/",
            "logo" => asset(Helper::getGeneralSettings('site_logo')),
            "description" => "Your next most loved arrangement booking framework. Find and book arrangements online with the best wellbeing experts. Get you wellbeing concerns tackled quicker by connecting with specialists, emergency clinics and facilities in an a lot simpler way!",
            "foundingDate" => "2020",
            "sameAs"=>array( 
                
            ), 
            "address"=>array( 
            "@type" => "PostalAddress",
            "streetAddress" => "Msnsoft, 644",
            "addressLocality" => " Gourmet, Airline Society",
            "addressRegion" => "Lahore",
            "postalCode" => "54000",
            "addressCountry" =>array( 
                "@type" => "Country",
                "name" => "Pakistan"
                )
            ), 
            "contactPoint"=>array( 
                "@type" => "ContactPoint",
                "telephone" => " +92 42 12345678",
                "contactType" => "Customer Service (Call Center)",
                "email" => "info@msnsoft.org",
                "areaServed" => "Pakistan",
            ) 
        ); 
        $script_data = json_encode($script_data,JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        
        $seo_settings = App\SiteManagement::getMetaValue('seo_settings'); //Article Section
        $meta_title = !empty($seo_settings['meta_title']) ? $seo_settings['meta_title'] : 'Knockdoc- Book A doctor';
        $meta_desc = !empty($seo_settings['meta_desc']) ? $seo_settings['meta_desc'] : '';
        @endphp
        @section('title'){{ $meta_title }} @stop
        @section('description', "$meta_desc")
    @endif
    @section('banner')
        @if (!empty(Helper::getHomeSlider('home_slides')))
            @include('front-end.slider')
        @endif
@endsection
@push('front_end_stylesheets')
<style>
  #search_form {
    width: 67%;
    display: block;
    padding-top: 20px;
    background: transparent !important; 
    margin: 0 auto;
  }

  .search_main.sticky_search {
    position: inherit;
    padding: 0;
    border-radius: 12px;
  }

  .search_main {
    width: 92%;
    margin: 0 auto;
  }

  .hide_nav{
    display: block;
  }
 
  @media (max-width: 1024px){
  .Video-Consultation-heading {
    width: 58% !important;
  }
  .Online-appointment-width-doctor{
    width: 62% !important;
  }
  .Video-Consultation-heading p {
    width: 70% !important;
  }
}
  
  @media (max-width: 991px){
  #search_form {
    background: #fff !important;
    border: 1px solid #eeee;
    padding: 10px 0;
    border-radius: 12px;
    display: inline-block;
    width: 80%;
  }
  .Online-appointment-width-doctor{
    width: 80% !important;
  }
  .Video-Consultation-heading {
    width: 55% !important;

  }
  .Video-Consultation-heading p {
    width: 75% !important;
  }
}
@media (max-width: 420px){
  #search_form {
    width: 90%;
  }
}
.Online-appointment-width-doctor{
  margin: 0 auto 10px;
  width: 48%;
  border: 1px solid #eee;
  display: block;
  margin-bottom: 15px;
  margin: 20px auto;
  background-color: rgba(255,255,255,0.7);
}
  .doctor-image{
  width: auto;
  float: left;
  position: relative;}

  .doctor-image a{
  position: absolute;
  right:-17px;
  top: 5px;
  color: #fff;
  font-size: 14px;
  background-color: #3fabf3;
  width: 30px;
  height: 30px;
  display: inline-block;
  border-radius: 50%;
  padding: 3px 7px;
  border: 1px solid #fff;
}
  .doctor-image img
  {
    height: 144px;
}
  .Video-Consultation-heading{
  width: 54%;
  float: left;
  margin-left: 30px;
  padding: 0;
}
  .Video-Consultation-heading h3{
  font-size: 17px;
  margin-top:10px;
  font-weight: 600;
}
  .Video-Consultation-heading p{
  width:80%;
  display: block;
  font-size: 14px;
  margin:10px 0;
}
  .Video-Consultation-button{
  float: left;
  margin:0;
}


@media (max-width: 767px){

  .Online-appointment-width-doctor {
    width: 85%;
    border: 1px solid #eee;
    display: inline-block;
    margin-bottom: 15px;
    padding-bottom: 15px;
  }
  .doctor-image {
    width: 100%;
  }
  .doctor-image img {
    height: auto;
  }
  .doctor-image a {
    right: -12px;}
  .Video-Consultation-heading {
    width: 100% !important;
    margin-left: 0;
    text-align: center;}
  .Video-Consultation-heading p {
    width: 100% !important;}

  .Video-Consultation-button {
    width: 100%;
  }
  .Video-Consultation-heading h3{
    margin:15px 0;
  }
}


</style>
<!-- <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet"> -->
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
@endpush @section('content') @include('includes.pre-loader')
<div id="home">
    @if (Session::has('error'))
    <div class="flash_msg">
        <flash_messages :message_class="'danger'" :time="10" :message="'{{{ Session::get('error') }}}'" v-cloak> </flash_messages>
    </div>
    @endif
    <section class="dc-searchholder dc-haslayout">
        @if (Helper::getSearchBanner('show_banner') === 'true') @php $locations = App\Location::all(); $roles = Spatie\Permission\Models\Role::all()->toArray(); @endphp
        @php
        $img =  Helper::getSearchBanner('banner_img')
        @endphp
        <div class="dc-bannerimg"style="  position: relative;
    width: auto;
    background-image: url(uploads/settings/home/<?php echo $img ?>)
    background-size: 100%;
    background-repeat: no-repeat;
    min-height: 320px;
    /*background-attachment: fixed;*/
    background-position: center;
    background-size: cover;">
            <div class="dc-searchform-holder">
                <div class="dc-title search_header">
                    <h1>Find And Book Best Doctors</h1>
           
                </div>
                @include("front-end.includes.inner-banner")
                <div class="container">
                    <div class="row">
                          <ul class="popular_searches show_desk">
                            <li>Trending Topics:</li>
                            <?php $count = 0; ?>
                            @if (count(Helper::getTrending()) > 0) @foreach(Helper::getTrending() as $key => $trend) @if($count <= 2)
                            <?php 
                            $link = "";
                            $table = $trend->getTable(); if($table == "specialities"){ $link = 'speciality'; } if($table == "diseases") { $link = 'diseases'; } if($table == "services") { $link = 'services'; } ?>
                            <li>
                                <a href="{{{url($link.'/'.clean($trend->slug))}}}">{{$trend->title}}</a>
                            </li>
                            @endif
                            <?php $count++; ?>
                            @endforeach @if (count(Helper::getTrending()) > 3)
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle"id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Others</a>
                                @endif
                                <ul class="other_searches dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <p>Trending Topics</p>
                                    <?php $count = 0; ?>
                                    @foreach(Helper::getTrending() as $key => $trend) @if ($count > 2 && $count <= 11)

                                    <?php 
                                $link = "";
                                $image = "";
                                $table = $trend->getTable(); if($table == "specialities"){ $link = 'specialities'; $image = $trend->image; } if($table == "diseases") { $link = 'diseases'; $image = ""; } if($table == "services") { $link = 'services'; $image = ""; }
                                                            ?>

                                    <li>
                                        <a href="{{{url($link.'/'.clean($trend->slug))}}}">
                                            <span class="round_images">
                                                @if(!empty($image))
                                                <img src="{{url('/uploads/'.$link.'/'.$image)}}" />
                                                @else
                                                <img src="{{url('/images/default.png')}}" />
                                                @endif
                                            </span>
                                            <span class="speciality_name">{{$trend->title}}</span>
                                        </a>
                                    </li>
                                    @endif
                                    <?php $count++; ?>
                                    @endforeach
                                </ul>
                            </li>

                            @else
                            <li>No Trend</li>
                            @endif
                        </ul>

                        <!-- Resposive trending topics --> 
                          <ul class="popular_searches show_on_responsive" style="display: none;">
                            <li>Trending Topics:</li>
                            <?php $count = 0; ?>
                            @if (count(Helper::getTrending()) > 0) @foreach(Helper::getTrending() as $key => $trend) @if($count == 0)
                            <?php 
                            $link = "";
                            $table = $trend->getTable(); if($table == "specialities"){ $link = 'speciality'; } if($table == "diseases") { $link = 'diseases'; } if($table == "services") { $link = 'services'; } ?>
                            <li>
                                <a href="{{{url($link.'/'.clean($trend->slug))}}}">{{$trend->title}}</a>
                            </li>
                            @endif
                            <?php $count++; ?>
                            @endforeach @if (count(Helper::getTrending()) > 0)
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle"id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Others</a>
                                @endif
                                <ul class="other_searches dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <p>Trending Topics</p>
                                    <?php $count = 0; ?>
                                    @foreach(Helper::getTrending() as $key => $trend) @if ($count > 0 && $count <= 11)

                                    <?php 
                                $link = "";
                                $image = "";
                                $table = $trend->getTable(); if($table == "specialities"){ $link = 'specialities'; $image = $trend->image; } if($table == "diseases") { $link = 'diseases'; $image = ""; } if($table == "services") { $link = 'services'; $image = ""; }
                                                            ?>

                                    <li>
                                        <a href="{{{url($link.'/'.clean($trend->slug))}}}">
                                            <span class="round_images">
                                                @if(!empty($image))
                                                <img src="{{url('/uploads/'.$link.'/'.$image)}}" />
                                                @else
                                                <img src="{{url('/images/default.png')}}" />
                                                @endif
                                            </span>
                                            <span class="speciality_name">{{$trend->title}}</span>
                                        </a>
                                    </li>
                                    @endif
                                    <?php $count++; ?>
                                    @endforeach
                                </ul>
                            </li>

                            @else
                            <li>No Trend</li>
                            @endif
                        </ul>
                        <div class="Online-appointment-width-doctor">
               <!--  <div class="row"> -->
                   <!--  <div class="col-md-7 offset-3"> -->
                        <!-- <div class="row"> -->
                            <!-- <div class="col-md-4 pl-0 pr-0"> -->
                                <div class="doctor-image">
                                    <img src="{{asset('/images/video-call-1.jpg')}}" alt="images/video-call-image picture">  
                                    <a href="#">
                            <i class="fa fa-video-camera" aria-hidden="true"></i>  
                                    </a>
                                </div>
                            <!-- </div> -->
                           <!--  <div class="col-md-7 pl-0 pr-0 offset-1"> -->
                                <div class="dc-fwidgettitle Video-Consultation-heading">
                                <h3>Looking for Video Consultation? 
                                </h3>
                                <p>Video Consultation is available now! 
                                Stay Home Stay Safe!</p>  
                                <div class="dc-loginarea Video-Consultation-button">
                                
                        <a href="http://knockdoc.test/register" class="dc-btn">
                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                             Book Video Consultation</a>

                            </div>
                            </div>
                           <!--  </div> -->
                        <!-- </div> -->
                    <!-- </div> -->
                <!-- </div> -->
            </div>
                    </div>
                </div>
                <div class="user_facilities">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 p-0">
                                <div class="user_facilities_btn">
                                    <a href="{{url('search-results')}}">
                                        <span>
                                            <i class="fas fa-user-md"></i>
                                        </span>
                                        Book a Doctor
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 p-0">
                                <div class="user_facilities_btn">
                                    <a href="#">
                                        <span>
                                            <i class="fa fa-flask"></i>
                                        </span>
                                        Book a Test
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 p-0">
                                <div class="user_facilities_btn">
                                    <a href="{{url('cosult-online')}}">
                                        <span>
                                          <!-- <img src="{{asset('/images/original.png')}}" /> -->
                                          <i class="fa fa-video-camera" aria-hidden="true"></i>
                                        </span>
                                        Consult Online
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 p-0">
                                <div class="user_facilities_btn border-0">
                                    <a href="#">
                                        <span>
                                            <i class="fa fa-briefcase"></i>
                                        </span>
                                        Ask a Question
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! form::close(); !!}
        </div>
        @endif @if (Helper::getSpecialities())
        <div class="dc-haslayout speciality_outer_main">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="speciality_heading">
                            <h3>Top Specialities of Knockdoc</h3>
                        </div>
                        @foreach(Helper::getSpecialities() as $special)
                        <div class="specialities_main">
                            <div class="item">
                                <a href="{{{url('/search-results?search=&type=doctor&speciality='.clean($special->slug))}}}" class="specialities_inner">
                                    <div class="round_item">
                                        <img src="{{url('/uploads/specialities/'.$special->image)}}" />
                                    </div>
                                    <p class="disease_name">{{$special->title}}</p>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        <div class="veiw_all_btn">
                            <a href="{{ url('speciality')}}" class="veiw_all_btns">View all</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif
    </section>
    <!-- Top doctors and hospital section -->
@if (!(Helper::getCurrentAffairs()->count() == 0 ))
<div class="container">
    @foreach(Helper::getCurrentAffairs() as $current_affair)
        <div class="speciality_heading">
                            <h3>{{$current_affair->name}}</h3>
        </div>
      <div class="row">
        <?php $counter = 0; ?>
          @foreach($current_affair->affairdetails->reverse() as $affair)
          @if($affair->status =='1')
         <?php
         if($counter>=4){
    break;
} 
 ?>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3 float-left">
            <a href="{{ action('UserController@datashow', $affair->id) }}">
            <div class="card blot_type_section">
                   <img class="card-img-top" src="{{asset('/uploads/specialities/temp/'.$affair->image)}}"alt="patient-image picture" />
              <div class="card-body">
                <h6 style="font-size: 20px;">{{$affair->name}}</h6>
                <p class="card-text">
                    {!! str_limit($affair->description, 60) !!}
                </p>
              </div>
            </div>
            </a>
        </div>
        <?php  
        $counter++;
     ?>
        @endif
        @endforeach
      
     </div>              

@endforeach
      
     </div>
@endif
    <section class="dc-haslayaout dc-footeraboutus separator_bottom">
        <div class="container">
            <div class="row">
                {{-- <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                 <div class="dc-widgetskills">
                  <ul class="doctor_hospital_list">
                   <li>
                    <fieldset class="doctor_hospital_main">
                     <h3 class="field_name">Doctors in Pakistan</h3>
                     <div class="inner_content de_content">
                      @foreach(Helper::getDoctors() as $doctor)

                      <a href="{{{url('profile/'.clean($doctor->slug))}}}" class="panel panel-default">
                       <div class="panel-body">
                        <div class="doctor_hospital_name box_bover">
                         <span> Doctors in {{$doctor->title}} </span>
                        </div>
                       </div>
                      </a>
                      @endforeach
                     </div>
                     <div class="dc-viewmore dc-text-center" style="margin: 5px 5px 0 5px;">
                      <a href="{{ url('/doctors-in-pakistan') }}">View All</a>
                     </div>
                    </fieldset>
                   </li>
                  </ul>
                 </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                 <div class="dc-widgetskills">
                  <ul class="">
                   <li>
                    <fieldset class="doctor_hospital_main">
                     <h3 class="field_name">Hospitals in Pakistan</h3>
                     <div class="inner_content de_content">
                      @foreach(Helper::getHospitals() as $hospital)
                      <a href="{{{url('search-results?search=&locations='.clean($hospital->slug))}}}" class="panel panel-default">
                       <div class="panel-body">
                        <div class="doctor_hospital_name box_bover">
                         <span> Hospitals in {{$hospital->title}} </span>
                        </div>
                       </div>
                      </a>
                      @endforeach
                     </div>
                     <div class="dc-viewmore dc-text-center" style="margin: 5px 5px 0 5px;">
                      <a href="{{ url('/hospitals-in-pakistan') }}">View All</a>
                     </div>
                    </fieldset>
                   </li>
                  </ul>
                 </div>
                </div> --}}
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="doctor_hospital_main">
                        <h3 class="field_name">Doctors in Pakistan</h3>
                    </div>
                    <ul class="doctor_location_box">
                        @foreach(Helper::getDoctors() as $doctor)

                        <li class="location_list_inner">
                            <a href="/doctors/{{clean($doctor->slug)}}">
                                <img src="{{{ asset(Helper::getImage('uploads/locations', $doctor->flag)) }}}" alt="{{{ html_entity_decode(clean($doctor->title)) }}}" />
                                <span>{{$doctor->title}}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="doctor_hospital_main">
                        <h3 class="field_name">Hospital in Pakistan</h3>
                    </div>
                    <ul class="doctor_location_box">
                        @foreach(Helper::getHospitals() as $hospital)

                        <li class="location_list_inner">
                            <a href="/hospitals/{{clean($hospital->slug)}}">
                                <img src="{{{ asset(Helper::getImage('uploads/locations', $hospital->flag)) }}}" alt="{{{ html_entity_decode(clean($hospital->title)) }}}" />
                                <span>{{$hospital->title}}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Wonderful Patient stories -->

    @if (!(Helper::getPatientsFeedback()->count() == 0 ))

    
    <div class="dc-haslayout dc-bgcolor inner_top_separator separator_bottom inner_bottom_serarator wonderful_section">
        <div class="container">
            <div class="row">
                <div class="dc-sectiontitle dc-text-center wonderful_section_heading">
                    <h3>
                        Wonderful Patient's Stories
                    </h3>
                </div>
                <!-- new slider  -->
                <div class="home-product-new-hldr">
                    <div class="slider-btn-hldr slider-btn-hldr-left">
                        <button id="left-btn" class="slider-btn" style="display: none;">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="home-product-new">
                        <div class="review_slider_inner" style="left: 0px;">
                            @foreach(Helper::getPatientsFeedback() as $feedback)
                         
                            <div class="item-container">
                                <div class="item" id="inner_item">
                                    <div class="patient-stories-body-content">
                                        <a href="/profile/{{Helper::getDoctorProfile($feedback->user_id)}}"> <p>{{ $feedback->comment}}</p> </a>
                                    </div>
                                    <div class="patient-history">
                                        <div class="patient-image">
                                            <img
                                                src="{{ asset(Helper::getImage('uploads/users/'.$feedback->patient_id, App\User::find($feedback->patient_id)->profile->avatar, 'extra-small-', 'user-login.png')) }}"
                                                alt="patient-image picture"
                                            />
                                        </div>
                                        <span class="patient-name">
                                            <span>{{ Helper::getUserData($feedback->patient_id) }}</span><br />
                                            @if($feedback->avg_rating ==0 && $feedback->avg_rating <=0.4 )
                                            <span style="color: #f1c40f;"></span><span>{{$feedback->avg_rating}}</span>
                                            @elseif ($feedback->avg_rating >=0.5 && $feedback->avg_rating <=1.4)
                                            <span style="color: #f1c40f;">★ </span><span>{{$feedback->avg_rating}}</span>
                                            @elseif ($feedback->avg_rating >=1.5 && $feedback->avg_rating <=2.4)
                                            <span style="color: #f1c40f;">★★ </span><span>{{$feedback->avg_rating}}</span>
                                            @elseif ($feedback->avg_rating >=2.5 && $feedback->avg_rating <=3.4)
                                            <span style="color: #f1c40f;">★★★ </span><span>{{$feedback->avg_rating}}</span>
                                            @elseif ($feedback->avg_rating >=3.5 && $feedback->avg_rating <=4.4)
                                            <span style="color: #f1c40f;">★★★★ </span><span>{{$feedback->avg_rating}}</span>
                                            @elseif ($feedback->avg_rating >=4.5 && $feedback->avg_rating <=5)
                                            <span style="color: #f1c40f;">★★★★★ </span> <span>{{$feedback->avg_rating}}</span>
                                            @else
                                            <span style="color: #f1c40f;">★★★★★ </span> <span>{{$feedback->avg_rating}}</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="slider-btn-hldr slider-btn-hldr-right">
                        <button id="right-btn" class="slider-btn" style="display: block;">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <!-- new slider  -->
            </div>
        </div>
    </div>
  @endif 
    <!-- Wonderful Patient stories -->

    <!-- Top doctors and hospital section -->
    <!-- Bring Care Start -->
    {{-- @if (!empty(Helper::getAboutUsSection('show_about_sec')) && Helper::getAboutUsSection('show_about_sec') === 'true')
    <section class="dc-haslayout dc-main-section dc-sectionbg">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 align-self-center">
                    <div class="dc-bringcarecontent">
                        <div class="dc-sectionhead dc-sectionheadvtwo">
                            <div class="dc-sectiontitle">
                                <h2>{{ html_entity_decode(clean(Helper::getAboutUsSection('title'))) }}<span>{{ html_entity_decode(clean(Helper::getAboutUsSection('subtitle'))) }}</span></h2>
                            </div>
                            <div class="dc-description">
                                {!! clean(Helper::getAboutUsSection('description')) !!}
                            </div>
                        </div>
                        @if (!empty(Helper::getAboutUsSection('btn_one_title')) || !empty(Helper::getAboutUsSection('btn_two_title')))
                        <div class="dc-btnarea">
                            @if (!empty(Helper::getAboutUsSection('btn_one_title')))
                            <a href="{{ Helper::getAboutUsSection('btn_one_url') }}" class="dc-btn">{{ html_entity_decode(clean(Helper::getAboutUsSection('btn_one_title'))) }}</a>
                            @endif @if (!empty(Helper::getAboutUsSection('btn_one_title')))
                            <a href="{{ Helper::getAboutUsSection('btn_two_url') }}" class="dc-btn dc-btnactive">{{ html_entity_decode(clean(Helper::getAboutUsSection('btn_two_title'))) }}</a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="dc-bringimg-holder">
                        <figure class="dc-doccareimg">
                            @if (!empty(Helper::getAboutUsSection('about_us_img')))
                            <img src="{{ asset(Helper::getImage('uploads/settings/home', Helper::getAboutUsSection('about_us_img'), '', 'doc-img.png')) }}" alt="{{ trans('lang.img_desc') }}" />
                            @endif @if (!empty(Helper::getAboutUsSection('img_title')) || !empty(Helper::getAboutUsSection('img_subtitle')))
                            <figcaption>
                                <div class="dc-doccarecontent">
                                    <h3><em>{{ html_entity_decode(clean(Helper::getAboutUsSection('img_title'))) }}</em>{{ html_entity_decode(clean(Helper::getAboutUsSection('img_subtitle'))) }}</h3>
                                </div>
                            </figcaption>
                            @endif
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif --}}
    <!-- Bring Care End -->
    <!-- Our Rated Start -->
    {{--@if (Helper::getSpecialitySlider('display') == 'true')
    <section class="dc-haslayout dc-main-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">
                    <div class="row">
                        <div class="dc-ratedecontent dc-bgcolor">
                            <figure class="dc-neurosurgeons-img">
                                <img src="{{{asset(Helper::getSpecialitySlider('speciality')['image'])}}}" alt="{{ trans('lang.img_desc') }}" />
                            </figure>
                            <div class="dc-sectionhead dc-sectionheadvtwo dc-text-center">
                                <div class="dc-sectiontitle">
                                    <h2>{{ trans('lang.our_top_rated') }}<span>{{{ html_entity_decode(clean( Helper::getSpecialitySlider('speciality')['title'])) }}}</span></h2>
                                </div>
                                <div class="dc-description">
                                    <p>{{ clean(Helper::getSpecialitySlider('speciality')['description']) }}</p>
                                </div>
                            </div>
                            <div class="dc-btnarea">
                                <a href="{{{url('search-results?search=&type=doctor&speciality='.Helper::getSpecialitySlider('speciality')['slug'])}}}" class="dc-btn">{{ trans('lang.view_all') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @if (!empty(Helper::getSpecialitySlider('speciality')['doctors']) && count(Helper::getSpecialitySlider('speciality')['doctors']) > 0)
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
                    <div class="row">
                        <div id="dc-docpostslider" class="dc-docpostslider owl-carousel">
                            @foreach (Helper::getSpecialitySlider('speciality')['doctors'] as $service_id) @php $doctor = App\User::find($service_id); $user = App\User::findOrFail($doctor->id); $saved_doctors = Auth::check() &&
                            !empty(Auth::user()->profile->saved_doctors) ? json_decode(Auth::user()->profile->saved_doctors) : array(); $avg_rating = App\Feedback::where('user_id', $user->id)->pluck('avg_rating')->first(); $stars =
                            $avg_rating != 0 ? $avg_rating / 5 * 100 : 0; @endphp
                            <div class="item">
                                <div class="dc-docpostholder">
                                    <figure class="dc-docpostimg">
                                        <img src="{{{asset(Helper::getImage('uploads/users/'.$doctor->id,  $doctor->profile->avatar, 'medium-', 'user.jpg'))}}}" alt="{{ trans('lang.img_desc') }}" />
                                    </figure>
                                    <div class="dc-docpostcontent">
                                        @if (!empty($saved_doctors) && in_array($user->id, $saved_doctors))
                                        <a href="javascrip:void(0);" class="dc-like dc-clicksave dc-btndisbaled">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                        @else
                                        <a href="javascript:void(0);" class="dc-like"><i class="fa fa-heart"></i></a>
                                        <a href="javascrip:void(0);" class="dc-like" id="doctor-{{ $user->id }}" @click.prevent="add_wishlist('doctor-{{ $user->id }}', '{{ $user->id }}', 'saved_doctors', '')" v-cloak>
                                            <i class="fa fa-heart"></i>
                                        </a>
                                        @endif
                                        <div class="dc-title">
                                            <a href="javascript:void(0)" class="dc-docstatus">{{{ html_entity_decode(clean(Helper::getSpecialitySlider('speciality')['title'])) }}}</a>
                                            <h3>
                                                <a href="{{ route('userProfile', clean($doctor->slug)) }}">
                                                    {{ !empty($doctor->profile->gender_title) ? Helper::getDoctorArray(clean($doctor->profile->gender_title)) : '' }} {{{Helper::getUserName($doctor->id)}}}
                                                </a>
                                                {{ Helper::verifyMedical(clean($doctor->id)) }} {{ Helper::verifyUser(clean($doctor->id)) }}
                                            </h3>
                                            <ul class="dc-docinfo">
                                                <li>{{ html_entity_decode(clean($doctor->profile->tagline)) }}</li>
                                                <li>
                                                    <span class="dc-stars"><span style="width: {{ $stars }}%;"></span></span><em>{{ $doctor->feedbacks->count() }} {{ trans('lang.feedbacks') }}</em>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="dc-doclocation slider_btn">
                                            <span><i class="ti-direction-alt"></i> {{{!empty($doctor->location) ? html_entity_decode(clean($doctor->location->title)) : ''}}}</span>
                                            @if (!empty($doctor->profile->available_days))
                                            <span>
                                                <i class="ti-calendar"></i>
                                                @foreach (Helper::getAppointmentDays() as $key => $day) @if (!in_array($key, array($doctor->profile->available_days)))

                                                <em class="dc-dayon">{{ html_entity_decode(clean($day['title'])) }}</em>
                                                @else {{ html_entity_decode(clean($day['title'])) }}, @endif @endforeach
                                            </span>
                                            @endif
                                            <span class="doctor_fee"><i class="far fa-money-bill-alt"></i></span>
                                            <span class="doctor_fee">1000 - 1500</span>
                                            <div class="btn-group slider_bottom_btn">
                                                <a href="{{{route('userProfile', clean($doctor->slug))}}}" class="dc-btn">{{ trans('lang.view_more') }}</a>
                                                <a href="{{{route('userProfile', clean($doctor->slug))}}}" class="dc-btn">{{ trans('lang.book_now') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif--}}
    <!-- Our Rated End -->
    <!-- Mobile App Start -->
    @if ( !empty(Helper::getDownloadAppSection('show_app_sec')) && Helper::getDownloadAppSection('show_app_sec') == 'true')
    <section class="dc-haslayout dc-bgcolor separator_bottom" id="mobileSection">
        <div class="container">
            <div class="row">
                @if (!empty(Helper::getDownloadAppSection('app_sec_img')))
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 outer_top_separator">
                    <div class="dc-jointeamholder">
                        <div class="dc-jointeam" style="background: rgb(61, 68, 97);">
                            <span class="dc-jointeamnoti">
                                <i class="ti-light-bulb"></i>
                            </span>
                            <figure class="dc-jointeamimg">
                                <img src="https://amentotech.com/projects/doctry/uploads/pages/2/1585837972-small-1569052927-img-04.png" alt="img description" />
                            </figure>
                            <div class="dc-jointeamcontent">
                                <h3 style="color: rgb(255, 255, 255);">
                                    <span style="color: rgb(255, 255, 255);"> Are You A Doctor?</span>
                                    Join Our Team
                                </h3>
                                <a href="/register" class="dc-btn dc-btnactive">Join As Doctor</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 justify-content-center align-self-center outer_top_separator separator_bottom">
                    <div class="dc-appcontent">
                        <div class="dc-sectionhead dc-sectionheadvtwo">
                            <div class="dc-sectiontitle">
                                <h2>{{ html_entity_decode(clean(Helper::getDownloadAppSection('title'))) }}<span>{{ html_entity_decode(clean(Helper::getDownloadAppSection('subtitle'))) }}</span></h2>
                            </div>
                            <div class="dc-description">
                                {!! clean(Helper::getDownloadAppSection('description')) !!}
                            </div>
                        </div>
                        <div class="input-group url_btn_main">
                            <div class="country-code">+92</div>
                            <input type="number" class="form-control" placeholder="Enter Number" id="app-link-number" />
                            <span class="input-group-btn">
                                <button class="dc-btn" type="button" v-on:click="appLinkNumber">Send Link</button>
                            </span>
                        </div>
                        <ul class="dc-appicons">
                            @if (!empty(Helper::getDownloadAppSection('android_url')))
                            <li>
                                <a href="{{ Helper::getDownloadAppSection('android_url') }}">
                                    <img src="{{ asset(Helper::getImage('uploads/settings/home', Helper::getDownloadAppSection('android_img'), '', 'google-default.png')) }}" alt="{{ trans('lang.img_desc') }}" />
                                </a>
                            </li>
                            @endif @if (!empty(Helper::getDownloadAppSection('ios_url')))
                            <li>
                                <a href="{{ Helper::getDownloadAppSection('ios_url') }}">
                                    <img src="{{ asset(Helper::getImage('uploads/settings/home', Helper::getDownloadAppSection('ios_img'), '', 'ios-default.png')) }}" alt="{{ trans('lang.img_desc') }}" />
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <section class="dc-haslayaout dc-footeraboutus dc-bgcolor separator_bottom inner_top_separator inner_bottom_serarator">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xs-6">
                    <div class="dc-widgetskills">
                        <div class="dc-fwidgettitle">
                            <h3>Doctor {{ html_entity_decode(clean(Helper::getFooterSettings('first_menu_title'))) }}</h3>
                        </div>
                        @if (!empty(\App\Speciality::count() > 0 ))
                        <ul class="dc-fwidgetcontent">
                            @foreach (\App\Speciality::limit(5)->get() as $key => $speciality)
                            <li><a href="{{{url('/search-results?search=&type=doctor&speciality='.clean($speciality->slug))}}}">{{ html_entity_decode(clean($speciality->title)) }}</a></li>
                            @endforeach
                            <li class="dc-viewmore"><a href="{{{ url('speciality') }}}">{{trans('lang.view_all')}}</a></li>
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xs-6">
                    <div class="dc-widgetskills">
                        <div class="dc-fwidgettitle">
                            <h3>Hospital By Location</h3>
                        </div>

                        <ul class="dc-fwidgetcontent">
                            @foreach(Helper::getHospitalss() as $hospital)
                            <li>
                                <a href="/hospitals/{{clean($hospital->slug)}}">
                                    {{ html_entity_decode(clean($hospital->title)) }}
                                </a>
                            </li>
                            @endforeach
                            <li class="dc-viewmore">
                                <a href="{{ url('hospitals-in-pakistan') }}">
                                    {{trans('lang.view_all')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xs-6">
                    <div class="dc-footercol dc-widgetcategories">
                        <div class="dc-fwidgettitle">
                            <h3>Doctor By Location</h3>
                        </div>
                        @if (!empty(\App\Location::count() > 0 ))
                        <ul class="dc-fwidgetcontent">
                            @foreach (\App\Location::limit(5)->get() as $key => $location)
                            <li>
                                <a href="{{{url('/doctors/'.clean($location->slug))}}}">
                                    {{ html_entity_decode(clean($location->title)) }}
                                </a>
                            </li>
                            @endforeach
                            <li class="dc-viewmore"><a href="{{ url('doctors-in-pakistan') }}">{{trans('lang.view_all')}}</a></li>
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xs-6">
                    <div class="dc-footercol dc-widgetcategories">
                        <div class="dc-fwidgettitle">
                            <h3>Doctor {{ 'By Disease' }}</h3>
                        </div>
                        @if (!empty(\App\Disease::count() > 0 ))
                        <ul class="dc-fwidgetcontent">
                            @foreach (\App\Disease::limit(5)->get() as $key => $disease)
                            <li>
                                <a href="{{{url('/diseases/'.clean($disease->slug))}}}">
                                    {{ html_entity_decode(clean($disease->title)) }}
                                </a>
                            </li>
                            @endforeach
                            <li class="dc-viewmore"><a href="{{ url('diseases') }}">{{trans('lang.view_all')}}</a></li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Article Start -->
    @if (Helper::getArticleSectionSettings('show_article_sec') === 'true')
    <section class="dc-haslayout separator_bottom">
        <div class="container">
            <div class="row justify-content-center align-self-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 push-lg-2">
                    <div class="dc-sectionhead dc-text-center">
                        <div class="dc-sectiontitle">
                            <h2>
                                <span>{{ html_entity_decode(clean(Helper::getArticleSectionSettings('section_subtitle'))) }}</span>
                                {{ html_entity_decode(clean(Helper::getArticleSectionSettings('section_title'))) }}
                            </h2>
                        </div>
                        <div class="dc-description">
                            <p>{{ clean(Helper::getArticleSectionSettings('section_description')) }}</p>
                        </div>
                    </div>
                </div>
                @if(!empty(\App\Article::getArticles(3, true)->count() > 0) )
                <div class="dc-articlesholder">
                    @foreach (\App\Article::getArticles(3, true) as $article)
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 float-left">
                        <div class="dc-article">
                            <figure class="dc-articleimg">
                                <img src="{{ asset(Helper::getImage('uploads/users/'.$article->author->id.'/articles/', $article->image, 'featured-', 'featured-article-default.jpg')) }}" alt="{{ trans('lang.img_desc') }}" />
                                <figcaption>
                                    <div class="dc-articlesdocinfo">
                                        <img
                                            src="{{ asset(Helper::getImage('uploads/users/'.$article->author->id, App\User::find($article->author->id)->profile->avatar, 'extra-small-', 'user-login.png')) }}"
                                            alt="{{ trans('lang.img_desc') }}"
                                        />
                                        <span>{{ Helper::getUserName($article->author_id) }}</span>
                                    </div>
                                </figcaption>
                            </figure>
                            <div class="dc-articlecontent">
                                <div class="dc-title">
                                    <div class="dc-articleby-holder">
                                        @if (!empty($article->categories) && $article->categories->count() > 0) @foreach ($article->categories as $category)
                                        <a href="{{ route('articleListing' , clean($category->slug)) }}" class="dc-articleby">{{ $category->title }}</a>
                                        @endforeach @endif
                                    </div>
                                    <h3><a href="{{ route('articleDetail' , ['slug' => clean($article->slug) ]) }}">{{ html_entity_decode(clean($article->title)) }}</a></h3>
                                    <span class="dc-datetime"><i class="ti-calendar"></i> {{ Carbon\Carbon::parse($article->created_at)->format('M d, Y') }}</span>
                                </div>
                                <ul class="dc-moreoptions">
                                    <li>
                                        <a href="javascript:void(0);"><i class="ti-heart"></i></a> {{{ !empty($article->likes) ? clean($article->likes) : 0 }}} {{ trans('lang.likes') }}
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);"><i class="ti-eye"></i></a>{{{ !empty($article->views) ? clean($article->views) : 0 }}} {{ trans('lang.views') }}
                                    </li>
                                    <li id="dc-share-{{ clean($article->id) }}" @click="socialPopup('{{ clean($article->id) }}')" class="la-shareicon">
                                        <a href="javascript:void(0);"><i class="ti-share"></i> {{ trans('lang.share') }}</a>
                                        <ul class="dc-simplesocialicons dc-socialiconsborder">
                                            <li class="dc-facebook">
                                                <a
                                                    href="javascript:void()"
                                                    @click="socialShare('https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('articleDetail', ['slug' => clean($article->slug)])) }}')"
                                                    class="social-share"
                                                >
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                            </li>
                                            <li class="dc-twitter">
                                                <a href="javascript:void()" @click="socialShare('https://twitter.com/intent/tweet?url={{ urlencode(route('articleDetail', ['slug' => clean($article->slug)])) }}')" class="social-share">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li class="dc-linkedin">
                                                <a
                                                    href="javascript:void()"
                                                    @click="socialShare('https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('articleDetail', ['slug' => clean($article->slug)])) }}')"
                                                    class="social-share"
                                                >
                                                    <i class="fab fa-linkedin-in"></i>
                                                </a>
                                            </li>
                                            <li class="dc-googleplus">
                                                <a href="javascript:void()" @click="socialShare('https://plus.google.com/share?url={{ urlencode(route('articleDetail', ['slug' => clean($article->slug)])) }}')" class="social-share">
                                                    <i class="fab fa-google-plus-g"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif
    <!-- Latest Articles End -->
</div>
@endsection @push('front_end_scripts')

    

    <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/moment.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>

    <script type="text/javascript">
      $('#dateValue').datetimepicker({
        format: 'DD-MM-YYYY',
      });
      function speciality_link(e) {
        var link = $(e).attr("data-id"); // will return the string "123"
        window.location.href = link;
      }
    </script>

<script type="application/ld+json">
    {!! $script_data !!}
</script>

<script>
    /*$(".other_dropdown_toggle").click(function () {
  $(".other_searches").toggle();
 });*/
    var $hover = $(".active");
    $(".patient-stories-body-content").hover(
        function () {
            $hover.removeClass("active");
            $(this).addClass("active");
        },
        function () {
            $(this).removeClass("active");
            $hover.addClass("active");
        }
    );
    $("#main_doctor_search").click(function () {
        $("#datas").addClass("absolute_search");
        $("#countryList").addClass("absolute_dropdown");
    });

    $("#location_main .ais-SearchBox-input").click(function () {
        //  alert("hi");
        $("#location_inner").addClass("absolute_search");
        $("#cityList").addClass("absolute_dropdown");
    });

    window.onload = function () {
        var listEl = document.querySelector(".review_slider_inner");
        var totalChildren = listEl.querySelectorAll("#inner_item").length;
        if (totalChildren <= 3) {
            var btnRightEl = document.querySelector("#right-btn");
            btnRightEl.style.display = "none";
        }
    };

    (function () {
        var listEl = document.querySelector(".review_slider_inner");
        var btnLeftEl = document.querySelector("#left-btn");
        var btnRightEl = document.querySelector("#right-btn");
        var count = 0;

        function slideImages(dir) {
            var totalChildren = listEl.querySelectorAll("#inner_item").length;
            dir === "left" ? ++count : --count;
            listEl.style.left = count * 384 + "px";
            btnLeftEl.style.display = count < 0 ? "block" : "none";
            // Here, 4 is the number displayed at any given time
            btnRightEl.style.display = count > 3 - totalChildren ? "block" : "none";
            if ($(window).width() < 321) {
                listEl.style.left = count * 327 + "px";
                btnRightEl.style.display = count > 1 - totalChildren ? "block" : "none";
            } else if ($(window).width() < 361) {
                listEl.style.left = count * 373 + "px";
                btnRightEl.style.display = count > 1 - totalChildren ? "block" : "none";
            } else if ($(window).width() < 415) {
                listEl.style.left = count * 405 + "px";
                btnRightEl.style.display = count > 1 - totalChildren ? "block" : "none";
            } else if ($(window).width() < 569) {
                listEl.style.left = count * 282 + "px";
                btnRightEl.style.display = count > 2 - totalChildren ? "block" : "none";
            } else if ($(window).width() < 641) {
                listEl.style.left = count * 277 + "px";
                btnRightEl.style.display = count > 2 - totalChildren ? "block" : "none";
            } else if ($(window).width() < 732) {
                listEl.style.left = count * 277 + "px";
                btnRightEl.style.display = count > 2 - totalChildren ? "block" : "none";
            } else if ($(window).width() < 737) {
                listEl.style.left = count * 277 + "px";
                btnRightEl.style.display = count > 2 - totalChildren ? "block" : "none";
            } else if ($(window).width() < 824) {

            /*else if ($(window).width() < 769){
      listEl.style.left = count * 275 + "px";
      btnRightEl.style.display = count > 2 - totalChildren ? "block" : "none";
    }*/
                listEl.style.left = count * 362 + "px";
                btnRightEl.style.display = count > 2 - totalChildren ? "block" : "none";
            } else if ($(window).width() < 1025) {
                listEl.style.left = count * 323 + "px";
                btnRightEl.style.display = count > 2 - totalChildren ? "block" : "none";
            }
        }
        btnLeftEl.addEventListener("click", function (e) {
            slideImages("left");
        });
        btnRightEl.addEventListener("click", function (e) {
            slideImages("right");
        });
    })();
    /*if ($(window).width() <= 360) { 
    var listEl = document.querySelector(".review_slider_inner");
      listEl.style.left = count * 340 + "px";
    }*/
</script>

@endpush
