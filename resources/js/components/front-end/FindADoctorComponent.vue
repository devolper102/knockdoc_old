<template>
    <div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h1>Find PMDC Verified Doctors In Pakistan </h1>
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li>Find a Doctor</li>
                </ul>
            </div>
        </div>
        <!--<div class="row mt-2 bg-white padding">
            <div class="col-12">
                <div class="form-group" style="margin:0px;">
                    <input type="search" name="search" placeholder="search doctor in hospital" class="form-control">
                </div>
            </div>
        </div>-->
        <!--<div class="row mt-2 bg-white padding">
            <div class="col-12">
                <ul class="grid-list">
                    <li class="searchable" v-for="service in services">
                        <a :href="'/doctors/'+service" class="speciality" data-toggle="modal"> {{service.title}} <i class="fa fa-angle-down"></i></a>
                    </li>
                </ul>
            </div>
        </div>-->
        <!--Consult Online Banner-->
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h1><i class="fa fa-circle"></i> Consult doctor online from your home</h1>
                <small>Save time &amp; money and consult doctor through phone</small>
                <ul class="list-cards mt-2">
                    <li v-for="(speciality, index) in topSpecialitiesData" v-if="speciality.top === '1' && index < 6">
                        <a :href="'/speciality/'+speciality.slug">
                            <div class="display-block">
                                <img v-bind:src="'/uploads/specialities/'+speciality.image" alt="">
                                <div class="divider"></div>
                                <div class="card-content">
                                    <p class="label-big"><small><i class="fa fa-circle"></i></small> {{speciality.title}}</p>
                                    <small>95% satisfied patients</small>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
                <button class="mt-4 d-block d-sm-none button-main"  style="width: 100%;">How to consult online?</button>
                <button class="mt-4 dc-btn consult_btn" >How to consult online?</button>
            </div>
        </div>
        <!--Banner ends-->
        <div :id="'speciality'+speciality.id" class="row mt-2 bg-white padding" v-for="speciality in specialities">
            <div class="col-12">
                <h2><a :href="'speciality/'+speciality.slug">{{speciality.title}} in Pakistan</a></h2>
                <ul class="grid-list">
                    <li v-for="location in speciality.locations">
                        <a :href="'doctor/'+location.slug+'/'+speciality.slug" title="click and you will see doctors">{{speciality.title}}<span class="red-text"> in {{location.title}}</span> <i class="fa fa-angle-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FindADoctorComponent",
        props: ['specialitiesData','topSpecialitiesData', 'servicesData',],
        data() {
            return{
                specialities: this.specialitiesData,
                services: this.servicesData,
                search: '',
            }
        },
        created() {},
        mounted() {},
        computed: {
            filteredList() {
                return this.specialities.filter(speciality => {
                    return speciality.title.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        },
        methods: {},
    }
</script>

<style scoped>

</style>