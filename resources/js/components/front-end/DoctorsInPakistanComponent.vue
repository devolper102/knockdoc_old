<template>
    <div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h1>Best PMDC Verified Doctors In Pakistan </h1>
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li>Find a Doctor</li>
                </ul>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <div class="form-group" style="margin:0px;">
                    <input type="search" v-model="search" name="search" placeholder="Search City" class="form-control">
                </div>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h2>Doctors in Top Cities</h2>
                <ul class="grid-list">
                    <li v-for="(doctor, index) in doctors" v-if="doctor.top === '1'">
                        <a :href="'/doctors/'+doctor.slug">Doctors in <span style="color: #c02942">{{doctor.title}}</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h2>Doctors in Other Cities</h2>
                <ul class="grid-list">
                    <li v-for="(doctor, index) in filteredList" v-if="doctor.top === null">
                        <a :href="'/doctors/'+doctor.slug">Doctors in <span style="color: #c02942">{{doctor.title}}</span></a>
                    </li>
                </ul>
            </div>
        </div>
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
                <button class="mt-4 dc-btn consult_btn">How to consult online?</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['doctorsLocation','topSpecialitiesData'],
        data() {
            return{
                doctors: this.doctorsLocation,
                search: '',
            }
        },
        created() {
            console.log(this.doctors)
        },
        mounted() {

        },
        computed: {
            filteredList() {
                return this.doctors.filter(doctor => {
                    return doctor.title.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        },
        methods: {},
    }
</script>

<style scoped>

</style>