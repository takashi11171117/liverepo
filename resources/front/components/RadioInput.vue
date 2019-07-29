<template>
    <b-field
            :label="label"
            :type="error.hasOwnProperty(name) ? 'is-danger': ''"
            :message="error.hasOwnProperty(name) ? error[name][0] : ''"
    >
        <b-radio
                v-for="(value, key) in options"
                v-model="innerValue"
                :native-value="key"
                :key="key"
        >
            {{ value }}
        </b-radio>
    </b-field>
</template>
<script>
  export default {
    props: {
      error: Object,
      options: Object,
      value: String,
      name: String,
      label: String,
    },
    computed: {
      innerValue: {
        get() {
          return this.value
        },
        set(val) {
          this.$emit('input', val)
        }
      }
    }
  }
</script>