<template>
    <div>
        <div class="dc-preloader-section" v-if="loading" v-cloak>
            <div class="dc-preloader-holder">
                <div class="dc-loader">
                </div>
            </div>
        </div>

        <div class="row" v-if="userData.length > 0">
            <div class="filter_outer">
                <div class="container less_padding">
                    <div class="filter_main">
                        <div class="filter_show">
                            <div class="filter_heading">
                                <h4>Filters</h4>
                                <button type="button" id="close_filter" class="close" aria-label="Close">
                                    <span aria-hidden="true"><i aria-hidden="true" class="fa fa-close"></i></span>
                                </button>
                            </div>
                            <div class="mobile_filter_group first_heading">
                                <div class="mobile_heading">
                                    <h4>Gender</h4>
                                </div>
                                <span class="dc-checkbox custom_checkbox">
                                    <input name="male" value="1" id="male" type="checkbox" @click="sortedItems">
                                    <label for="male"> Male</label>
                                </span>
                                <span class="dc-checkbox custom_checkbox mobile_border">
                                    <input name="female" value="1" id="female" type="checkbox" @click="sortedItems">
                                    <label for="female"> Female</label>
                                </span>
                            </div>
                            <div class="mobile_filter_group mobile_space">
                                <div class="mobile_heading">
                                    <h4>Video Visit</h4>
                                </div>
                                <span class="dc-checkbox custom_checkbox mobile_border">
                                    <input name="video_check" value="1" id="video_check" type="checkbox" @click="sortedItems">
                                    <label for="video_check"> Video consultation </label>
                                </span>
                            </div>
                            <div class="mobile_filter_group mobile_space">
                                <div class="mobile_heading">
                                    <h4>Availability</h4>
                                </div>
                                <span class="dc-checkbox custom_checkbox">
                                    <input name="available_today" value="1" id="available_today" type="checkbox" @click="sortedItems">
                                    <label for="available_today"> Available today </label>
                                </span>
                                <span class="dc-checkbox custom_checkbox">
                                    <input name="available_tomorrow" value="1" id="available_tomorrow" type="checkbox" @click="sortedItems">
                                    <label for="available_tomorrow"> Tomorrow </label>
                                </span>
                                <span class="dc-checkbox custom_checkbox">
                                    <input name="available_next_3_days" value="1" id="available_next_3_days" type="checkbox" @click="sortedItems">
                                    <label for="available_next_3_days"> Next 3 Days </label>
                                </span>
                                <span class="dc-checkbox custom_checkbox">
                                    <input name="available_next_7_days" value="1" id="available_next_7_days" type="checkbox" @click="sortedItems">
                                    <label for="available_next_7_days"> Next 7 Days </label>
                                </span>
                            </div>
                            <!-- <div class="mobile_filter_group mobile_space">
                                <div class="mobile_heading">
                                    <h4>Others</h4>
                                </div>
                                <span class="dc-checkbox custom_checkbox mobile_border">
                                    <input name="child" value="1" id="child" type="checkbox" @click="sortedItems">
                                    <label for="child"> Sees Children </label>
                                </span>
                            </div> -->
                            <div class="mobile_filter_group mobile_space">
                                <div class="mobile_heading">
                                    <h4>Choose Hospital</h4>
                                </div>
                                <div class="filter_option" v-if="filteredListOfHospitals !== []">

                                    <input list="sort_by_hospital" v-model="search" id="input_sort_by_hospital" @change="sortedItems" placeholder="Choose Hospital" class="form-control">
                                    <datalist name="sort_by_hospital" id="sort_by_hospital">
                                        <option v-for="(hospital) in filteredListOfHospitals" v-if="usersData.length > 0" :value="hospital.first_name+' '+hospital.last_name" @click="sortedItems"></option>
                                    </datalist>

                                    <!--<select name="sort_by_hospital" id="sort_by_hospital" @change="sortedItems">
                                        <option>Select Hospital</option>
                                        <option v-for="(hospital, index) in filteredList" v-if="usersData.length > 0" :value="hospital.id">{{hospital.first_name}} {{hospital.last_name}}</option>
                                    </select>-->
                                </div>
                            </div>
                            <div class="mobile_filter_group mobile_space last_filter">
                                <div class="mobile_heading">
                                    <h4>Choose Fee</h4>
                                </div>
                                <div class="fee_filter">
                                    <select name="fees_range" id="fees_range" class="form-control" @change="sortedItems">
                                        <option value="select">Select Fee</option>
                                        <option value="free">
                                            <label> Free </label>
                                        </option>
                                        <option value="1">
                                            <label> 1-500 </label>
                                        </option>
                                        <option value="501">
                                            <label> 501-1000 </label>
                                        </option>
                                        <option value="1001">
                                            <label> 1001-1500 </label>
                                        </option>
                                        <option  value="1501">
                                            <label> 1501+ </label>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <span class="clear_filter" v-if="filters">
                                <a class="dc-btn" v-on:click="clearFilters">Clear Filters</a>
                            </span>
                            <div class="mobile_filter_group footer_apply_btn">
                                <button type="submit" class="dc-btn mobile_apply_btn">
                                    Apply
                                </button>
                            </div>
                            
                            <!-- <button class="dc-btn more_filter_btn"><i class="fa fa-filter" aria-hidden="true"></i> Filters</button> -->
                        </div>
                        <!-- <div class="more_filter"></div> -->
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">
                <div class="row">
                    <div class="dc-searchresult-holder">
                        <div class="dc-searchresult-head">
                            <div class="dc-title total_results">
                                <span class="results">
                                    <label>Book from</label>
                                    <label v-model="usersData" v-if="usersData.length > 1"> <strong>{{usersData.length}}</strong></label>
                                    <label v-model="usersData" v-if="usersData.length < 2"> {{usersData.length}} <strong></strong></label>

                                    <label v-if="JSON.parse(this.resultType) !== ''">{{JSON.parse(this.resultType)}}</label>
                                    <label v-if="resultLocation.length !== 0">in {{resultLocation.title.toUpperCase()}}</label>
                                    <label v-if="resultSpeciality.length !== 0 || resultDiseases.length !== 0 ">related</label>
                                    <label v-if="resultSpeciality.length !== 0"> {{resultSpeciality.title.toUpperCase()}}</label>
                                    <label v-if="resultDiseases.length !== 0"> {{resultDiseases.title.toUpperCase()}}</label>

                                </span>
                            </div>
                                <!--<div class="dc-rightarea">
                                    <div class="dc-select">
                                    </div>
                                    <div class="dc-select">
                                    </div>
                                </div>-->
                            <button class="dc-btn more_filter_btn"><i class="fa fa-filter" aria-hidden="true"></i> Filters</button>
                            <div class="relevance_option">
                                <span>Sort By:</span>
                                <select name="sort_by" id="sort_by" @change="sortedItems" class="form-control">
                                    <option value="relevance">Relevance</option>
                                    <option value="ascending">Ascending</option>
                                    <option value="descending">Descending</option>
                                    <option value="feeLow">Fee (low to high )</option>
                                    <option value="feeHigh">Fee (high to low )</option>
                                    <option value="rating">Patient rating</option>
                                    <option value="experience">Years of experience</option>
                                </select>
                            </div>
                        </div>
                        <div class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo la-searchvlistvtwo">
                            <div class="dc-docpostholder" v-if="usersData.length > 0 && index < doctorsToShow" v-for="(doc, index) in this.usersData">
                                <div class="dc-docpostcontent">
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 float-left border_right">
                                        <div class="dc-searchvtwo">
                                            <div class="search_doctor_img">
                                                <figure class="dc-docpostimg">
                                                    <img v-if="doc.profile.avatar !== null" v-bind:src="'/uploads/users/'+doc.profile.user_id+'/' + doc.profile.avatar" :alt="doc.profile.avatar" :alt-text="doc.first_name + ' ' + doc.last_name">
                                                    <img v-else v-bind:src="'/uploads/users/default/small-default.jpg'" :alt="doc.profile.avatar" :alt-text="doc.first_name + ' ' + doc.last_name">
                                                    <figcaption v-if="doc.roles[0].name === 'doctor' && videoConsul(doc)">
                                                        <span class="dc-featuredtag"><i class="fa fa-video"></i></span>
                                                    </figcaption>
                                                </figure>
                                                <div class="dc-btnarea">
                                                    <a :href="'/profile/'+doc.slug" class="btn badge profile_btn"> <i class="fas fa-user-circle" aria-hidden="true"></i> {{ trans('lang.visit_profile') }}</a>
                                                </div>
                                            </div>
                                            <div class="dc-title">
                                                <a :href="'/speciality/'+doc.specialities[0].slug" class="dc-docstatus" v-if="doc.specialities.length > 0">{{doc.specialities[0].title}}</a>
                                                <h3><a :href="'/profile/'+doc.slug">{{doc.first_name+" "+doc.last_name}}</a>
                                                    <i v-tooltip="'<em>'+verified_message+'</em>'" v-if="doc.profile.verify_medical" class="far fa-check-circle" ></i>
                                                    <i v-tooltip="'<em>'+medical_message+'</em>'" v-if="doc.profile.verify_registration" class="icon-sheild"></i>
                                                </h3>
                                                <ul class="dc-docinfo">
                                                    <li><em>{{doc.profile.sub_heading}}</em></li>
                                                    <li v-if="doc.profile.total_experience !== null && doc.roles[0].name === 'doctor'"><span><b>{{ doc.profile.total_experience }} Year</b> Experience</span></li>
                                                    <li class="dc-doclocation p-1" v-if="doc.roles[0].name === 'doctor'">
                                                        <span v-if="doc.profile.starting_price == null" class="fee_package">
                                                            <!--<i class="ti-wallet"></i>{{ trans('lang.starting_from') }} Rs - 0-->
                                                        </span>
                                                        <span v-else class="fee_package">
                                                            <i class="ti-wallet"></i>{{ trans('lang.starting_from') }} Rs - {{doc.profile.starting_price}} :
                                                        </span>
                                                        <em style="color: #1abc9c">{{waitingTimeAverage(doc.feedbacks)}}</em>
                                                    </li>
                                                    <li>
                                                        <span class="dc-stars" v-if="doc.feedbacks.length > 0">
                                                            <span v-bind:style="{ width: ((doc.profile.votes / doc.feedbacks.length) * 100)+'%'}"></span>
                                                        </span>
                                                        <span class="dc-stars" v-else>
                                                            <span v-bind:style="{ width: '0%'}"></span>
                                                        </span>
                                                        <em v-if="doc.feedbacks.length > 0">{{doc.feedbacks.length}}</em>
                                                        <em v-else> {{ trans('lang.no_feedback') }} </em>
                                                    </li>
                                                </ul>
                                            </div>
                                                <!--<div class="dc-tags">
                                                    <ul>
                                                        <div v-for="(service, index) in doc.services">
                                                            <li v-if="index <= 3">
                                                                <a :href="'/service/'+service.slug">{{service.title}}</a>
                                                            </li>
                                                            <li style="display:none" v-else :class="'hide_items'+doc.id">
                                                                <a :href="'/service/'+service.slug">{{service.title}}</a>
                                                            </li>
                                                        </div>
                                                        <li class="dc-viewall-services" v-if="doc.services.length > 1">
                                                            <a href="javascript:;" :id="'view-service-'+doc.id" class="dc-tagviewall" v-on:click="showAllServices(doc.id)">View All</a>
                                                        </li>
                                                    </ul>
                                                </div>  -->

                                            <a v-if="savedDoctor != null && savedDoctor.includes(doc.id)" :class="'doctor-'+doc.id" class="dc-like dc-clicksave" @click="wishlist(doc.id, savedDoctor, 'saved_doctors')" href="javascript:void(0);">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                            <a v-else class="dc-like" :class="'doctor-'+doc.id" @click="wishlist(doc.id, savedDoctor, 'saved_doctors')" href="javascript:void(0);">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 float-left">
                                        <div class="dc-doclocation dc-doclocationvtwo">
                                            <span v-if="doc.location !== null">
                                                <i class="ti-direction-alt"></i>{{doc.location.title}}</span>
                                            <span v-if="doc.profile.available_days === null || doc.profile.available_days === ''">
                                                <i class="ti-calendar"></i>
                                                <em class="dc-dayon">Not Available in this week</em>
                                            </span>
                                            <span v-else>
                                                <i class="ti-calendar"></i>
                                                <em v-html="availableDaysNames(doc.profile.available_days)"></em>
                                            </span>
                                            <span v-if="!isNaN(doc.profile.votes) && doc.feedbacks.length > 0">
                                                <i class="ti-thumb-up"></i>
                                                {{((doc.profile.votes / doc.feedbacks.length) * 100).toFixed(0)}}%
                                                Satisfied Patient
                                            </span>
                                            <span>
                                                <i class="ti-comments" aria-hidden="true"></i>
                                                <a v-if="doc.feedbacks.length > 0" :href="'/profile/'+doc.slug+'#feedback'">{{doc.feedbacks.length}} Patient success stories</a>
                                                <a v-else href="#"> No success story </a>
                                            </span>
                                            <span v-if="doc.profile.available_days !== null && doc.profile.available_days !== ''">
                                                <i class="ti-clipboard"></i>
                                                <i v-html="checkAvailability(getDayName(),(doc.profile.available_days), doc.profile)"></i>
                                            </span>
                                        </div>
                                        <div class="dc-btnarea btn_group">
                                            <a v-if="doc.roles[0].name === 'doctor'" class="dc-btn custom_btn" v-on:click="showModal(doc, 'visit')">{{ trans('lang.book_now')}}</a>
                                            <a v-if="doc.roles[0].name === 'doctor' && videoConsul(doc)"  v-on:click="showModal(doc, 'online')" class="dc-btn custom_btn">
                                                <i class="fa fa-video-camera" aria-hidden="true"></i>  {{ trans('lang.book_now_video')}} </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div  v-if="usersData.length < 1">
                                <img v-bind:src="'/images/empty-images/no-record.png'">
                                <span>No record</span>
                            </div>
                            <div class="dc-pagination pagination_btn" v-if="doctorsToShow < usersData.length || usersData.length > doctorsToShow">
                                <button class="dc-btn" @click="doctorsToShow += 15">Show More</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="resultDiseases.length !== 0">
                    <div class="dc-services-holder dc-aboutinfo mt-4">
                        <div class="dc-infotitle">
                            <h3> Brief description about <strong>{{resultDiseases.title}}</strong>  </h3>
                        </div>
                        <div>
                            <span class="m-1" v-html="resultDiseases.description">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="resultDiseases.length !== 0">
                    <div class="dc-services-holder dc-aboutinfo mt-4">
                        <div class="dc-infotitle">
                            <h3><strong>{{resultDiseases.title}}</strong> Related Treatments </h3>
                        </div>
                        <div v-if="resultDiseases.treatment.length > 0" class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo la-searchvlistvtwo">
                            <div class="dc-tags">
                                <ul>
                                    <div >
                                        <li v-for="treatment in resultDiseases.treatment"><a href="#"> {{treatment.title}} </a></li>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div  v-else>
                            <img v-bind:src="'/images/empty-images/no-record.png'">
                            <span>No record</span>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="resultDiseases.length !== 0">
                    <div class="dc-services-holder dc-aboutinfo mt-4">
                        <div class="dc-infotitle">
                            <h3><strong>{{resultDiseases.title}}</strong> Related Services </h3>
                        </div>
                        <div v-if="resultDiseases.services.length > 0" class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo la-searchvlistvtwo">
                            <div class="dc-tags">
                                <ul>
                                    <div >
                                        <li v-for="service in resultDiseases.services"><a href="#"> {{service.title}} </a></li>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div  v-else>
                            <img v-bind:src="'/images/empty-images/no-record.png'">
                            <span>No record</span>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="resultLocation.length !== 0">
                    <div class="dc-services-holder dc-aboutinfo mt-4">
                        <div class="dc-infotitle">
                            <h3> Specialities in <strong>{{resultLocation.title}}</strong>  </h3>
                        </div>
                        <div class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo la-searchvlistvtwo">
                            <div class="dc-tags">
                                <ul>
                                    <div >
                                        <li v-for="speciality in resultLocation.specialities"><a href="#">  {{speciality.title}} in {{resultLocation.title}} </a></li>
                                    </div>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row" v-if="resultLocation.length !== 0">
                    <div class="dc-services-holder dc-aboutinfo mt-4">
                        <div class="dc-infotitle">
                            <h3> Hospitals in <strong>{{resultLocation.title}}</strong>  </h3>
                        </div>
                        <div class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo la-searchvlistvtwo">
                            <div class="dc-tags">
                                <ul>
                                    <div >
                                        <li v-for="user in resultLocation.users" v-if="user.roles[0].name === 'hospital'"><a href="#">  {{user.first_name}} {{user.last_name}} </a></li>
                                    </div>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row" v-if="resultSpeciality.length !== 0">
                    <div class="dc-services-holder dc-aboutinfo mt-4">
                        <div class="dc-infotitle">
                            <h3> Brief description about <strong>{{resultSpeciality.title}}</strong>  </h3>
                        </div>
                        <div>
                            <span v-html="resultSpeciality.description"></span>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="resultSpeciality.length !== 0">
                    <div class="dc-services-holder dc-aboutinfo" style="margin: 20px 0 0 0">
                        <div class="dc-infotitle">
                            <h3>Frequently Asked Questions</h3>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card" v-for="(doc, index) in resultFaqs">
                            <div class="card-header" :id="'heading-'+index">
                                <h5 class="mb-0">
                                    <a class="collapsed" role="button" data-toggle="collapse" :href="'#collapse-'+index" aria-expanded="false" :aria-controls="'collapse-'+index">
                                        <span style="font-family: 'Open Sans',Arial,Helvetica,sans-serif;"> {{JSON.parse(doc.faqs.description)[0]}} </span>
                                    </a>
                                </h5>
                            </div>
                            <div :id="'collapse-'+index" class="collapse" data-parent="#accordion" :aria-labelledby="'heading-'+index">
                                <div class="card-body">
                                    <span style="font-family: 'Open Sans',Arial,Helvetica,sans-serif;" v-html="JSON.parse(doc.faqs.description)[1]"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 less_padding" v-if="JSON.parse(this.resultType) === 'doctor'">
                <div class="dc-searchresult-head">
                    <div class="dc-title map_sec_heading">
                        <h4>Hospitals and Doctors Near You</h4>
                    </div>
                </div>
                <div class="google_map_main">
                    <div class="google_map">
                        <google-map
                                v-if="lati"
                                :center="{lat:lati.coords.latitude, lng:lati.coords.longitude}"
                                :zoom="12"
                                style="width: 100%; height: 500px"
                        >
                            <gmap-info-window
                                    :options="{maxWidth: 900}"
                                    :position="infoWindow.position"
                                    :opened="infoWindow.open"
                                    @closeclick="infoWindow.open=false">
                                <div v-html="infoWindow.template"></div>
                            </gmap-info-window>
                            <!--<google-maps-circle ref="circle"
                                                :center="{lat:lati.coords.latitude, lng:lati.coords.longitude}"
                                                :editable='true'
                            >
                            </google-maps-circle>-->
                            <GmapMarker ref="myMarker"
                                        :position="{lat:lati.coords.latitude, lng:lati.coords.longitude}"
                                        :title="'Your Current Postion'"
                            />
                            <!--<GmapMarker v-for="(doc, index) in this.usersData"
                                        v-if="doc.roles[0].name === 'hospital'"
                                        v-bind:data="doc"
                                        v-bind:key="doc.text"
                                        ref="myMarker"
                                        :title="doc.first_name + ' '+ doc.last_name"
                                        :position="{lat:Number(doc.profile.latitude), lng:Number(doc.profile.longitude)}"
                                        @click="openInfoWindowTemplate(doc)"
                                        :icon="{url: require('../../../../public/uploads/markers/hospital.png')}"
                            />
                            <GmapMarker v-for="(doc, index) in this.usersData"
                                        v-if="doc.roles[0].name === 'doctor'"
                                        v-bind:data="doc"
                                        v-bind:key="doc.text"
                                        ref="myMarker"
                                        :title="doc.first_name + ' '+ doc.last_name"
                                        :position="{lat:Number(doc.profile.latitude), lng:Number(doc.profile.longitude)}"
                                        @click="openInfoWindowTemplate(doc)"
                                        :icon="{url: require('../../../../public/uploads/markers/doctor.png')}"
                            />-->
                        </google-map>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-else>
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9" >
                <img v-bind:src="'/images/empty-images/no-record.png'">
                <span>No record</span>
            </div>
        </div>

        <b-modal @hidden="onClose" ref="appointment_modal" size="lg" class="dc-feedbackpopup booking_modal" hide-footer :title="trans('lang.book_appointment')" no-close-on-backdrop>

            <div class="dc-appointmentpopup">
                <div class="dc-modalcontent modal-content custom_modal_outer" >
                    <section class="sec1">
                        <form id="submit_appointment_form" v-on:submit.prevent="checkAppointmentStep1" v-if="steps === 1">
                            <div class="dc-visitingdoctor" v-cloak>
                                <book-appointment
                                        :doctor_data="doctor_data"
                                        :user_id="doctor_id"
                                        :hospitals="doctor_hospitals"
                                        :currency="'PKR'"
                                        :type="a_type"
                                >
                                </book-appointment>
                                <div class="modal-footer dc-modal-footer modal_booknow_btn">
                                    <button class="btn dc-btn btn-primary" type="submit"> {{trans('lang.book_now')}} </button>
                                </div>
                            </div>
                        </form>
                        <div class="dc-visitingdoctor form-row dc-popup-row" v-cloak v-if="steps === 2">
                            <form id="quick_registeration" v-on:submit.prevent="quickLogin">
                                <span class="dc-appointment-holder slider_arrow">
                                    <h3>{{trans('lang.phone_no')}}</h3>
                                </span>
                                <div class="form-group col-md-8 col-lg-8 col-sm-12 col-xs-12 logout_fields">
                                    <div class="country-code">+92</div>
                                    <input type="text" class="form-control"  name="phone_number" placeholder="3XX XXXX XXX">
                                    <small class="text-danger" id="error-phone"></small>
                                </div>
                                <div class="form-group modal-footer dc-modal-footer">
                                    <button class="btn dc-btn btn-primary" type="submit">Send verification code</button>
                                </div>
                            </form>
                        </div>
                        <div class="dc-visitingdoctor dc-popup-doc dc-popup-step3" v-cloak v-if="steps === 3">
                            <h5>{{ trans('lang.enter_auth_code') }}</h5>
                            <p>{{ trans('lang.verify_code_sent') }}<a href="javascript:void(0)"></a></p>
                            <input type="text" placeholder="Authentication Code Here" v-model="appointment.code" class="code_input">
                            <div class="modal-footer dc-modal-footer custom_modal_footer">
                                <button v-on:click="checkAppointmentStep3" class="btn dc-btn btn-primary">
                                    {{ trans('lang.continue') }}</button>
                            </div>
                            <vue-countdown-timer
                                    @end_callback="endCallBack('event ended hello worl')"
                                    :start-time="startTime"
                                    :end-time="endTime"
                            >

                                <template slot="start-label" slot-scope="scope">
                                    <span style="color: red" v-if="scope.props.startLabel !== '' && scope.props.tips && scope.props.labelPosition === 'begin'">{{scope.props.startLabel}}:</span>
                                    <span style="color: blue" v-if="scope.props.endLabel !== '' && !scope.props.tips && scope.props.labelPosition === 'begin'">{{scope.props.endLabel}}:</span>
                                </template>

                                <template slot="countdown" slot-scope="scope">
                                    <span>{{scope.props.minutes}}</span><i>:</i>
                                    <span>{{scope.props.seconds}}</span><i></i>
                                </template>

                                <template slot="end-label" slot-scope="scope">
                                    <span style="color: red" v-if="scope.props.startLabel !== '' && scope.props.tips && scope.props.labelPosition === 'end'">{{scope.props.startLabel}}:</span>
                                    <span style="color: blue" v-if="scope.props.endLabel !== '' && !scope.props.tips && scope.props.labelPosition === 'end'">{{scope.props.endLabel}}:</span>
                                </template>

                                <template slot="end-text" slot-scope="scope">
                                    <span style="color: green">{{ scope.props.endText}}</span>
                                </template>

                            </vue-countdown-timer>
                            <button v-on:click="resendCode" :disabled="!resendVerButton" class="btn dc-btn btn-primary">Resend Code</button>
                        </div>

                        <div class="dc-visitingdoctor dc-popup-doc dc-popup-step4" v-if="steps === 4" v-cloak>
                            <div class="dc-modal-body4-title custom_modal_head">
                                <h6>{{ trans('lang.congrats') }}</h6>
                            </div>
                            <div class="dc-modal-body4-description">
                                <p>Thank you for the appointment with Avas Nguyen Soon we will get back to you.</p>
                            </div>
                            <div class="modal-footer dc-modal-footer custom_footer_btn">
                                <a href="javascript:void(0);" v-on:click="finalStep(false)" class="btn dc-btn btn-primary">View Appointment Status</a>
                                <a href="javascript:void(0);" v-on:click="finalStep(true)" class="btn dc-btn btn-primary">{{ trans('lang.checkout') }}</a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </b-modal>

    </div>
