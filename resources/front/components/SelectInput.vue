<template>
    <b-field
            :label="label"
            :type="error.hasOwnProperty(name) ? 'is-danger': ''"
            :message="error.hasOwnProperty(name) ? error[name][0] : ''"
    >
        <b-select
                v-model="innerValue"
                :id="name"
                placeholder="選択する"
        >
            <option value="">選択する</option>
            <option
                    v-for="(value, key) in options"
                    :value="key"
                    :key="key">
                {{ value }}
            </option>
        </b-select>
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