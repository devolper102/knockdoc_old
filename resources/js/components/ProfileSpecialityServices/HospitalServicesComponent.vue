<template>
    <div class="form-group">
        <label style="display:inline-block">
            <input type="checkbox" name="hospital_icu" class="willing_home_visit" :checked="this.hospital_icu"> ICU
        </label>
        <label style="display:inline-block; margin-left: 20px">
            <input type="checkbox" name="hospital_emergency" class="willing_home_visit" :checked="this.hospital_emergency"> Emergency
        </label>
        <label style="display:inline-block; margin-left: 20px">
            <input type="checkbox" name="hospital_ventilator" class="willing_home_visit" :checked="this.hospital_ventilator"> Ventilator
        </label>
        <label style="display:inline-block; margin-left: 20px">
            <input type="checkbox" name="hospital_24_service" class="willing_home_visit" :checked="this.hospital_24_service"> 24 Hours Service
        </label>
    </div>
</template>

<script>
  export default {
        props: ['hospital_icu','hospital_emergency','hospital_ventilator','hospital_24_service'],
    created() {
    },
    data() {
      return {
      }
    },
    methods: {

    },

  }
</script>
