<template>
  <b-field
    :label="label"
    :type="error.hasOwnProperty(name) ? 'is-danger': ''"
    :message="error.hasOwnProperty(name) ? error[name][0] : ''"
  >
    <b-radio
      v-for="(value, key) in options"
      :key="key"
      v-model="innerValue"
      :native-value="key"
    >
      {{ value }}
    </b-radio>
  </b-field>
</template>
<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'

@Component({})
export default class RadioInput extends Vue {
  @Prop() error!: Object
  @Prop() options!: Object
  @Prop() value!: string
  @Prop() name!: string
  @Prop() label!: string

  get innerValue (): string {
    return this.value
  }

  set innerValue (newValue: string) {
    if (this.value !== newValue) {
      this.$emit('input', newValue)
    }
  }
}
</script>
