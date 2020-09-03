<template>
  <div>
<!--    <vue-google-places
        :api-key="'AIzaSyCTtKFT6ROLiapWLQf-ATNCdy5fn_VJ68s'"
        class="subheading"
        types="(areas)"
        country="pk"
        @placechanged="getAddressData"
    >
    </vue-google-places>-->

    <vuetify-google-autocomplete
        id="map"
        append-icon="search"
        :place-name="true"
        v-bind:disabled="false"
        placeholder="Start typing"
        v-on:placechanged="getAddressData"
        value="hello"
        country="pk"
    >
    </vuetify-google-autocomplete>



    <vue-autosuggest
        @click="clickHandler"
        @input="fetchResults"
        v-model="query"
        :suggestions="suggestions"
        :inputProps="inputProps"
        :sectionConfigs="sectionConfigs"
        :renderSuggestion="renderSuggestion"
        :getSuggestionValue="getSuggestionValue"
    >
    </vue-autosuggest>

  </div>
</template>

<script>

import Vue from 'vue';
import Geocoder from "@pderas/vue2-geocoder";
import VuetifyGoogleAutocomplete from 'vuetify-google-autocomplete';

Vue.use(VuetifyGoogleAutocomplete, {
  apiKey: 'AIzaSyCTtKFT6ROLiapWLQf-ATNCdy5fn_VJ68s', // Can also be an object. E.g, for Google Maps Premium API, pass `{ client: <YOUR-CLIENT-ID> }`
  version: '...', // Optional
  language: 'en', // Optional
});
Vue.use(Geocoder, {
  defaultCountryCode: 'pk', // e.g. 'CA'
  defaultLanguage:    'en', // e.g. 'en'
  defaultMode:        'address', // or 'lat-lng'
  googleMapsApiKey:   'AIzaSyCTtKFT6ROLiapWLQf-ATNCdy5fn_VJ68s'
});


export default {
name: "HomePageComponent",
  props: ['location','doctors','hospitals','laboratory','specialities','services','diseases'],
  data() {
    return {
      query: "",
      results: [],
      timeout: null,
      selected: null,
      debounceMilliseconds: 250,
      usersUrl: "https://jsonplaceholder.typicode.com/users",
      photosUrl: "https://jsonplaceholder.typicode.com/photos",
      inputProps: {
        id: "autosuggest__input",
        placeholder: "Search...",
        class: "form-control",
        name: "hello"
      },
      suggestions: [],
      sectionConfigs: {

        hospitals: {
          limit: 4,
          label: "Hospitals",
          onSelected: selected => {
            this.selected = selected.item;
          }
        },
        doctors: {
          limit: 4,
          label: "Doctors",
          onSelected: selected => {
            this.selected = selected.item;
          }
        },
        laboratory: {
          limit: 4,
          label: "Laboratory",
          onSelected: selected => {
            this.selected = selected.item;
          }
        },
        specialities: {
          limit: 4,
          label: "Specialities",
          onSelected: selected => {
            this.selected = selected.item;
          }
        },
        services: {
          limit: 4,
          label: "Services",
          onSelected: selected => {
            this.selected = selected.item;
          }
        },
        diseases: {
          limit: 4,
          label: "Diseases",
          onSelected: selected => {
            this.selected = selected.item;
          }
        },
      }
    }
  },
  created() {
  console.log('hello')
    this.getCityname()
  },
  mounted() {

  },
  methods: {
    fetchResults() {
      const query = this.query;

      clearTimeout(this.timeout);
      this.timeout = setTimeout(() => {

        Promise.all([this.doctors, this.hospitals, this.laboratory, this.specialities, this.services, this.diseases]).then(values => {
          this.suggestions = [];
          this.selected = null;

          const doctorsData = this.filterResults(values[0], query, "first_name", "last_name");
          const hospitalsData = this.filterResults(values[1], query, "first_name", "last_name");
          const labData = this.filterResults(values[2], query, "first_name", "last_name");
          const specialitiesData = this.filterResults(values[3], query, "title");
          const servicesData = this.filterResults(values[4], query, "title");
          const diseasesData = this.filterResults(values[5], query, "title");

          doctorsData.length && this.suggestions.push({ name: "doctors", data: doctorsData });
          hospitalsData.length && this.suggestions.push({ name: "hospitals", data: hospitalsData });
          labData.length && this.suggestions.push({ name: "laboratory", data: labData });
          specialitiesData.length && this.suggestions.push({ name: "specialities", data: specialitiesData });
          servicesData.length && this.suggestions.push({ name: "services", data: servicesData });
          diseasesData.length && this.suggestions.push({ name: "diseases", data: diseasesData });

        });
      }, this.debounceMilliseconds);
    },
    filterResults(data, text, field, field2) {
      return data
          .filter(item => {
            if (item[field].toLowerCase().indexOf(text.toLowerCase()) > -1) {
              return item[field];
            }
            if (item[field2].toLowerCase().indexOf(text.toLowerCase()) > -1) {
              return item[field2];
            }
          })
          .sort();
    },
    renderSuggestion(suggestion) {
      console.log(suggestion.name)
      if (suggestion.name === "doctors") {
        const image = suggestion.item;
        return image.first_name + ' ' + image.last_name
      }
      if (suggestion.name === "hospitals") {
        const image = suggestion.item;
        return image.first_name + ' ' + image.last_name
      }
      if (suggestion.name === "laboratory") {
        const image = suggestion.item;
        return image.first_name + ' ' + image.last_name
      }
      if (suggestion.name === "specialities") {
        const image = suggestion.item;
        return image.title
      }
      if (suggestion.name === "services") {
        const image = suggestion.item;
        return image.title
      }
      if (suggestion.name === "diseases") {
        const image = suggestion.item;
        return image.title
      }
      else {
        return suggestion.item.name;
      }
    },
    getSuggestionValue(suggestion) {
      console.log(suggestion)
      let { name, item } = suggestion;
      return name == "hotels" ? item.title : item.name;
    },
    clickHandler() {
      this.fetchResults();
    },
    getAddressData (addressData, placeResultData, id) {
      // this.address = addressData;
      console.log(addressData, placeResultData, id)
    },
    getCityname() {
      let self = this
      navigator.geolocation.getCurrentPosition(function(position) {
        self.get_city(position.coords)
      });
    },
    get_city(coords) {
      if (coords.latitude !== '' && coords.longitude !== '') {
        var latLngObj = {
          lat: coords.latitude,
          lng: coords.longitude
        }
        Vue.$geocoder.send(latLngObj, response => {
          console.log('hi: ',response)
          if (response.status === "OK") {
            _.each(response.results[0].address_components, function(component) {
              _.each(component.types, function(type) {
                console.log(component, type)
                if (type === "locality") {
                  $('#submitCityValue').val(component.long_name);
                }
              })
            })
          }
        });
      }
    }
  },
  watch: {

  }
}
</script>

<style>

</style>