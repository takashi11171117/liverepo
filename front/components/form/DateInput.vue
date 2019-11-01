<template>
  <b-field
    :label="label"
    :type="error.hasOwnProperty(name) ? 'is-danger': ''"
    :message="error.hasOwnProperty(name) ? error[name][0] : ''"
  >
    <b-datepicker
      :value="innerValue"
      placeholder="クリックして選択"
      icon="calendar-today"
      :month-names="$data.monthNamesOption"
      :day-names="$data.dayNamesOption"
      @input="updateValue"
    />
  </b-field>
</template>

<script lang="ts">
import { Component, Vue, Prop, Emit } from 'nuxt-property-decorator'

@Component({})
export default class DateInput extends Vue {
  @Prop() error!: Object
  @Prop({ default: new Date() }) value!: Date
  @Prop() name!: string
  @Prop() label!: string

  innerValue: Date[] = [this.value]

  @Emit()
  // eslint-disable-next-line
  input (date: Date) {}

  updateValue (date: Date) {
    this.innerValue = [date]
    this.input(date)
  }
}
</script>
