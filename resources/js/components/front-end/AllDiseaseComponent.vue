<template>
    <div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <h1>Find a Doctor by Disease</h1>
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li>Find a Doctor by Disease</li>
                </ul>
            </div>
        </div>
        <div class="row mt-2 bg-white padding">
            <div class="col-12">
                <div class="form-group" style="margin:0px;">
                    <input type="search" v-model="search" name="search" placeholder="Search Disease" class="form-control">
                </div>
            </div>
        </div>
        <div class="row mt-2 bg-white padding" v-for="speciality in filteredList">
            <div class="col-12">
                <h2>{{speciality.title}}</h2>
                <div v-for="service in speciality.services_diseases">
                    <h3 class="mt-2">{{service.title}}</h3>
                    <ul class="grid-list">
                        <li v-for="symptom in service.diseases">
                            <a :href="'/diseases/'+symptom.slug">{{symptom.title}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  export default {
    name: "AllDiseaseComponent",
    props: ['specialitiesData',],
    data() {
      return {
        specialities: this.specialitiesData,
        search: '',
      }
    },
    created() {},
    mounted() {},
    computed: {
      filteredList() {
        return this.specialities.filter(specialty => {
          return specialty.services_diseases.some(service => {
            return service.diseases.some(disease => {
              return disease.title.toLowerCase().includes(this.search.toLowerCase())
            })
          })
        })
      },
    },
    methods: {},
  }
</script>
<style>

</style>