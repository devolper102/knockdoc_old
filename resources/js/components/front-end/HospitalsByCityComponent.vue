<template>
    <div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h1>Best PMDC Verified Hospitals In {{location.title}} </h1>
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Find a Hospital</a></li>
                    <li>{{location.title}}</li>
                </ul>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <div class="form-group" style="margin:0px;">
                    <input type="search" name="search" v-model="search" placeholder="Search Speciality" class="form-control">
                </div>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h2>Top Specialists in {{location.title}}</h2>
                <ul class="grid-list">
                    <li v-for="(speciality, index) in filteredList">
                        <a :href="'/doctor/'+speciality.slug+'/'+location.slug">Best {{speciality.title}} in {{location.title}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h2>Locate the best Hospitals near me</h2>
                <ul class="grid-list">
                    <li v-for="area in areas">
                        <a :href="'/doctor/'+location.slug+'/'+area.slug">Hospitals in , {{area.title}}, {{location.title}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <!--<div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h2>Locate the best female Hospita near me</h2>
                <ul class="grid-list">
                    <li v-for="doctor in doctors" v-if="doctor.profile.gender === 'female' && doctor.location_id === this.location.id">
                        <a href="#">Female Doctors in , {{doctor.profile.address}}</a>
                    </li>
                </ul>
            </div>
        </div>-->
    </div>
</template>

<script>
    export default {
        name: "HospitalsByCityComponent",
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