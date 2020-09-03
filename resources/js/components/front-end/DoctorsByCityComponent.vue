<template>
    <div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h1>Best PMDC Verified Doctors In {{this.location.title}} </h1>
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Find a Doctor</a></li>
                    <li>{{this.location.title}}</li>
                </ul>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <div class="form-group" style="margin:0px;">
                    <input type="search" name="search" v-model="search" :placeholder="'Search Top Specialist ' + this.location.title" class="form-control">
                </div>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h2>Top Specialists in {{location.title}}</h2>
                <ul class="grid-list">
                    <li v-for="speciality in filteredList" v-if="specialities.length > 0">
                        <a :href="'/doctor/'+speciality.slug+'/'+location.slug">Best {{speciality.title}} in {{location.title}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h2>Locate the best doctor near me</h2>
                <ul class="grid-list">
                    <li v-for="area in areas" v-if="areas.length > 0">
                        <a :href="'/doctor/'+location.slug+'/'+area.slug">Doctors in , {{area.title}} {{location.title}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h2>Locate the best female doctor near me</h2>
                <ul class="grid-list">
                    <li v-for="doctor in doctors" v-if="doctor.profile.gender === 'female' && doctor.location_id === location.id && doctors.length > 0" >
                        <a :href="'/doctor/'+doctor.location.slug+'/'+doctor.profile.address">Female Doctors in , {{doctor.profile.address}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DoctorsByCityComponent",
        props: ['specialityDoctors', 'locationData', 'areasData', 'doctorsData'],
        data() {
            return{
                specialities: this.specialityDoctors,
                doctors: this.doctorsData,
                location: this.locationData,
                areas: this.areasData,
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