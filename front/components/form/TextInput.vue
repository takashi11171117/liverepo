<template>
  <b-field
    :label="label"
    :type="error.hasOwnProperty(name) ? 'is-danger': ''"
    :message="error.hasOwnProperty(name) ? error[name][0] : ''"
  >
    <b-input
      :id="innerId"
      v-model="innerValue"
      :type="type"
      :placeholder="placeholder"
    />
  </b-field>
</template>
<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'

@Component({})
export default class TextInput extends Vue {
  @Prop() error!: Object
  @Prop() type!: string
  @Prop() value!: string
  @Prop() name!: string
  @Prop() id!: string
  @Prop() placeholder!: string
  @Prop() label!: string

  get innerId () {
    return this.id !== null ? this.id : this.name
  }

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