</template>

<script>
  import Vue from 'vue'
    import $ from "../../../../public/js/vendor/jquery-library";
    import GmapMarker from 'vue2-google-maps/src/components/marker'
    import * as VueGoogleMaps from 'vue2-google-maps'
    import VTooltip from 'v-tooltip'

  Vue.component('gmap-cluster', VueGoogleMaps.Cluster);
  Vue.component('google-map', VueGoogleMaps.Map);
  Vue.component('google-maps-circle', VueGoogleMaps.Circle)
  Vue.component('gmap-info-window', VueGoogleMaps.InfoWindow)
  Vue.component('GmapMarker', GmapMarker)

    export default {
      components: {VTooltip},
      name: "SearchPageComponent",
        props: ['userData', 'resultType', 'resultLocation', 'resultService', 'resultDiseases', 'resultSpeciality', 'resultKeywords'],
        data() {
          return {
              usersData: this.userData,
              startTime:  (new Date).getTime(),
              endTime:  (new Date).getTime()+60000,
              faqsType: '',
              resendCodeMessage: false,
              resendCodeTime: false,
              resendVerButton: false,
              verificationButton: false,
              quickLoginButton: false,
              resultFaqs: [],
              locationResult: [],
              diseaseResult: [],
              serviceResult: [],
              specialityResult: [],
              hospitals: [],
              users: [],
              verified_message: 'Verified User',
              medical_message: 'Medical Registration Verified',
              countDown : 10,
              allHospitals: [],
              savedDoctor: [],
              availableData: '',
              a_type: '',
              doctorsToShow: 15,
              totalDoctors: 0,
              enableSort: false,
              sorting: -1,
              steps:0,
              lati: null,
              longi: null,
              doctor_hospitals: [],
              hospitals_data: [],
              doctor_id:0,
              doctor_data: [],
              doctor_name:'',
              doctor_spec:'',
              doctor_education: '',
              doctor_experience: '',
              doctor_verfied_check: '',
              doctor_reg_check: '',
              appointment: [],
              patientData: [],
              appointment_last_id:'',
              loading: false,
              date: '',
              fees:0,
              filters:false,
              search: '',
              checkbydate: '',
              disabledDatesFrom: {
                to: new Date(),
                from: null
              },
              infoWindow: {
                position: {lat: 0, lng: 0},
                open: false,
                template: ''
              },
              notificationSystem: {
                options: {
                  theme: 'dark',
                  success: {
                    position: 'topRight',
                    timeout: 4000
                  },
                  error: {
                    position: 'topRight',
                    timeout: 7000
                  },
                  completed: {
                    position: 'center',
                    timeout: 1000,
                    progressBar: false,
                  },
                  info: {
                    overlay: true,
                    zindex: 999,
                    position: 'center',
                    timeout: 3000,
                    class: 'iziToast-info',
                    onClosing: function (instance, toast, closedBy) {
                      vuHome.showCompleted(vuHome.success_message);
                    }
                  }
                }
              },
          }
        },

      created() {
        this.showPosition()
        this.getAllUsers()
        this.getNext7DaysName()
        var self = this

        this.resultFaqs = this.resultSpeciality.faqs_assign, this.resultFaqs
        
        if (this.resultSpeciality.length !== 0) {
          this.faqsType = 'speciality';
        }
        else if (this.resultDiseases.length !== 0) {
          this.faqsType = 'diseases'
        }
        else if (this.resultService.length !== 0) {
          this.faqsType = 'service'
        }
        else {

        }
        console.log(this.endAt)
        /*this.usersData.forEach(function (x) {
          console.log(x.roles[0].name)
        })*/
      },
      mounted() {
        var self = this
        this.userData.forEach(function (user) {
          if (user.roles[0].name === 'hospital'){
            self.hospitals.push(user)
          }
        })
        var today = moment();
        this.date = today.format('YYYY-MM-DD')
      },
      computed: {
        filteredList() {
          return this.hospitals.filter(hospital => {
            return (hospital.first_name+' '+hospital.last_name).toLowerCase().includes(this.search.toLowerCase())
          })
        },
        computedDate: function() {
          return this.date;
        },
        filteredListOfHospitals() {
          return this.hospitals.filter(hospital => {
            return (hospital.first_name+' '+hospital.last_name).toLowerCase().includes(this.search.toLowerCase())
          })
        }
      },
      watch: {},
      methods: {
          startCallBack: function (x) {
              console.log(x)
          },
          endCallBack: function (x) {
              this.resendVerButton = !this.resendVerButton
          },
        jsonParseConvert() {
          if (this.resultDiseases) {
            this.diseaseResult = JSON.parse(this.resultDiseases)
          }
          if (this.resultLocation) {
            this.locationResult = JSON.parse(this.resultLocation)
          }
          if (this.resultService) {
            this.serviceResult = JSON.parse(this.resultService)
          }
          if (this.resultSpeciality) {
            this.specialityResult = JSON.parse(this.resultSpeciality)
          }
        },
        openInfoWindowTemplate (item) {
          this.setInfoWindowTemplate(item)
          this.infoWindow.position = {lat:Number(item.profile.latitude), lng:Number(item.profile.longitude)};
          this.infoWindow.open = true
        },
        setInfoWindowTemplate: function (marker) {
          console.log(marker)
          this.infoWindow.template = `
          <div>
          <img src="${'/uploads/users/'+marker.profile.user_id+'/small-' + marker.profile.avatar}" :alt="marker.profile.avatar" :alt-text="marker.first_name + ' ' + marker.last_name">
            <h3>${marker.first_name+' '+marker.last_name}</h3> ${marker.profile.tagline}<br>
            ${marker.profile.address}<br>
            ${marker.assistant_phone_number}<br>
           </div>`;
          return this.infoWindow.template;
        },
        waitingTimeAverage (feedback) {
          let totalTime = 0
          feedback.forEach(function (time) {
            if (time.waiting_time !== 0) {
              totalTime = parseInt(time.waiting_time) + parseInt(totalTime)
            }
          })
          if (totalTime !== 0) {
            let wait =  Math.round(totalTime / feedback.length)
            if (wait === 1) {
              return ' Waiting Time 15 min '
            }
            else if (wait === 2) {
              return ' Waiting Time 30 min '
            }
            else if (wait === 3) {
              return ' Waiting Time 60 min '
            }
            else {
              return ' Waiting Time More then 1 hr '
            }
          }
        },
        checkByDate () {
          this.checkbydate = true;
          this.sortedItems();
        },
        clearFilters() {
          $('input:checked').prop('checked',false);
          $("option:selected").removeAttr("selected");
          this.filters = false
          this.search = ''
          return this.usersData = this.userData
        },
        sortedItems () {
          let self = this
          this.loading = true
          var currentday = moment(this.date).format('ddd')

          this.usersData = this.userData
          let sort_by = $('#sort_by').val()
          let fees_range = $('#fees_range').val()

          let sort_by_hospital = false;
          /*let e = document.getElementById('sort_by_hospital')
          let sort_by_hospital = e.options[e.selectedIndex].value;*/
          let male = document.querySelector('#male').checked;
          let female = document.querySelector('#female').checked;
          let availableToday = document.querySelector('#available_today').checked;
          let videoConsultation = document.querySelector('#video_check').checked;
          let available_next_7_days = document.querySelector('#available_next_7_days').checked;
          // let child = document.querySelector('#child').checked;
          let available_next_3_days = document.querySelector('#available_next_3_days').checked;
          let available_tomorrow = document.querySelector('#available_tomorrow').checked;

          if(this.search === '') {
            this.usersData = this.userData
          }

          if (fees_range !== 'select') {
            let selected_id = fees_range

            if (selected_id === 'free'){
              this.usersData = this.usersData.filter(function (a) {
                if (a.profile.starting_price < 1) {
                  return true
                }
              })
            }
            else if (selected_id === '1501'){
              let first_price = parseInt(fees_range)
              this.usersData = this.usersData.filter(function (a) {
                if (a.profile.starting_price >= first_price) {
                  return true
                }
              })
            }
            else {
              let first_price = parseInt(fees_range)
              let second_price = parseInt(fees_range) + 499
              this.usersData = this.usersData.filter(function (a) {
                if (a.profile.starting_price >= first_price && a.profile.starting_price <= second_price) {
                  return true
                }
              })
            }
          }
          /*if (child) {
            let result = false
            this.usersData = this.usersData.filter(function(a){
              result = false
              if (a.specialities.length > 0) {
                a.specialities.forEach(function (specialities) {
                  if(specialities.title === 'Child Medicine') {
                    return result = true
                  }
                  return result
                })
                return result
              }
            })
          }*/
          if (available_tomorrow) {
            let result = false
            this.usersData = this.usersData.filter(function(a){
              result = false;
              if (a.profile.available_days !== null) {
                if ((JSON.parse(a.profile.available_days)).filter(x => self.getNextName().includes(x)).length < 1) {
                  return result = false
                }
                else {
                  return result = true;
                }
              }
              return result;
            })
          }
          if (available_next_3_days) {
            let result = false
            this.usersData = this.usersData.filter(function(a){
              result = false;
              if (a.profile.available_days !== null) {
                if (((JSON.parse(a.profile.available_days)).filter(x => self.getNext3DaysName().includes(x))).length < 1) {
                  return result = false
                }
                else {
                  return result = true;
                }
              }
              return result;
            })
          }
          if (available_next_7_days) {
            let result = false
            this.usersData = this.usersData.filter(function(a){
              result = false;
              if (a.profile.available_days !== "" && a.profile.available_days !== null) {
                if (((JSON.parse(a.profile.available_days)).filter(x => self.getNext7DaysName().includes(x))).length < 1) {
                  return result = false
                }
                else {
                  return result = true;
                }
              }
              return result;
            })
          }
          this.usersData.forEach(function (user) {
            if (user.appointments.length > 0) {
              user.appointments.forEach(function (appointment) {
              })
            }
          })
          if (self.checkbydate){
            this.usersData = this.usersData.filter(function (a) {
              if (a.profile.available_days !== null) {
                return JSON.parse(a.profile.available_days).includes(currentday.toLowerCase())
              }
            })
          }

          if(this.search !== '') {
            var selected_hospital_id = []
            let self = this
            let result = false
            selected_hospital_id = this.hospitals.filter(function (a) {
              if (a.first_name + ' ' + a.last_name === self.search) {
                return true
              }
              return false
            })
            if (selected_hospital_id !== []) {
              this.usersData = this.usersData.filter(function (a) {
                result = false
                if (a.doc_teams.length > 0) {
                  a.doc_teams.filter(function (team) {
                    if (team.user_id === JSON.stringify(selected_hospital_id[0].id)) {
                      return result = true
                    }
                    return result
                  })
                  return result
                }
                return result
              })
            }
          }

          /*if (sort_by_hospital !== null && sort_by_hospital !== "Select Hospital"){
            var hospital
            let hospital_name = $('#input_sort_by_hospital').val()
            hospital = this.hospitals.filter(function (a) {
              if (a.first_name+' '+a.last_name === hospital_name){
                return true;
              }
              return false;
            })
              let result = false
              this.usersData = this.usersData.filter(function (a) {
                result = false
                if (a.doc_teams.length > 0) {
                  a.doc_teams.forEach(function (team) {

                    if (team.user_id === JSON.stringify(hospital.id)) {
                      console.log(team.user_id === JSON.stringify(hospital[0].id), team.user_id, JSON.stringify(hospital[0].id))
                      result = true
                    }
                  })
                }
                return result
              })
            console.log(hospital.id, this.usersData)
          }*/

          if (availableToday) {
            this.usersData = this.usersData.filter(function(a){
              if (a.profile.available_days !== null) {
                return JSON.parse(a.profile.available_days).includes(self.getDayName())
              }
            })
          }
          if (videoConsultation) {
            let result = false
            this.usersData = this.usersData.filter(function(a){
              result = false;
              if (a.doc_teams.length > 0){
                a.doc_teams.forEach(function (teams) {
                  if (teams.user_id === 'online'){
                    result = true;
                  }
                })
              }
              return result;
            })
          }
          if (male && female) {
            this.usersData = this.usersData.filter(function(a){
              return a.profile.gender === 'male' || a.profile.gender === 'female'
            })
          }
          else if (male) {
            this.usersData = this.usersData.filter(function(a){
              return a.profile.gender === 'male'
            })
          }
          else if (female) {
            this.usersData = this.usersData.filter(function(a){
              return a.profile.gender === 'female'
            })
          }
          if (sort_by === 'experience') {
            this.usersData.sort(function(a, b){
              if (a.profile.total_experience > b.profile.total_experience) { return -1; }
              if (a.profile.total_experience < b.profile.total_experience) { return 1; }
              return 0;
            })
          }
          if (sort_by === 'descending') {
            this.usersData.sort(function(a, b){
              if (a.first_name.toLowerCase() > b.first_name.toLowerCase()) { return -1; }
              if (a.first_name.toLowerCase() < b.first_name.toLowerCase()) { return 1; }
              return 0;
            })
          }
          if (sort_by === 'ascending') {
            this.usersData.sort(function(a, b){
              if (a.first_name.toLowerCase() < b.first_name.toLowerCase()) { return -1; }
              if (a.first_name.toLowerCase() > b.first_name.toLowerCase()) { return 1; }
              return 0;
            })
          }
          if (sort_by === 'feeLow') {
            this.usersData.sort(function(a, b){
              if (a.profile.starting_price < b.profile.starting_price) { return -1; }
              if (a.profile.starting_price > b.profile.starting_price) { return 1; }
              return 0;
            })
          }
          if (sort_by === 'feeHigh') {
            this.usersData.sort(function(a, b){
              if (a.profile.starting_price > b.profile.starting_price) { return -1; }
              if (a.profile.starting_price < b.profile.starting_price) { return 1; }
              return 0;
            })
          }
          if (sort_by === 'rating') {
            this.usersData.sort(function(a, b){
              if (a.profile.votes > b.profile.votes ) { return -1; }
              if (a.profile.votes < b.profile.votes )  { return 1; }
              return 0;
            })
          }

          if (
            sort_by === 'relevance' && fees_range === 'select' && male === false && female === false &&
            availableToday === false && videoConsultation === false && available_next_7_days === false &&
            available_next_3_days === false && available_tomorrow === false
          ) {
            this.filters = false
          }
          else {
            this.filters = true
          }
          self.loading = false
          self.checkbydate = false;
          return self.usersData;
        },
        showCompleted(message) {
          return this.$toast.success(' ', message, this.notificationSystem.options.completed)
        },
        showInfo(message) {
          return this.$toast.info(' ', message, this.notificationSystem.options.info)
        },
        showMessage(message) {
          return this.$toast.success(' ', message, this.notificationSystem.options.success)
        },
        showError(error) {
          return this.$toast.error(' ', error, this.notificationSystem.options.error)
        },
        prev: function () {
          this.steps--
        },
        next: function () {
          this.steps++
        },
        videoConsul (doc) {
          let result = false
          doc.doc_teams.forEach(function (team) {
            if (team.user_id === 'online') {
              result = true
            }
          })
          return result;
        },
        showAllServices: function (class_list) {
          $('.hide_items'+class_list).css({ display: "block" });
          $('#view-service-'+class_list).hide();
        },
        getDayName: function () {
          var currentDate = new Date();
          var weekday = new Array(7);
          weekday[0] = "sun";
          weekday[1] = "mon";
          weekday[2] = "tue";
          weekday[3] = "wed";
          weekday[4] = "thu";
          weekday[5] = "fri";
          weekday[6] = "sat";
          return weekday[currentDate.getDay()];
        },
        getNext7DaysName: function () {
          var day = [];
          day.push((moment().format('ddd')).toLowerCase().trim());
          day.push((moment().add(1, 'day').format('ddd')).toLowerCase().trim());
          day.push((moment().add(2, 'day').format('ddd')).toLowerCase().trim());
          day.push((moment().add(3, 'day').format('ddd')).toLowerCase().trim());
          day.push((moment().add(4, 'day').format('ddd')).toLowerCase().trim());
          day.push((moment().add(5, 'day').format('ddd')).toLowerCase().trim());
          day.push((moment().add(6, 'day').format('ddd')).toLowerCase().trim());
          return day;
        },
        getNext3DaysName: function () {
          var day = [];
          day.push((moment().format('ddd')).toLowerCase().trim());
          day.push((moment().add(1, 'day').format('ddd')).toLowerCase().trim());
          day.push((moment().add(2, 'day').format('ddd')).toLowerCase().trim());
          return day;
        },
        getNextName: function () {
          var day = [];
          day.push((moment().add(1, 'day').format('ddd')).toLowerCase().trim());
          return day;
        },
        checkAvailability: function (dayName, availableDays) {
          if (availableDays !== '') {
            availableDays = JSON.parse(availableDays)

            let availability = '';
            let day1 = ((moment().format('ddd')).toLowerCase().trim());
            let day2 = ((moment().add(1, 'day').format('ddd')).toLowerCase().trim());
            let day3 = ((moment().add(2, 'day').format('ddd')).toLowerCase().trim());
            let day4 = ((moment().add(3, 'day').format('ddd')).toLowerCase().trim());
            let day5 = ((moment().add(4, 'day').format('ddd')).toLowerCase().trim());
            let day6 = ((moment().add(5, 'day').format('ddd')).toLowerCase().trim());
            let day7 = ((moment().add(6, 'day').format('ddd')).toLowerCase().trim());

            if (availableDays !== null) {
              if (availableDays.includes(dayName) === true) {
                return availability = '<em class="dc-available">Available Today</em>'
              } else if (availableDays.includes(day2)) {

                return availability = '<em class="dc-available"> Available Tomorrow </em>'
              } else if (availableDays.includes(day3)) {
                return availability = '<em class="dc-available"> Available on ' + moment().add(2, 'day').format('dddd') + ' </em>'
              } else if (availableDays.includes(day4)) {
                return availability = '<em class="dc-available"> Available on ' + moment().add(3, 'day').format('dddd') + ' </em>'
              } else if (availableDays.includes(day5)) {
                return availability = '<em class="dc-available"> Available on ' + moment().add(4, 'day').format('dddd') + ' </em>'
              } else if (availableDays.includes(day6)) {
                return availability = '<em class="dc-available"> Available on ' + moment().add(5, 'day').format('dddd') + ' </em>'
              } else if (availableDays.includes(day7)) {
                return availability = '<em class="dc-available"> Available on ' + moment().add(6, 'day').format('dddd') + ' </em>'
              } else {
                return availability = '<em class="dc-dayon">Not Available</em>'
              }
            } else {
              return availability = '<em class="dc-dayon">Not Available</em>'
            }
            return availability;
          }
          else {

          }
        },
        getCurrentUsersSaved: function () {
          let self = this;
          axios.get(APP_URL + '/getCurrentUsersSaved')
            .then(function (response) {
              if(response.data != null){
                if(response.data.saved_doctors.length > 0) {
                  self.savedDoctor = JSON.parse(response.data.saved_doctors);
                }
                if(response.data.saved_hospital != null) {
                  self.savedHospital = response.data.saved_hospital;
                }
              }
            })
        },
        showPosition: function() {
          navigator.geolocation.getCurrentPosition(pos => {
            this.lati = pos;
          }, err => {
          })

        },
        getAllUsers: function () {
          let self = this;
          axios.get(APP_URL + '/getAllDoctors')
            .then(function (response) {
              self.allHospitals = response.data.hospitals;
            })
        },
        wishlist: function (id, savedDoc, column) {
          let self = this;
          let form_errors = [];
          if (self.savedDoctor == null) {
            axios.post(APP_URL + '/user/add-wishlist', {
              id: id,
              column: column,
            }).then(function (response) {
              console.log(response)
              if (response.data.authentication == true) {
                  if (response.data.type == 'success') {
                    if (column == 'saved_doctors') {
                      $('.doctor-' + id).addClass('dc-clicksave');
                      self.savedDoctor.push(id);
                      form_errors.push(Vue.prototype.trans(response.data.message));
                      form_errors.forEach(element => {
                        self.showMessage(element)
                      });
                    }
                    else if (column == 'saved_hospitals') {
                      $('#' + element_id).addClass('dc-like dc-clicksave');
                    }
                    else if (column == 'saved_articles') {
                      self.article_likes = response.data.likes;
                      self.show_likes = true;
                      $('#' + element_id).addClass('dc-clicksave');
                    }
                  } else {
                    form_errors.push(Vue.prototype.trans(response.data.message));
                    form_errors.forEach(element => {
                      self.showError(element)
                    });
                  }
                } else {
                  form_errors.push(Vue.prototype.trans(response.data.message));
                  form_errors.forEach(element => {
                    self.showError(element)
                  });
                }
              }).catch(function (error) {
                form_errors.push(Vue.prototype.trans(error));
                form_errors.forEach(element => {
                  self.showError(element)
                });
              });
            }
            else if (self.savedDoctor.includes(id) == true) {
              axios.post(APP_URL + '/user/remove-wishlist', {
                id: id,
                column: column,
              }).then(function (response) {
                if (response.data.authentication == true) {
                  if (response.data.type == 'success') {
                    if (column == 'saved_doctors') {
                      $('.doctor-' + id).removeClass('dc-clicksave');
                      self.savedDoctor.pop(id);
                      form_errors.push(Vue.prototype.trans(response.data.message));
                      form_errors.forEach(element => {
                        self.showInfo(element)
                      });
                    }
                  }
                }
              })
            }
            else if (self.savedDoctor.includes(id) == false) {
              axios.post(APP_URL + '/user/add-wishlist', {
                id: id,
                column: column,
              }).then(function (response) {
                if (response.data.authentication == true) {
                  if (response.data.type == 'success') {
                    if (column == 'saved_doctors') {
                      $('.doctor-' + id).addClass('dc-clicksave');
                      self.savedDoctor.push(id);
                      form_errors.push(Vue.prototype.trans(response.data.message));
                      form_errors.forEach(element => {
                        self.showMessage(element)
                      });
                    }
                    else if (column == 'saved_hospitals') {
                      $('#' + element_id).addClass('dc-like dc-clicksave');
                    }
                    else if (column == 'saved_articles') {
                      self.article_likes = response.data.likes;
                      self.show_likes = true;
                      $('#' + element_id).addClass('dc-clicksave');
                    }
                  } else {
                    form_errors.push(Vue.prototype.trans(response.data.message));
                    form_errors.forEach(element => {
                      self.showError(element)
                    });
                  }
                } else {
                  form_errors.push(Vue.prototype.trans(response.data.message));
                  form_errors.forEach(element => {
                    self.showError(element)
                  });
                }
              }).catch(function (error) {
                form_errors.push(Vue.prototype.trans(error));
                form_errors.forEach(element => {
                  self.showError(element)
                });
              });
            }
          },
        showModal: function (doc, type) {
            let self = this;
            self.a_type = type;
            this.steps = 0
            var form_errors = [];

            self.loading = true;
            var hospitaldata = [];
            self.doctor_hospitals = [];

            if (type === 'visit') {
              let index = this.usersData.findIndex(x => x.id === doc.id);
              self.hospitals_data = self.usersData[index].doc_teams;
              self.hospitals_data.forEach(function (hospital) {
                let consultation_fee = ''
                consultation_fee = JSON.parse(hospital.slots).consultation_fee
                if (hospital.user_id !== 'online') {
                  hospitaldata = []
                  hospitaldata = self.allHospitals.find(x => x.id === JSON.parse(hospital.user_id))
                  if (hospitaldata !== undefined) {
                    self.doctor_hospitals.push({
                      'id': hospitaldata.id,
                      'name': hospitaldata.first_name + ' ' + hospitaldata.last_name,
                      'avatar': hospitaldata.profile.avatar,
                      'fees': consultation_fee
                    })
                  }
                }
                else {
                  self.doctor_hospitals.push({
                    'id': 'online',
                    'name': 'Online Consultation',
                    'fees' : consultation_fee,
                    'avatar' : 'video'
                  })
                }
              })
            }
            if (type === 'online') {
              let onlineTeam = ''
              let consultation_fee = ''
              this.usersData.forEach(function (x) {
                x.doc_teams.forEach(function (team) {
                  if (team.user_id === 'online') {
                    onlineTeam = team
                  }
                })
              })
              hospitaldata = []
              consultation_fee = JSON.parse(onlineTeam.slots).consultation_fee
              self.doctor_hospitals.push({
                'id': 'online',
                'name': 'Online Consultation',
                'fees' : consultation_fee,
                'avatar' : 'video'
              })
            }


            if (self.doctor_hospitals.length < 1) {
              self.loading = false;
              form_errors.push(Vue.prototype.trans('lang.hospital_not_find'));
              form_errors.forEach(element => {
                self.showError(element)
              });
              return
            }
            self.doctor_hospitals = JSON.stringify(self.doctor_hospitals)
            self.doctor_data = doc;
            self.doctor_id = doc.id;
            self.doctor_name =doc.first_name+' '+doc.last_name
            self.doctor_spec = doc.specialities
            self.doctor_education = doc.profile.educations
            self.doctor_experience = doc.profile.total_experience
            self.doctor_verfied_check = doc.profile.verify_medical
            self.doctor_reg_check = doc.profile.verify_registration
            self.next();
            self.$refs['appointment_modal'].show()
            self.loading = false;
            /*axios.get(APP_URL + '/check-login').
            then(function (response) {
              if (response.data.type === 'success') {
                self.next();
                self.$refs['appointment_modal'].show()
                self.patientData = response.data.user_details
                self.loading = false;
              }
              else {
                self.$refs['registeration_modal'].show()
                self.loading = false;
              }
            })*/
          },
        quickLogin: function () {
            let self = this;
            self.loading = true
            self.appointment.code = ''
            let formdata = document.getElementById('quick_registeration');
            var formData1 = new FormData(formdata);
            if (!formData1.get('phone_number').length > 0) {
              document.getElementById('error-phone').innerHTML = " Please Enter Your Phone *";
              return;
            }
            else if (formData1.get('phone_number').length > 11 && !(/^(\+923)([0-9]{2}[0-9]{7})$/.test(formData1.get('phone_number')))) {
              document.getElementById('error-phone').innerHTML = "Use Correct Format 3XXXXXXXXX";
              return;
            }
            else if (formData1.get('phone_number').length < 11 && !(/^(3)([0-9]{2}[0-9]{7})$/.test(formData1.get('phone_number')))) {
              document.getElementById('error-phone').innerHTML = "Use Correct Format 3XXXXXXXXX"
              return
            }
            else {
              axios.post(APP_URL + '/quick-registration', formData1)
                .then(function (response) {
                  if (response.data.type === 'success') {
                    self.patientData = response.data.user_data
                    self.endTime = (new Date).getTime()+60000
                      self.loading = false
                      self.next();
                  }
                })
                .catch(function (error) {

                });
            }
          },
        resendCode: function(){
            let self = this
            self.resendVerButton = !self.resendVerButton
            self.loading = true
            let form_errors = []
              let user_phone = self.patientData.phone_number;
              console.log(user_phone)
              axios.post(APP_URL + '/user/resend-code', {
                  number: user_phone,
              }).then(function (response) {
                  self.endTime = (new Date).getTime()+60000
                  self.loading = false
                  //console.log(response);
              }).catch(function (error) {
                  form_errors.push(Vue.prototype.trans(error));
                  form_errors.forEach(element => {
                      self.showError(element)
                  });
              });
          },
        checkAppointmentStep1: function () {
          let self = this
            self.loading = true
            let form_errors = [];
            var patient = jQuery("input[name='patient']:checked").val();
            var slotChecked = jQuery("input[name='appointment[time]']:checked").val();
            if (patient == 'someone') {
              var patient_name = document.getElementById('patient_name').value;
              if (!patient_name) form_errors.push(Vue.prototype.trans('lang.patient_name_req'));
              if (!document.getElementById('relation').value) form_errors.push(Vue.prototype.trans('lang.select_relation_req'));
              form_errors.forEach(element => {
                this.showError(element)
              });
              if (form_errors.length > 0) {
                return false;
              }

            }
            if (slotChecked !== undefined) {
              var timeSlot = document.getElementsByName('appointment[time]');
              var isTimeSlot = false;
              for (var i = 0; i < timeSlot.length; i++) {
                if (timeSlot[i].checked) {
                  isTimeSlot = true;
                  break;
                }
              }
              if (isTimeSlot === true) {
                let submitAppointmentForm = document.getElementById('submit_appointment_form')
                let formData = new FormData(submitAppointmentForm)
                let a_date = formData.get('appointment[date]')
                let a_day = formData.get('appointment[day]')
                let a_type = formData.get('type')
                if (a_date === "" || a_day === "") {
                  a_date = document.getElementsByName('appointment[date]').value
                  a_day = document.getElementsByName('appointment[day]').value
                }
                formData.append('appointment[date]', a_date)
                formData.append('appointment[day]', a_day)
                formData.append('type', a_type)
                /*let a_date = formData.get('appointment[date]')
                let a_day = formData.get('appointment[day]')
                let a_type = formData.get('type')

                console.log(a_type,a_date,a_day)

                formData.append('appointment[date]', a_date)
                formData.append('appointment[day]', a_day)
                formData.append('type', a_type)
                console.log(
                  formData.get('appointment[date]'),
                  formData.get('appointment[day]'),
                  formData.get('type'),

                )*/
                axios.post(APP_URL + '/store-appointment-data', formData)
                  .then(function (response) {
                    self.appointment.patient = response.data.patient;
                    self.appointment.comments = response.data.comments;
                    self.appointment.date = response.data.date;
                    self.appointment.day = response.data.day;
                    self.appointment.hospital = response.data.hospital;
                    self.appointment.patient_name = response.data.patient_name;
                    self.appointment.relation = response.data.relation;
                    self.appointment.speciality = response.data.speciality;
                    self.appointment.time = response.data.time;
                    self.appointment.total_charges = response.data.total_charges;
                    self.appointment.type = response.data.type;
                    self.loading = false
                      console.log(self.appointment)
                    self.next();
                  })
              } else {
                this.showError(Vue.prototype.trans('lang.select_appointment_time'))
                return false;
              }
            } else {
              form_errors.push(Vue.prototype.trans('Select slot first'))
              form_errors.forEach(element => {
                this.showError(element)
              })
              /*this.showError(Vue.prototype.trans('lang.hospital_req'))*/
              return false
            }
          },
        checkAppointmentStep3: function () {
            let self = this
            self.loading = true
            let user_id = self.patientData.id
            axios.post(APP_URL + '/verify-appointment-code', {
              code: self.appointment.code,
            })
              .then(function (response) {
                if (response.data.type == 'success') {
                  self.submitAppointment(user_id);
                } else if (response.data.type == 'error') {
                    self.loading = false
                  self.showError(response.data.message);
                }
              })
          },
        submitAppointment: function (id) {
            let self = this;
            self.loading = true;
            self.appointment.user_id = id;
            axios.post(APP_URL + '/submit-appointment', {
              patient : self.appointment.patient,
              comments : self.appointment.comments,
              date : self.appointment.date,
              day : self.appointment.day,
              hospital : self.appointment.hospital,
              patient_name : self.appointment.patient_name,
              relation : self.appointment.relation,
              speciality : self.appointment.speciality,
              time : self.appointment.time,
              total_charges : self.appointment.total_charges,
              type : self.appointment.type,
              code : self.appointment.code,
              user_id : self.doctor_id,
            })
              .then(function (response) {
                if (response.data.type === 'success') {

                  self.appointment_last_id = ''
                  self.appointment_last_id = response.data.appointment_id;
                  self.appointmentStatusMessage ()
                  if (self.appointment.type === 'online') {
                    window.location.replace(APP_URL + '/checkout/' + self.appointment_last_id)
                  }
                  else {
                    self.loading = false;
                    self.next();
                  }

                } else if (response.data.type == 'error') {
                  self.loading = false;
                  self.showError(response.data.message);
                }
              })
              .catch(error => {

              });
          },
        finalStep: function (online_appointment) {
            if (online_appointment == true) {
              window.location.replace(APP_URL + '/checkout/' + this.appointment_last_id)
            }
            else {
              window.location.replace(APP_URL + '/patient/appointments/' + this.appointment_last_id)
            }
          },
        onClose: function() {
            let self = this
            self.loading = true
            self.step = 1;
            self.appointment.patient = ''
            self.appointment.comments = ''
            self.appointment.date = ''
            self.appointment.day = ''
            self.appointment.hospital = ''
            self.appointment.patient_name = ''
            self.appointment.relation = ''
            self.appointment.speciality = ''
            self.appointment.time = ''
            self.appointment.total_charges = ''
            self.appointment.type = ''
            self.appointment.code = ''
            self.doctor_id = ''
            self.loading = false
          },
        availableDaysNames: function (dayNames, id) {
          let self = this
          var days = []
          if (dayNames !== null && dayNames !== [] && dayNames !== '') {
            dayNames = JSON.parse(dayNames)
            let weekDays = moment.weekdaysShort()
            weekDays.forEach(function (day) {
              if(dayNames.includes(day.toLowerCase())) {
                days.push('<em class="dc-available"> '+day+' </em>')
              }
              else {
                days.push('<em class="dc-dayon"> '+day+' </em>')
              }
            })
          }
          else {
            days.push('<em class="dc-dayon"> Not Available </em>')
          }


          return (JSON.stringify(days).replace(/[\\[\]"]+/g, ''))

        },
        appointmentStatusMessage: function () {
              let self = this
              let appointmentData = self.appointment
              let appointmentTime = self.appointment.time
              let appointmentDate = self.appointment.date
              let appointmentDay = self.appointment.day
              console.log(self.appointment.day, appointmentDay)
              axios.post(APP_URL + '/user/appointmentbookingstatus', {
                  appointmentData: self.appointment,
                  appointmentTime: appointmentTime,
                  appointmentDate: appointmentDate,
                  appointmentDay: appointmentDay,
                  patientData: self.patientData,
                  doctorData: self.doctor_data,
              })
                  .then(function (response) {
                      if (response.data.type == 'success') {
                          console.log(response.data)

                      } else if (response.data.type == 'error') {

                      }
                  })
          },

    },

    }
</script>

<style>
    .vdpArrowPrev:after {
        border-right-color: #cc99cd;
    }
    .vdpArrowNext:after {
        border-left-color: #cc99cd;
    }
    .vdpTimeUnit > input:hover,
    .vdpTimeUnit > input:focus {
        border-bottom-color: #cc99cd;
    }
    .vdpCell.today {
        color: #cc99cd;
    }
    .vdpCell.selectable:hover .vdpCellContent,
    .vdpCell.selected .vdpCellContent {
        background: #cc99cd;
    }

    .custom_btn{
        min-width: 75px;
        line-height: 30px;
        margin-right: 5px;
        display: block;
        max-width: 145px;
        float: left;
        font-size: 11px;
    }

    .btn_group .custom_btn:nth-of-type(2){
        margin:0px;
    }
    
    .dc-main-section{
        padding:0 15px;
    }

    .tooltip {
        display: block !important;
        z-index: 10000;
    }

    .tooltip .tooltip-inner {
        background: #00A2E8;
        color: white;
        border-radius: 4px;
        padding: 5px 10px 4px;
    }

    .tooltip .tooltip-arrow {
        width: 0;
        height: 0;
        border-style: solid;
        position: absolute;
        margin: 5px;
        border-color: #00A2E8;
        z-index: 1;
    }

    .tooltip[x-placement^="top"] {
        margin-bottom: 5px;
    }

    .tooltip[x-placement^="top"] .tooltip-arrow {
        border-width: 5px 5px 0 5px;
        border-left-color: transparent !important;
        border-right-color: transparent !important;
        border-bottom-color: transparent !important;
        bottom: -5px;
        left: calc(50% - 5px);
        margin-top: 0;
        margin-bottom: 0;
    }

    .tooltip[x-placement^="bottom"] {
        margin-top: 5px;
    }

    .tooltip[x-placement^="bottom"] .tooltip-arrow {
        border-width: 0 5px 5px 5px;
        border-left-color: transparent !important;
        border-right-color: transparent !important;
        border-top-color: transparent !important;
        top: -5px;
        left: calc(50% - 5px);
        margin-top: 0;
        margin-bottom: 0;
    }

    .tooltip[x-placement^="right"] {
        margin-left: 5px;
    }

    .tooltip[x-placement^="right"] .tooltip-arrow {
        border-width: 5px 5px 5px 0;
        border-left-color: transparent !important;
        border-top-color: transparent !important;
        border-bottom-color: transparent !important;
        left: -5px;
        top: calc(50% - 5px);
        margin-left: 0;
        margin-right: 0;
    }

    .tooltip[x-placement^="left"] {
        margin-right: 5px;
    }

    .tooltip[x-placement^="left"] .tooltip-arrow {
        border-width: 5px 0 5px 5px;
        border-top-color: transparent !important;
        border-right-color: transparent !important;
        border-bottom-color: transparent !important;
        right: -5px;
        top: calc(50% - 5px);
        margin-left: 0;
        margin-right: 0;
    }

    .tooltip.popover .popover-inner {
        background: #f9f9f9;
        color: black;
        padding: 24px;
        border-radius: 5px;
        box-shadow: 0 5px 30px rgba(black, .1);
    }

    .tooltip.popover .popover-arrow {
        border-color: #f9f9f9;
    }

    .tooltip[aria-hidden='true'] {
        visibility: hidden;
        opacity: 0;
        transition: opacity .15s, visibility .15s;
    }

    .tooltip[aria-hidden='false'] {
        visibility: visible;
        opacity: 1;
        transition: opacity .15s;
    }


</style>