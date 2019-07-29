<template>
    <b-field
            :label="label"
            :type="error.hasOwnProperty(name) ? 'is-danger': ''"
            :message="error.hasOwnProperty(name) ? error[name][0] : ''"
    >
        <b-input :id="innerId"
                 v-model="innerValue"
                 :type="type"
                 :placeholder="placeholder">
        </b-input>
    </b-field>
</template>
<script>
  export default {
    props: {
      error: Object,
      type: String,
      value: String,
      name: String,
      id: String,
      placeholder: String,
      label: String,
    },
    data () {
      let innerId;
      this.id !== null ? innerId = this.id : innerId = this.name;

      return {
        innerId
      }
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