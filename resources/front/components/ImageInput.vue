<template>
    <b-field
            :label="label"
            :type="error.hasOwnProperty(name) ? 'is-danger': ''"
            :message="error.hasOwnProperty(name) ? error[name][0] : ''"
    >
        <div class="file-button">
            <b-upload
                    :v-model="value"
                    v-preview-input="preview"
                    accept="image/*"
                    @input="updateValue"
            >
                <a class="button is-primary">
                    <b-icon icon="upload"></b-icon>
                    <span>アップロード</span>
                </a>
            </b-upload>
            <span class="filename" v-if="value">
                    {{ value.name }}
            </span>
            <div v-if="value" class="preview">
                <img :src="preview">
            </div>
        </div>
    </b-field>
</template>
<script>
  export default {
    data() {
      return {
        preview: null
      }
    },
    props: {
      error: Object,
      name: String,
      value: {type: File, default: null},
      label: String
    },
    methods: {
      updateValue: function(file) {
        this.$emit("input", file);
      }
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