<template>
    <div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h1>Best Hospitals In Pakistan | Doctors Lists, Addresses And Contact Info</h1>
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li>Find a Hospital</li>
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
                <h2>Hospitals in Top Cities</h2>
                <ul class="grid-list">
                    <li v-for="(hospital, index) in hospitals" v-if="index < 5">
                        <a :href="'/hospitals/'+hospital.slug">Doctors in <span style="color: #c02942">{{hospital.title}}</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h2>Hospitals in Other Cities</h2>
                <ul class="grid-list">
                    <li v-for="(hospital, index) in filteredList">
                        <a :href="'/hospitals/'+hospital.slug">Doctors in <span style="color: #c02942">{{hospital.title}}</span></a>
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
        props: ['hospitalsLocation', 'topSpecialitiesData'],
        data() {
            return{
                hospitals: this.hospitalsLocation,
                search: '',
            }
        },
        created() {},
        mounted() {},
        computed: {
            filteredList() {
                return this.hospitals.filter(hospital => {
                    return hospital.title.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        },
        methods: {},
    }
</script>

<style scoped>

</style>