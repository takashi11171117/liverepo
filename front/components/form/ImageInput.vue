<template>
  <b-field
    :label="label"
    :type="error.hasOwnProperty(name) ? 'is-danger': ''"
    :message="error.hasOwnProperty(name) ? error[name][0] : ''"
  >
    <div class="file-button">
      <b-upload
        v-preview-input="preview"
        :value="innerValue"
        accept="image/*"
        @input="updateValue"
      >
        <a class="button is-primary">
          <b-icon icon="upload" />
          <span>アップロード</span>
        </a>
      </b-upload>
      <span v-if="value" class="filename">
        {{ $console(value.name) }}
      </span>
      <div v-if="value" class="preview">
        <img :src="preview">
      </div>
    </div>
  </b-field>
</template>

<script lang="ts">
import { Component, Vue, Prop, Emit } from 'nuxt-property-decorator'

@Component({})
export default class ImageInput extends Vue {
  @Prop() error!: Object
  @Prop({ default: null }) value!: File
  @Prop() name!: string
  @Prop() label!: string

  innerValue = this.value
  preview: string | null = null

  @Emit()
  // eslint-disable-next-line
  input (file: File) {}

  updateValue (file: File) {
    this.innerValue = file
    this.input(file)
  }
}
</script>

<style lang="sass" scoped>
.file-button
    display: flex
    margin-bottom: 10px
    flex-direction: column
img
    width: 80px
    object-fit: cover
.filename,
.preview
    margin-top: 10px
    font-size: 12px
</style>
