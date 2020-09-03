<template>
    <div class="container">
        <div class="dc-main-section">
            <div class="container" id="user-profile">
                <div class="row" v-if="this.doctors.length > 0">
                    <div id="dc-twocolumns" class="dc-twocolumns dc-haslayout">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 float-left">
                            <div class="dc-searchresult-holder">
                                <div class="dc-searchresult-head">
                                    <div class="dc-title"><h4>All Doctors</h4></div>
                                </div>
                                <div class="dc-searchresult-grid dc-searchresult-list dc-searchvlistvtwo la-searchvlistvtwo">
                                    <div class="dc-docpostholder" v-for="(doc, index) in this.doctors" v-if="index < doctorsToShow">
                                        <div class="dc-docpostcontent">
                                            <div class="dc-searchvtwo">
                                                <figure class="dc-docpostimg">
                                                    <img v-bind:src="'/uploads/users/'+doc.profile.user_id+'/small-' + doc.profile.avatar" alt="">
                                                    <figcaption>
                                                        <span class="dc-featuredtag"><i class="fa fa-bolt"></i></span>
                                                    </figcaption>
                                                </figure>
                                                <div class="dc-title">
                                                    <a v-bind:href="'/speciality/'+doc.specialities[0].slug" class="dc-docstatus" v-if="doc.specialities.length > 0">{{doc.specialities[0].title}}</a>
                                                    <h3><a :href="'/profile/'+doc.slug">{{doc.first_name+" "+doc.last_name}}</a></h3>
                                                    <ul class="dc-docinfo">
                                                        <li><em>{{doc.profile.sub_heading}}</em></li>
                                                        <li>
                                                            <span class="dc-stars">
                                                                <span v-bind:style="{ width: doc.feedbacks.length+'%'}"></span>
                                                            </span>
                                                            <em>{{doc.feedbacks.length}}</em>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="dc-tags">
                                                    <ul>
                                                        <div v-for="(service, index) in doc.services">
                                                            <li v-if="index <= 3">
                                                                <a href="javascript:void(0);">{{service.title}}</a>
                                                            </li>
                                                            <li style="display:none" v-else :class="'hide_items'+doc.id">
                                                                <a href="javascript:void(0);">{{service.title}}</a>
                                                            </li>
                                                        </div>
                                                        <li class="dc-viewall-services" v-if="doc.services.length > 1">
                                                            <a href="javascript:;" :id="'view-service-'+doc.id" class="dc-tagviewall" v-on:click="showAllServices(doc.id)">View All</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dc-doclocation dc-doclocationvtwo">
                                                <span v-if="doc.location !== null"><i class="ti-direction-alt"></i>{{doc.location.title}}</span>
                                                <span>
                                                    <i class="ti-calendar"></i>
                                                    <em class="dc-dayon">{{JSON.stringify(doc.profile.available_days).replace(/[\\[\]"]+/g," ")}}</em>
                                                </span>
                                                <span v-if="doc.profile.votes == null">
                                                    <i class="ti-thumb-up"></i>0 % Satisfied Patient
                                                </span>

                                                <span v-else>
                                                    <i class="ti-thumb-up"></i>
                                                         {{((doc.profile.votes / doc.feedbacks.length) * 100).toFixed(0)}}%
                                                                                Satisfied Patient
                                                </span>
                                                <span><i class="ti-wallet"></i>{{ trans('lang.starting_from') }} Rs {{doc.profile.starting_price}}</span>
                                                <span>
                                                    <i class="ti-clipboard"></i>
                                                    <em class="dc-available">
                                                        {{checkAvailability(getDayName(),JSON.stringify(doc.profile.available_days).replace(/[\\[\]"]+/g," "))}}
                                                    </em>
                                                </span>
                                                <div class="dc-btnarea">
                                                    <a :href="'/profile/'+doc.slug" class="dc-btn">View More</a>
                                                    <a v-if="savedDoctor != null && savedDoctor.includes(doc.id)" :class="'doctor-'+doc.id" class="dc-like dc-clicksave" @click="wishlist(doc.id, savedDoctor, 'saved_doctors')" href="javascript:void(0);">
                                                        <i class="fa fa-heart"></i>
                                                    </a>
                                                    <a v-else class="dc-like" :class="'doctor-'+doc.id" @click="wishlist(doc.id, savedDoctor, 'saved_doctors')" href="javascript:void(0);">
                                                        <i class="fa fa-heart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="dc-pagination" v-if="doctorsToShow < doctors.length || doctors.length > doctorsToShow">
                                        <button class="dc-btn" @click="doctorsToShow += 3">Show More</button>
                                    </div>-->
                                </div>
                            </div>

                            <!--<div class="dc-services-holder dc-aboutinfo" style="margin: 20px 0 0 0">
                                <div class="dc-infotitle">
                                    <h3>Brief description about <b>{{diseaseTitle}}</b></h3>
                                </div>
                            </div>
                            <div class="dc-contentdoctab dc-userdetails-holder tab-pane">
                                <div class="dc-aboutdoc dc-aboutinfo">

                                    <div class="dc-description"><span v-html="diseaseDescription"></span></div>
                                </div>
                            </div>-->


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
                            <div class="dc-services-holder dc-aboutinfo" style="margin: 20px 0 20px 0">
                                <div class="dc-infotitle">
                                    <h3>Hospitals and Doctors Near You</h3>
                                </div>
                            </div>
                            <div style="margin: 70px 0 20px 0;">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  // gmapCluster *must* be manually imported
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

  export default {
    components: { VueSlickCarousel },
    props: ['doctors','location','specialty',],
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
        hospitals: [],
        available_days: '',
        savedHospital:'',
        savedDoctor: [],
        availableData: '',
        doctorsToShow: 3,
        totalDoctors: 0,
        map: null,
        mapConfig: Object,
        apiKey: String,
        place: '',
        lati: null,
        longi: null,
        hasSaved:true,
      };
    },
    mounted() {
      console.log(this.doctors.length)
      this.totalDoctors = this.doctors.length
    },
    created(){
      this.showPosition()
    },
    methods: {
      showNext() {
        this.$refs.carousel.next()
      },
      showPrev() {
        this.$refs.carousel.previous()
      },
      /*get all doctor and hospitals*/
      getAllDoctors: function () {
        var self = this;
        axios.get(APP_URL + '/getAllDoctors')
          .then(function (response) {
            self.doctors = response.data.doctors;
            if (self.doctors.length > 0 ) {
              self.doctors.forEach(function (sandwich, index) {
                if (sandwich.specialities.length > 0) {
                  if (sandwich.specialities[0].slug !== self.diseaseSlug) {
                    self.doctors.splice(index, 1);
                  }
                }
                else {
                  self.doctors.splice(index, 1);
                }
              });
            }
            self.hospitals = response.data.hospitals;
          })
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
      checkAvailability: function (dayName, availableDays) {

        if(availableDays.includes(dayName) == true){
          return 'Available today'
        }else {
          return 'Not available today'
        }
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
        // console.log(id, savedDoc, column)
        if (self.savedDoctor == null) {
          axios.post(APP_URL + '/user/add-wishlist', {
            id: id,
            column: column,
          }).then(function (response) {
            // console.log(response.data.authentication, ' === ', response.data.type)
            if (response.data.authentication == true) {
              if (response.data.type == 'success') {
                if (column == 'saved_doctors') {
                  $('.doctor-' + id).addClass('dc-clicksave');
                  self.savedDoctor.push(id);
                  // console.log(self.savedDoctor);
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
                console.log(response.data.message);
              }
            } else {
              console.log(response.data.message);
            }
          }).catch(function (error) {
            console.log(error);
          });
        }
        else if (self.savedDoctor.includes(id) == true) {
          axios.post(APP_URL + '/user/remove-wishlist', {
            id: id,
            column: column,
          }).then(function (response) {
            // console.log(response.data.authentication, ' === ', response.data.type)
            if (response.data.authentication == true) {
              if (response.data.type == 'success') {
                if (column == 'saved_doctors') {
                  $('.doctor-' + id).removeClass('dc-clicksave');
                  self.savedDoctor.pop(id);
                  // console.log(self.savedDoctor);
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
            // console.log(response.data.authentication, ' === ', response.data.type)
            if (response.data.authentication == true) {
              if (response.data.type == 'success') {
                if (column == 'saved_doctors') {
                  $('.doctor-' + id).addClass('dc-clicksave');
                  self.savedDoctor.push(id);
                  // console.log(self.savedDoctor);
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
                console.log(response.data.message);
              }
            } else {
              console.log(response.data.message);
            }
          }).catch(function (error) {
            console.log(error);
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


</style>