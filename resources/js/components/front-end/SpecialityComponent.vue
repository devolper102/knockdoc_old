<template>
    <div>
        <div class="dc-preloader-section" v-if="loading" v-cloak>
            <div class="dc-preloader-holder">
                <div class="dc-loader"></div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="dc-main-section">
                <div class="container-fluid" id="user-profile">
                    <div id="dc-twocolumns" class="dc-twocolumns dc-haslayout">
                        <div class="row"   v-if="userData.length > 0">
                            <div class="filter_outer">
                                <div class="filter_main">
                                    <div class="filter_show">
                                        <button type="button" id="close_filter" class="close" aria-label="Close">
                                            <span aria-hidden="true"><i aria-hidden="true" class="fa fa-close"></i></span>
                                        </button>
                                        <div class="mobile_heading">
                                            <h4>Gander</h4>
                                        </div>
                                        <span class="dc-checkbox custom_checkbox">
                                            <input name="male" value="1" id="male" type="checkbox" @click="sortedItems">
                                            <label for="male"> Male</label>
                                        </span>
                                        <span class="dc-checkbox custom_checkbox mobile_border">
                                            <input name="female" value="1" id="female" type="checkbox" @click="sortedItems">
                                            <label for="female"> Female</label>
                                        </span>
                                        <!--<span class=" dc-checkbox custom_checkbox">
                                            <Datepicker
                                                    :bootstrap-styling="true"
                                                    @closed="checkByDate"
                                                    :disabledDates="disabledDatesFrom"
                                                    v-model="date"
                                                    ref="thisdate"
                                                    v-bind:value="computedDate"
                                            ></Datepicker>
                                            <span class="calander_icon"> <i class="fas fa-calendar-alt"></i> </span>
                                        </span>-->
                                        <div class="mobile_heading">
                                            <h4>Video Visit</h4>
                                        </div>
                                        <span class="dc-checkbox custom_checkbox mobile_border">
                                            <input name="video_check" value="1" id="video_check" type="checkbox" @click="sortedItems">
                                            <label for="video_check"> Video consultation </label>
                                        </span>
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
                                        <span class="dc-checkbox custom_checkbox mobile_border">
                                            <input name="child" value="1" id="child" type="checkbox" @click="sortedItems">
                                            <label for="child"> Sees Children </label>
                                        </span>
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
                                        <div class="mobile_heading">
                                            <h4>Choose Fee</h4>
                                        </div>
                                        <div class="fee_filter">
                                            <select class="form-control">
                                                <option>Select Fee</option>
                                                <option>
                                                    <input v-model="fees" name="fee" value="free" id="free" type="radio" @click="sortedItems">
                                                    <label for="free"> Free </label>
                                                </option>
                                                <option>
                                                    <input v-model="fees" name="fee" value="1" id="1_200" type="radio" @click="sortedItems">
                                                    <label for="1_200"> 1-500 </label>
                                                </option>
                                                <option>
                                                    <input v-model="fees" name="fee" value="501" id="201_500" type="radio" @click="sortedItems">
                                                    <label for="201_500"> 501-1000 </label>
                                                </option>
                                                <option>
                                                    <input v-model="fees" name="fee" value="1001" id="501_1000" type="radio" @click="sortedItems">
                                                    <label for="501_1000"> 1001-1500 </label>
                                                </option>
                                                <option>
                                                    <input v-model="fees" name="fee" value="1501" id="maximum_price" type="radio" @click="sortedItems">
                                                    <label for="maximum_price"> 1501+ </label>
                                                </option>
                                            </select>
                                        </div>
                                        <span class="clear_filter" v-if="filters">
                                            <a class="dc-btn" v-on:click="clearFilters">Clear Filters</a>
                                        </span>
                                        <!-- <button class="dc-btn more_filter_btn"><i class="fa fa-filter" aria-hidden="true"></i> More Filters</button> -->
                                    </div>
                                    <!-- <div class="more_filter"></div> -->
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
                                                    <label>Dermatologist in Lahore</label>
                                                </span>
                                            </div>
                                            <!--<div class="dc-rightarea">
                                                <div class="dc-select">
                                                </div>
                                                <div class="dc-select">
                                                </div>
                                            </div>-->
                                            <button class="dc-btn more_filter_btn"><i class="fa fa-filter" aria-hidden="true"></i> More Filters</button>
                                            <div class="relevance_option filter_option">
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
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 float-left border_right">
                                                        <div class="dc-searchvtwo">
                                                            <figure class="dc-docpostimg">
                                                                <img v-if="doc.profile.avatar !== null" v-bind:src="'/uploads/users/'+doc.profile.user_id+'/small-' + doc.profile.avatar" alt="">
                                                                <img v-else v-bind:src="'/uploads/users/default/small-default.jpg'" alt="">
                                                                <figcaption>
                                                                    <span class="dc-featuredtag"><i class="fa fa-video"></i></span>
                                                                </figcaption>
                                                            </figure>
                                                            <div class="dc-title">
                                                                <a :href="'/speciality/'+doc.specialities[0].slug" class="dc-docstatus" v-if="doc.specialities.length > 0">{{doc.specialities[0].title}}</a>
                                                                <h3><a :href="'/profile/'+doc.slug">{{doc.first_name+" "+doc.last_name}}</a>
                                                                    <i v-f="doc.profile.verify_medical" class="far fa-check-circle dc-tipso" data-tipso="<em>Verified User</em>"></i>
                                                                    <i v-if="doc.profile.verify_registration" class="icon-sheild dc-tipso" data-tipso="<em>Medical Registration Verified</em>"></i>
                                                                </h3>
                                                                <ul class="dc-docinfo">
                                                                    <li><em>{{doc.profile.sub_heading}}</em></li>
                                                                    <li v-if="doc.profile.total_experience !== null && doc.roles.name === 'doctor'"><em><b>{{ doc.profile.total_experience }} Year</b> Experience</em></li>
                                                                    <li><span><strong> 8 Years </strong> Expreience</span></li>
                                                                    <li class="dc-doclocation p-1" v-if="doc.roles[0].name === 'doctor'">
                                                                <span v-if="doc.profile.starting_price == null" class="fee_package">
                                                                    <i class="ti-wallet"></i>{{ trans('lang.starting_from') }} Rs - 0
                                                                </span>
                                                                        <span v-else class="fee_package">
                                                                    <i class="ti-wallet"></i>{{ trans('lang.starting_from') }} Rs - {{doc.profile.starting_price}} :
                                                                </span>
                                                                <em style="color: #1abc9c">{{waitingTimeAverage(doc.feedbacks)}}</em>
                                                                    </li>
                                                                    <li>
                                                                <span class="dc-stars">
                                                                    <span v-bind:style="{ width: doc.feedbacks.length+'%'}"></span>
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
                                                            <div class="dc-btnarea btn_group">
                                                                <a :href="'/profile/'+doc.slug" class="dc-btn custom_btn">{{ trans('lang.visit_profile') }}</a>
                                                                <a v-if="doc.last_name === 'hospital' || doc.last_name !== 'Hospital'" class="dc-btn custom_btn" v-on:click="showModal(doc.id, 'visit')">{{ trans('lang.book_now')}}</a>
                                                                <a v-if="videoConsul(doc) && (doc.last_name === 'hospital' || doc.last_name !== 'Hospital')" class="" v-on:click="showModal(doc.id, 'online')" class="dc-btn custom_btn">
                                                                    <i class="fa fa-video-camera" aria-hidden="true"></i> {{ trans('lang.book_now_video')}} </a>
                                                            </div>
                                                            <a v-if="savedDoctor != null && savedDoctor.includes(doc.id)" :class="'doctor-'+doc.id" class="dc-like dc-clicksave" @click="wishlist(doc.id, savedDoctor, 'saved_doctors')" href="javascript:void(0);">
                                                                <i class="fa fa-heart"></i>
                                                            </a>
                                                            <a v-else class="dc-like" :class="'doctor-'+doc.id" @click="wishlist(doc.id, savedDoctor, 'saved_doctors')" href="javascript:void(0);">
                                                                <i class="fa fa-heart"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 float-left">
                                                        <div class="dc-doclocation dc-doclocationvtwo">
                                                            <span v-if="doc.location !== null">
                                                                <i class="ti-direction-alt"></i>{{doc.location.title}}
                                                            </span>
                                                            <span v-if="doc.profile.available_days == null">
                                                                <i class="ti-calendar"></i>
                                                                <em class="dc-dayon">Not Available Today</em>
                                                            </span>

                                                            <span v-else>
                                                            <i class="ti-calendar"></i>
                                                            <em v-html="availableDaysNames(doc.profile.available_days)"></em>
                                                        </span>
                                                            <span v-if="!isNaN(doc.profile.votes) && doc.feedbacks.length > 0">
                                                                <i class="ti-thumb-up"></i>
                                                                {{((doc.profile.votes / 100) * doc.feedbacks.length).toFixed(0)}}%
                                                                Satisfied Patient
                                                            </span>
                                                            <span>
                                                                <i class="ti-comments" aria-hidden="true"></i>
                                                                <a v-if="doc.feedbacks.length > 0" :href="'/profile/'+doc.slug+'#feedback'">{{doc.feedbacks.length}} Patient success stories</a>
                                                                <a v-else :href="'/profile/'+doc.slug+'#feedback'"> No success story </a>
                                                            </span>
                                                            <span>
                                                                <i class="ti-clipboard"></i>
                                                                <i v-html="checkAvailability(getDayName(),JSON.parse(doc.profile.available_days), doc.profile)"></i>

                                                            </span>
                                                            
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

                                    <div class="dc-services-holder dc-aboutinfo" style="margin: 20px 0 0 0">
                                        <div class="dc-infotitle">
                                            <h3>Brief description about <b>{{diseaseTitle}}</b></h3>
                                        </div>
                                    </div>
                                    <div class="dc-contentdoctab dc-userdetails-holder tab-pane">
                                        <div class="dc-aboutdoc dc-aboutinfo">

                                            <div class="dc-description"><span v-html="diseaseDescription"></span></div>
                                        </div>
                                    </div>


                                    <div class="dc-services-holder dc-aboutinfo" style="margin: 20px 0 0 0">
                                        <div class="dc-infotitle faq_title">
                                            <h3>Frequently Asked Questions</h3>
                                        </div>
                                    </div>
                                    <div id="accordion">
                                        <div class="card" v-if="doctors[index].profile.faqs != null" v-for="(doc, index) in doctors">
                                            <div class="card-header" :id="'heading-'+index">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" role="button" data-toggle="collapse" :href="'#collapse-'+index" aria-expanded="false" :aria-controls="'collapse-'+index">
                                                        <span style="font-family: 'Open Sans',Arial,Helvetica,sans-serif;" v-if="JSON.parse(doctors[index].profile.faqs)[0]['question']" v-html="JSON.parse(doctors[index].profile.faqs)[0]['question']"></span>
                                                    </a>
                                                </h5>
                                            </div>
                                            <div :id="'collapse-'+index" class="collapse" data-parent="#accordion" :aria-labelledby="'heading-'+index">
                                                <div class="card-body">
                                                    <span style="font-family: 'Open Sans',Arial,Helvetica,sans-serif;" v-if="JSON.parse(doctors[index].profile.faqs)[0]['answer']" v-html="JSON.parse(doctors[index].profile.faqs)[0]['answer']"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="row">
                                    <div class="dc-services-holder dc-aboutinfo" style="margin: 20px 0 20px 0">
                                        <div class="dc-infotitle">
                                            <h3>Hospitals and Doctors Near You</h3>
                                        </div>
                                    </div>
                                    <google-map
                                            v-if="lati"
                                            :center="{lat:lati.coords.latitude, lng:lati.coords.longitude}"
                                            :zoom="10"
                                            style="width: 100%; height: 500px"
                                    >
                                        <gmap-info-window
                                                :options="{maxWidth: 900}"
                                                :position="infoWindow.position"
                                                :opened="infoWindow.open"
                                                @closeclick="infoWindow.open=false">
                                            <div v-html="infoWindow.template"></div>
                                        </gmap-info-window>

                                        <google-maps-circle ref="circle"
                                                            :radius="10000"
                                                            :center="{lat:lati.coords.latitude, lng:lati.coords.longitude}"
                                                            :editable='true'
                                        >
                                        </google-maps-circle>

                                        <GmapMarker ref="myMarker"
                                                    :position="{lat:lati.coords.latitude, lng:lati.coords.longitude}"
                                                    :title="'Your Current Postion'"
                                        />
                                        <GmapMarker v-for="(doc, index) in this.hospitals"
                                                    v-bind:data="doc"
                                                    v-bind:key="doc.text"
                                                    ref="myMarker"
                                                    title="doc.first_name + ' '+ doc.last_name"
                                                    :position="{lat:Number(doc.profile.latitude), lng:Number(doc.profile.longitude)}"
                                                    @click="openInfoWindowTemplate(doc)"
                                                    :icon="{url: require('../../../../public/uploads/markers/hospital.png')}"
                                        />
                                        <GmapMarker v-for="(doc, index) in this.doctors"
                                                    v-bind:data="doc"
                                                    v-bind:key="doc.text"
                                                    ref="myMarker"
                                                    :title="doc.first_name + ' '+ doc.last_name"
                                                    :position="{lat:Number(doc.profile.latitude), lng:Number(doc.profile.longitude)}"
                                                    @click="openInfoWindowTemplate(doc)"
                                                    :icon="{url: require('../../../../public/uploads/markers/doctor.png')}"
                                        />
                                    </google-map>
                                </div>-->
                                <div class="row">
                                    <div class="dc-services-holder dc-aboutinfo mt-4">
                                        <div class="dc-infotitle">
                                            <h3> <strong>{{diseaseTitle}}</strong> in hospitals near you</h3>
                                        </div>

                                        <div v-if="allHospitals.length > 0" class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo la-searchvlistvtwo">
                                            <div class="dc-tags">
                                                <ul>
                                                    <li v-if="hospital.location !== null" v-for="hospital in allHospitals"><a v-for="spec in hospital.specialities" v-if="spec.title === diseaseTitle"> {{diseaseTitle}} in {{hospital.first_name}} {{hospital.last_name}}, {{hospital.location.title}} </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div  v-else>
                                            <img v-bind:src="'/images/empty-images/no-record.png'">
                                            <span>No record</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="dc-services-holder dc-aboutinfo mt-4">
                                        <div class="dc-infotitle">
                                            <h3> <strong>{{diseaseTitle}}</strong> Related Condition</h3>
                                        </div>
                                        <div v-if="symptoms.length > 0" class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo la-searchvlistvtwo">
                                            <div class="dc-tags">
                                                <ul>
                                                    <div v-for="services in symptoms">
                                                        <li v-for="symptom in services.symptom"><a href="#"> {{symptom.title}} </a></li>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                        <div  v-if="symptoms.length < 1">
                                            <img v-bind:src="'/images/empty-images/no-record.png'">
                                            <span>No record</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="dc-services-holder dc-aboutinfo mt-4">
                                        <div class="dc-infotitle">
                                            <h3> <strong>{{diseaseTitle}}</strong> Related Treatment</h3>
                                        </div>
                                        <div v-if="symptoms.length > 0" class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo la-searchvlistvtwo">
                                            <div class="dc-tags">
                                                <ul>
                                                    <div >
                                                        <li v-for="service in symptoms"><a href="#"> {{service.title}} </a></li>
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
                                <div class="row">
                                    <div class="dc-services-holder dc-aboutinfo mt-4">
                                        <div class="dc-infotitle">
                                            <h3> <strong>{{diseaseTitle}}</strong> near you </h3>
                                        </div>
                                        <div v-if="specLocations.length > 0" class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo la-searchvlistvtwo">
                                            <div class="dc-tags">
                                                <ul>
                                                    <div >
                                                        <li v-for="location in specLocations"><a href="#"> {{diseaseTitle}} {{location.title}} </a></li>
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
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
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
                                                :zoom="10"
                                                style="width: 100%; height: 500px"
                                        >
                                            <gmap-info-window
                                                    :options="{maxWidth: 900}"
                                                    :position="infoWindow.position"
                                                    :opened="infoWindow.open"
                                                    @closeclick="infoWindow.open=false">
                                                <div v-html="infoWindow.template"></div>
                                            </gmap-info-window>
                                            <google-maps-circle ref="circle"
                                                                :radius="10000"
                                                                :center="{lat:lati.coords.latitude, lng:lati.coords.longitude}"
                                                                :editable='true'
                                            >
                                            </google-maps-circle>

                                            <GmapMarker ref="myMarker"
                                                        :position="{lat:lati.coords.latitude, lng:lati.coords.longitude}"
                                                        :title="'Your Current Postion'"
                                            />
                                            <GmapMarker v-for="(doc, index) in this.allHospitals"
                                                        v-bind:data="doc"
                                                        v-bind:key="doc.text"
                                                        ref="myMarker"
                                                        title="doc.first_name + ' '+ doc.last_name"
                                                        :position="{lat:Number(doc.profile.latitude), lng:Number(doc.profile.longitude)}"
                                                        @click="openInfoWindowTemplate(doc)"
                                                        :icon="{url: require('../../../../public/uploads/markers/hospital.png')}"
                                            />
                                            <GmapMarker v-for="(doc, index) in this.usersData"
                                                        v-bind:data="doc"
                                                        v-bind:key="doc.text"
                                                        ref="myMarker"
                                                        :title="doc.first_name + ' '+ doc.last_name"
                                                        :position="{lat:Number(doc.profile.latitude), lng:Number(doc.profile.longitude)}"
                                                        @click="openInfoWindowTemplate(doc)"
                                                        :icon="{url: require('../../../../public/uploads/markers/doctor.png')}"
                                            />
                                        </google-map>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" v-else>
                            <img v-bind:src="'/images/empty-images/no-record.png'">
                            <span>No record</span>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <b-modal @hidden="onClose" ref="registeration_modal" size="lg" class="dc-feedbackpopup booknow_modal" hide-footer :title="trans('lang.reg_book_appointment')" no-close-on-backdrop>
            <section id="sec1" class="sec1">
                <div class="dc-visitingdoctor form-row dc-popup-row" v-cloak>
                    <form id="quick_registeration" v-on:submit.prevent="quickLogin">
                        <div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="first_name" placeholder="Full Name">
                        </div>
                        <div class="form-group col-md-6 col-lg-6 col-sm-12 col-xs-12 logout_fields">
                            <div class="country-code">+92</div>
                            <input type="text" class="form-control"  name="phone_number" placeholder="3XX XXXX XXX" data-format="3dd - dddd ddd">
                            <small class="text-danger" id="error-phone"></small>
                        </div>
                        <div class="form-group modal-footer dc-modal-footer">
                            <input class="btn dc-btn btn-primary" type="submit">
                        </div>
                    </form>
                </div>
            </section>
        </b-modal>
        <b-modal @hidden="onClose" ref="appointment_modal" size="lg" class="dc-feedbackpopup" hide-footer :title="trans('lang.book_appointment')" no-close-on-backdrop>
            <div class="dc-appointmentpopup">
                <div class="dc-modalcontent modal-content custom_modal_outer" >
                    <section class="sec1">
                        <form id="submit_appointment_form" v-on:submit.prevent="checkAppointmentStep1" v-if="steps === 1">
                            <div class="dc-visitingdoctor" v-cloak>
                                <book-appointment
                                        :hospitals="doctor_hospitals"
                                        :user_id="doctor_id"
                                        :currency="'PKR'"
                                        :type="a_type"
                                >
                                </book-appointment>
                                <div class="modal-footer dc-modal-footer">
                                    <input class="btn dc-btn btn-primary" type="submit">
                                </div>
                            </div>
                        </form>
                        <div class="dc-visitingdoctor dc-popup-doc dc-popup-step3" v-cloak v-if="steps === 2">
                            <h5>{{ trans('lang.enter_auth_code') }}</h5>
                            <p>{{ trans('lang.verify_code_sent') }}<a href="javascript:void(0)"></a></p>
                            <input type="text" placeholder="Authentication Code Here" v-model="appointment.code" class="code_input">
                            <div class="modal-footer dc-modal-footer custom_modal_footer">
                                <a href="javascript:void(0);" v-on:click="checkAppointmentStep3" class="btn dc-btn btn-primary">{{ trans('lang.continue') }}</a>
                            </div>
                        </div>
                        <div class="dc-visitingdoctor dc-popup-doc dc-popup-step4" v-if="steps === 3" v-cloak>
                            <div class="dc-modal-body4-title custom_modal_head">
                                <h6>{{ trans('lang.congrats') }}</h6>
                            </div>
                            <div class="dc-modal-body4-description">
                                <p>Thank you for the appointment with Avas Nguyen Soon we will get back to you.</p>
                            </div>
                            <div class="modal-footer dc-modal-footer custom_footer_btn">
                                <a href="javascript:void(0);" v-on:click="finalStep(false)" class="btn dc-btn btn-primary">View Appointment Status</a>
                                <a href="javascript:void(0);" v-on:click="finalStep(true)" class="btn dc-btn btn-primary">Checkout</a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
  // gmapCluster *must* be manually imported
  import Vue from 'vue'

  Vue.component('gmap-cluster', VueGoogleMaps.Cluster);
  Vue.component('google-map', VueGoogleMaps.Map);
  Vue.component('google-maps-circle', VueGoogleMaps.Circle)
  Vue.component('gmap-info-window', VueGoogleMaps.InfoWindow)
  Vue.component('GmapMarker', GmapMarker)
  import GmapMarker from 'vue2-google-maps/src/components/marker'
  import * as VueGoogleMaps from 'vue2-google-maps'
  import VueSlickCarousel from 'vue-slick-carousel'
  import 'vue-slick-carousel/dist/vue-slick-carousel.css'
  import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
  import $ from "../../../../public/js/vendor/jquery-library.js";
  import DatePick from 'vue-date-pick';

  export default {
    components: { VueSlickCarousel, DatePick },
    props: ['diseaseTitle', 'locations', 'disease', 'diseaseSlug', 'diseaseFlag', 'diseaseDescription', 'userData', 'hospitalsData', 'specialitiesData'],
    data() {
      return {
        infoWindow: {
          position: {lat: 0, lng: 0},
          open: false,
          template: ''
        },
        settings: {
          "arrows": true,
          "dots": false,
          "centerMode":true,
          "focusOnSelect": true,
          "infinite": true,
          "speed": 1000,
          "slidesToShow": 3,
          "slidesToScroll": 1,
          "touchThreshold": 1,
          "autoplay": false,
          "autoplaySpeed": 1000,
        },
        infoOptions: {
          content: '',
          //optional: offset infowindow so it visually sits nicely on top of our marker
          pixelOffset: {
            width: 0,
            height: -35
          }
        },
        infoWinOpen: false,
        infoWindowPos: null,
        currentMidx: null,
        diseases: [],
        symptoms:[],
        usersData: this.userData,
        allHospitals: this.hospitalsData,
        doctors: [],
        hospitals: [],
        available_days: '',
        savedHospital:'',
        savedDoctor: [],
        appointment: [],
        patientData: [],
        specLocations: [],
        search:'',
        fees:0,
        filters:false,
        steps:0,
        availableData: '',
        doctorsToShow: 15,
        totalDoctors: 0,
        map: null,
        loading: false,
        mapConfig: Object,
        apiKey: String,
        place: '',
        lati: null,
        longi: null,
        hasSaved:true,
        date: '',
        checkbydate: '',
        disabledDatesFrom: {
          to: new Date(),
          from: null
        },
      };
    },
    mounted() {
      /*this.getAllDiseases()*/
      this.getAllDoctors()
      this.getCurrentUsersSaved()
      this.symptomSpec()
      this.hospitalsSpec()
      this.specLocationFilter()

      this.totalDoctors = this.doctors.length
      let today = moment();
      this.date = today.format('YYYY-MM-DD')


    },
    created(){
      this.showPosition()
    },
    computed: {
      computedDate: function() {
        return this.date;
      },
      filteredListOfHospitals() {
        return this.allHospitals.filter(hospital => {
          return (hospital.first_name+' '+hospital.last_name).toLowerCase().includes(this.search.toLowerCase())
        })
      }
    },
    methods: {
      showError(error) {
        return this.$toast.error(' ', error, this.notificationSystem.options.error)
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
      showNext() {
        this.$refs.carousel.next()
      },
      showPrev() {
        this.$refs.carousel.previous()
      },
      prev: function () {
        this.steps--
      },
      next: function () {
        this.steps++
      },
      /*get all doctor and hospitals*/
      getAllDoctors: function () {
        var self = this;
        if (self.usersData.length > 0 ) {
          self.usersData.forEach(function (sandwich, index) {
            if (sandwich.specialities.length > 0) {
              if (sandwich.specialities[0].slug !== self.diseaseSlug) {
                self.usersData.splice(index, 1);
              }
            }
            else {
              self.doctors.splice(index, 1);
            }
          });
        }
        /*axios.get(APP_URL + '/getAllDoctors')
          .then(function (response) {
            self.doctors = response.data.doctors;
              if (self.doctors.length > 0 ) {
                  self.doctors.forEach(function (sandwich, index) {
                      if (sandwich.specialities.length > 0) {
                          if (sandwich.specialities[0].slug !== self.diseaseSlug) {
                            self.doctors.splice(index, 1);
                            self.usersData.push(sandwich)
                            console.log(self.usersData)
                          }
                      }
                      else {
                          self.doctors.splice(index, 1);
                      }
                  });
              }
            self.hospitals = response.data.hospitals;
          })*/
      },
      getAllDiseases: function () {
        var self = this;
        axios.get(APP_URL + '/getAllDiseases')
          .then(function (response) {
            self.diseases = response.data.diseases;
          })
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
      videoConsul (doc) {
        let result = false
        doc.doc_teams.forEach(function (team) {
          if (team.user_id === 'online') {
            result = true
          }
        })
        return result;
      },
      checkAvailability: function (dayName, availableDays) {
        let availability = '';
        let day1 = ((moment().format('ddd')).toLowerCase().trim());
        let day2 = ((moment().add(1, 'day').format('ddd')).toLowerCase().trim());
        let day3 = ((moment().add(2, 'day').format('ddd')).toLowerCase().trim());
        let day4 = ((moment().add(3, 'day').format('ddd')).toLowerCase().trim());
        let day5 = ((moment().add(4, 'day').format('ddd')).toLowerCase().trim());
        let day6 = ((moment().add(5, 'day').format('ddd')).toLowerCase().trim());
        let day7 = ((moment().add(6, 'day').format('ddd')).toLowerCase().trim());
        console.log(dayName)

        if (availableDays !== null){
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
        }
        else {
          return availability = '<em class="dc-dayon">Not Available</em>'
        }
        return availability;
      },
      showAllServices: function (class_list) {
        $('.hide_items'+class_list).css({ display: "block" });
        $('#view-service-'+class_list).hide();
      },
      getCurrentUsersSaved: function () {
        var self = this;
        axios.get(APP_URL + '/getCurrentUsersSaved')
          .then(function (response) {
            if (response.data != null) {
              if (response.data.saved_doctors.length > 0) {
                self.savedDoctor = JSON.parse(response.data.saved_doctors);
              }
            if (response.data.saved_hospital != null) {
              self.savedHospital = response.data.saved_hospital;
            }
            }
          })
      },
      diseaseCheck: function (userData, diseaseSlug) {
        let permission = false;
        if(userData.diseases.length != 0){
          let diseases = userData.specialities;
          diseases.forEach(function (sandwich, index){
            if(sandwich.slug == diseaseSlug){
              permission = true;
            }
          });
        }
        return permission;
      },
      showPosition: function() {
        navigator.geolocation.getCurrentPosition(pos => {
          this.lati = pos;

        }, err => {
        })
      },
      wishlist: function (id, savedDoc, column) {
        var self = this;
        var form_errors = [];
        if (self.savedDoctor == null) {
          axios.post(APP_URL + '/user/add-wishlist', {
            id: id,
            column: column,
          }).then(function (response) {
            if (response.data.authentication == true) {
              if (response.data.type == 'success') {
                if (column == 'saved_doctors') {
                  $('.doctor-' + id).addClass('dc-clicksave');
                  self.savedDoctor.push(id);
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
                  this.showError(element)
                });
              }
            } else {
              form_errors.push(Vue.prototype.trans(response.data.message));
              form_errors.forEach(element => {
                this.showError(element)
              });
            }
          }).catch(function (error) {
            form_errors.push(Vue.prototype.trans(error));
            form_errors.forEach(element => {
              this.showError(element)
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
                  this.showError(element)
                });
              }
            } else {
              form_errors.push(Vue.prototype.trans(response.data.message));
              form_errors.forEach(element => {
                this.showError(element)
              });
            }
          }).catch(function (error) {
            form_errors.push(Vue.prototype.trans(error));
            form_errors.forEach(element => {
              this.showError(element)
            });
          });
        }
      },
      checkSaved: function (doc_id, availableData) {
        if (availableData.length > 0) {
          if (availableData.includes(doc_id) == true) {
            return true;
          } else {
            return false;
          }
        }
      },
      openInfoWindowTemplate (item) {
        this.setInfoWindowTemplate(item)
        this.infoWindow.position = {lat:Number(item.profile.latitude), lng:Number(item.profile.longitude)};
        this.infoWindow.open = true
      },
      setInfoWindowTemplate: function (marker) {
        this.infoWindow.template = `
          <div>
          <img src="${'/uploads/users/'+marker.profile.user_id+'/small-' + marker.profile.avatar}" alt="">
            <h6>${marker.first_name+' '+marker.last_name}</h6> ${marker.profile.tagline}<br>
            ${marker.profile.address}<br>
            ${marker.assistant_phone_number}<br>
           </div>`;
        return this.infoWindow.template;
      },
      showModal: function (doc_id, type) {
        var self = this;
        self.a_type = type;
        this.steps = 0
        var form_errors = [];

        self.loading = true;
        var hospitaldata = [];
        self.doctor_hospitals = [];
        var index = this.usersData.findIndex(x => x.id === doc_id);
        self.hospitals_data = self.usersData[index].doc_teams;

        if (type === 'visit') {
          self.hospitals_data.forEach(function (hospital) {
            if (hospital.user_id !== 'online') {
              hospitaldata = []
              hospitaldata = self.allHospitals.find(x => x.id === JSON.parse(hospital.user_id))
              if (hospitaldata !== undefined) {
                // console.log(hospital)
                self.doctor_hospitals.push({
                  'id': hospitaldata.id,
                  'name': hospitaldata.first_name + ' ' + hospitaldata.last_name
                })
              }
            }
          })
        }
        if (type === 'online') {
          hospitaldata = []
          self.doctor_hospitals.push({
            'id': 'online',
            'name': 'Online Booking Consultation'
          })
        }

        if (self.doctor_hospitals.length < 1) {
          self.loading = false;
          form_errors.push(Vue.prototype.trans('lang.hospital_not_find'));
          form_errors.forEach(element => {
            this.showError(element)
          });
          return
        }

        self.doctor_hospitals = JSON.stringify(self.doctor_hospitals)

        self.doctor_id = doc_id;
        axios.get(APP_URL + '/check-login').
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
        })
      },
      quickLogin: function () {
        var self = this;
        let formdata = document.getElementById('quick_registeration');
        var formData1 = new FormData(formdata);
        if (!formData1.get('phone_number').length > 0) {
          document.getElementById('error-phone').innerHTML = " Please Enter Your Phone *";
          return;
        }
        else if (formData1.get('phone_number').length > 11) {
          if (!(/^(\+923)([0-9]{2}[0-9]{7})$/.test(formData1.get('phone_number')))) {
            document.getElementById('error-phone').innerHTML = "Use Correct Format +92 3XX XXXX XXX";
            return;
          }
        }
        else if (!(/^(03)([0-9]{2}[0-9]{7})$/.test(formData1.get('phone_number')))) {
          document.getElementById('error-phone').innerHTML = "Use Correct Format +92 3XX XXXX XXX"
          return
        }
        else {
          axios.post(APP_URL + '/quick-registration', formData1)
            .then(function (response) {
              if (response.data.type === 'success') {
                self.patientData = response.data.user_data
                sessionStorage.setItem('user_id',response.data.user_data.id)
                sessionStorage.setItem('first_name',response.data.user_data.first_name)
                sessionStorage.setItem('last_name',response.data.user_data.last_name)
                sessionStorage.setItem('user_pass',response.data.user_data.password)
                self.usersData = response.data.user_data
                self.next();
                self.$refs['registeration_modal'].hide()
                self.$refs['appointment_modal'].show()
              }
            })
            .catch(function (error) {

            });
        }
      },
      checkAppointmentStep1: function () {
        var patient = jQuery("input[name='patient']:checked").val();
        if (patient == 'someone') {
          var patient_name = document.getElementById('patient_name').value;
          var form_errors = [];
          if (!patient_name) form_errors.push(Vue.prototype.trans('lang.patient_name_req'));
          if (!document.getElementById('relation').value) form_errors.push(Vue.prototype.trans('lang.select_relation_req'));
          form_errors.forEach(element => {
            this.showError(element)
          });
          if (form_errors.length > 0) {
            return false;
          }
          form_errors = [];
        }
        if (document.getElementById('appointment_hospital').selectedIndex > 0 || document.getElementsByName("hospital_type").value === 'online') {
          var timeSlot = document.getElementsByName('appointment[time]');
          var isTimeSlot = false;
          for (var i = 0; i < timeSlot.length; i++) {
            if (timeSlot[i].checked) {
              isTimeSlot = true;
              break;
            }
          }
          if (isTimeSlot == true) {
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
            var self = this;
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
                self.next();
              })
          } else {
            this.showError(Vue.prototype.trans('lang.select_appointment_time'))
            return false;
          }
        } else {
          if (document.getElementById('appointment_hospital').selectedIndex <= 0) {
            document.getElementById('hospital_dropdown').innerHTML = 'Hospital is required';
            /*this.showError(Vue.prototype.trans('lang.hospital_req'))*/
            return false;
          }
        }
      },
      checkAppointmentStep3: function () {
        var user_id = sessionStorage.getItem('user_id')
        var self = this;
        axios.post(APP_URL + '/verify-appointment-code', {
          code: self.appointment.code,
        })
          .then(function (response) {
            if (response.data.type == 'success') {
              self.submitAppointment(user_id);
            } else if (response.data.type == 'error') {
              self.showError(response.data.message);
            }
          })
      },
      submitAppointment: function (id) {
        var self = this;
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
            if (response.data.type == 'success') {
              self.loading = false;
              self.appointment_last_id = ''
              self.appointment_last_id = response.data.appointment_id;
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
        } else {
          window.location.replace(APP_URL + '/patient/appointments/' + this.appointment_last_id)
        }

      },
      onClose: function() {
        var self = this
        self.step = 1;
        this.sortedItems()
      },

      availableDaysNames: function (dayNames, id) {
        var days = []
        if (dayNames !== null && dayNames !== []) {
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

        /*
        if (dayNames !==""){
          JSON.parse(dayNames).forEach(function (day, index) {
            day = day.charAt(0).toUpperCase() + day.slice(1)
            days[index] = day
          })
        }
        if (days.length > 0) {
          return JSON.stringify(days).replace(/[\\[\]"]+/g, " ")
        }
        else {
          return 'Not available'
        }*/
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
        this.loading = true
        var currentday = moment(this.date).format('ddd')
        var self = this

        this.usersData = this.userData
        let sort_by = $('#sort_by').val()
        let sort_by_hospital = false;
        /*let e = document.getElementById('sort_by_hospital')
        let sort_by_hospital = e.options[e.selectedIndex].value;*/
        let male = document.querySelector('#male').checked;
        let female = document.querySelector('#female').checked;
        let availableToday = document.querySelector('#available_today').checked;
        let videoConsultation = document.querySelector('#video_check').checked;
        let available_next_7_days = document.querySelector('#available_next_7_days').checked;
        let child = document.querySelector('#child').checked;
        let available_next_3_days = document.querySelector('#available_next_3_days').checked;
        let available_tomorrow = document.querySelector('#available_tomorrow').checked;

        if(this.search === '') {
          this.usersData = this.userData
        }

        if ($('input[name=fee]:checked').length > 0) {
          let selected_id = $('input[name=fee]:checked').attr('id')
          let first_price = $('input[name=fee]:checked').val()
          let second_price = parseInt($('input[name=fee]:checked').val()) + 499
          if (selected_id === 'free'){
            this.usersData = this.usersData.filter(function (a) {
              if (a.profile.starting_price < 1) {
                return true
              }
            })
          }
          else if (selected_id === 'maximum_price'){
            this.usersData = this.usersData.filter(function (a) {
              if (a.profile.starting_price >= first_price) {
                return true
              }
            })
          }
          else {
            this.usersData = this.usersData.filter(function (a) {
              if (a.profile.starting_price >= first_price && a.profile.starting_price <= second_price) {
                return true
              }
            })
          }
        }
        if (child) {
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
        }
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
          selected_hospital_id = this.allHospitals.filter(function (a) {
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
          console.log(hospital[0].id)
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
        self.loading = false
        self.checkbydate = false;
        this.filters = true
        return self.usersData;
      },
      symptomSpec () {
        let self = this
        this.symptoms = this.specialitiesData.filter(function (speciality) {
          if (speciality.speciality !== null){
            return speciality.speciality.slug === self.diseaseSlug
          }
        })
      },
      hospitalsSpec () {
        self.hospitals = this.hospitalsData.filter(function (user) {
          if (user.roles !== null){
            if (user.roles.name === 'hospital') {
              self.hospitals.push(user)
            }
          }
        })
      },
      specLocationFilter () {
        this.specLocations = this.disease.locations.filter(function (loc) {
          return loc.parent === 1
        })
      },
    },
  }
</script>

<style>
    .slick-prev {
        left: 10px;
        z-index: 2;
    }
    .slick-next {
        right: 10px;
        z-index: 2;
    }
    .slick-slide{
        padding: 20px;
    }
    .slick-track{
        top: 20px !important;
    }
    /*.la-searchvlistvtwo .dc-docpostholder .dc-docpostcontent .dc-searchvtwo {
        float: none;
        max-width: none;
        min-width: 535px;
    }*/
    .mb-0 > a {
        display: block;
        position: relative;
    }
    .mb-0 > a:after {
        content: "\f078"; /* fa-chevron-down */
        font-family: 'FontAwesome';
        position: absolute;
        right: 0;
    }
    .mb-0 > a[aria-expanded="true"]:after {
        content: "\f077"; /* fa-chevron-up */
    }
    .close_btn img{
        pointer-events: none;
        display: block;
        width: 14px;
        height: 14px;
        margin: 8px;
    }
    .gm-style-iw-t{
        bottom:60px !important;
    }
    .dc-docpostcontent{
        min-height: 125px;
    }
    
    .logout_fields input{
        width:80%;
    }
    .pagination_btn button{
        min-width: 95px;
        line-height: 30px;
        margin-bottom: 10px;
        display: block;
        max-width: 120px;
    }

</style>