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
          return this.value;
        },
        set(val) {
          this.$emit('input', val)
        }
      }
    }
  }
</script>