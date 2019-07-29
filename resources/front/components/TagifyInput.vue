<template>
    <b-field
            :label="label"
            id="tagify"
            :type="error.hasOwnProperty(name) ? 'is-danger': ''"
            :message="error.hasOwnProperty(name) ? error[name][0] : ''"
    >
        <Tagify
                :prop_tags="report_tags"
                :onUpdate="onUpdate"
        />
    </b-field>
</template>
<script>
  import Tagify from '../components/Tagify';

  export default {
    props: {
      report_tags: Array,
      error: Object,
      name: String,
      label: String,
      onUpdate: {
        required: true,
        type: Function,
      }
    },
    components: {
      Tagify,
    },
  }
</script>
<style lang="sass" scoped>
    #tagify
        margin-bottom: 20px
</style>