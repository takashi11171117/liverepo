<template>
  <b-field
    :label="label"
    :type="error.hasOwnProperty(name) ? 'is-danger': ''"
    :message="error.hasOwnProperty(name) ? error[name][0] : ''"
  >
    <b-datepicker
      v-model="innerValue"
      placeholder="クリックして選択"
      icon="calendar-today"
      :month-names="$data.monthNamesOption"
      :day-names="$data.dayNamesOption"
    />
  </b-field>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'

@Component({})
export default class DateInput extends Vue {
  @Prop() error!: Object
  @Prop() value!: Date
  @Prop() name!: string
  @Prop() label!: string

  get innerValue (): Date {
    return this.value
  }

  set innerValue (newValue: Date) {
    if (this.value !== newValue) {
      this.$emit('input', newValue)
    }
  }
}
</script>
