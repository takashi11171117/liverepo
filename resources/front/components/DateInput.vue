<template>
    <b-field
            :label="label"
            :type="error.hasOwnProperty(name) ? 'is-danger': ''"
            :message="error.hasOwnProperty(name) ? error[name][0] : ''"
    >
        <b-datepicker
                placeholder="クリックして選択"
                icon="calendar-today"
                v-model="innerValue"
                :month-names="$data.monthNamesOption"
                :day-names="$data.dayNamesOption">
        </b-datepicker>
    </b-field>
</template>
<script>
  export default {
    props: {
      error: Object,
      value: Date,
      name: String,
      label: String,
    },
    computed: {
      innerValue: {
        get() {
          if (this.value !== null) {
            console.log(this.value);
            debugger;
            return Date.format(this.value, "Y/m/d H:i:s")
          }
          return null;
        },
        set(val) {
          this.$emit('input', val)
        }
      }
    }
  }
</script>