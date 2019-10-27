<template>
  <b-field
    id="tagify"
    :label="label"
    :type="error.hasOwnProperty(name) ? 'is-danger': ''"
    :message="error.hasOwnProperty(name) ? error[name][0] : ''"
  >
    <Tagify
      :prop_tags="report_tags"
      :on-update="onUpdate"
    />
  </b-field>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'
import Tagify from '@/components/form/Tagify.vue'

@Component({
  components: {
    Tagify
  }
})
export default class TagifyInput extends Vue {
  @Prop() report_tags!: { text: string }[]
  @Prop() value!: Date
  @Prop() error!: Object
  @Prop() name!: string
  @Prop() label!: string
  @Prop() onUpdate!: Function
}
</script>
<style lang="sass" scoped>
    #tagify
        margin-bottom: 20px
</style>
