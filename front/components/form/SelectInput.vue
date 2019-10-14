<template>
  <b-field
    :label="label"
    :type="error.hasOwnProperty(name) ? 'is-danger': ''"
    :message="error.hasOwnProperty(name) ? error[name][0] : ''"
  >
    <b-select
      :id="name"
      v-model="innerValue"
      placeholder="選択する"
    >
      <option value="">
        選択する
      </option>
      <option
        v-for="(value, key) in options"
        :key="key"
        :value="key"
      >
        {{ value }}
      </option>
    </b-select>
  </b-field>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'

@Component({})
export default class SelectInput extends Vue {
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
